<?php

namespace backend\controllers;
use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\GoodsSearch;
use flyok666\qiniu\Qiniu;
use flyok666\uploadifive\UploadAction;
use yii\data\Pagination;
use yii\web\Controller;
use backend\filters\RbacFiler;

class GoodsController extends Controller{
    //列表
    public function actionIndex(){
        $seach=new GoodsSearch();
          $request=\yii::$app->request;
          $seach->load($request->post());
          $seek=GoodsSearch::getSeek($seach);
          $count=$seek->count();
        $pager=new Pagination([
            'totalCount'=> $count,
            'defaultPageSize'=>3
        ]);
        $goods=$seek->limit($pager->limit)->offset($pager->offset)->all();
     return   $this->render('index',['goods'=>$goods,'pager'=>$pager,'seach'=>$seach]);
    }
    //添加
    public function actionAdd(){
    $goods=new Goods();
    $brand=Brand::find()->all();
    $intro=new GoodsIntro();
    $request=\yii::$app->request;
        if($request->getIsPost()){
            $intro->load($request->post());
            $goods->load($request->post());
            //验证成功则保存
            if($goods->validate() && $intro->validate() ){

                $count=GoodsDayCount::find()->where(['day'=>date('Ymd')])->one();
               if($count){
                   $count->count += 1;
                   $goods->sn=$count->day.sprintf('%04d',$count->count);
               }else{
                   $count=new GoodsDayCount();
                   $count->day=date('Ymd');
                   $count->count=1;
                   $goods->sn=date('Ymd').sprintf('%04d',1);
               }
                $count->save(false);
                $goods->save(false);
                $intro->goods_id=$goods->id;
                $intro->save();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods/index']);
            }
        }
     return $this->render('add',['goods'=>$goods,'brand'=>$brand,'intro'=>$intro]);
    }
    public function actions() {
//嵌套插件
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default

                'overwriteIfExist' => true,

                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
//                    $action->output['fileUrl'] = $action->getWebUrl();
// 七牛云插件
                    $config = [
                        'accessKey'=>'3Rb5L__359fc9kv3xvzurAqXjDLXIv02aK2S63JY',
                        'secretKey'=>'HR5DGIo8b1HWDmzdKJNUjo0HElfTpQCPytPQeLuk',
                        'domain'=>'http://ovyd8ive2.bkt.clouddn.com/',
                        'bucket'=>'yiishop',
                        'area'=>Qiniu::AREA_HUADONG
                    ];

                    $qiniu = new Qiniu($config);
                    $key = $action->getWebUrl();
                    $file=$action->getSavePath();
                    $qiniu->uploadFile($file,$key);
                    $url = $qiniu->getLink($key);

                    $photo=new GoodsGallery();
                    if($_REQUEST['goods_id']){
                        $photo->goods_id=$_REQUEST['goods_id'];
                        $photo->path=$url;
                        $photo->save();
                   }

                    $action->output['fileUrl'] =$url;

                },
            ],
//百度编辑器
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
    //修改
    public function actionDelete($id){
        $goods=Goods::find()->where(['id'=>$id])->one();
        $goods->delete();
        $intro=GoodsIntro::findOne(['goods_id'=>$id]);
        $intro->delete();
        return $this->redirect(['goods/index']);
    }
    public function actionEdit($id){
        $request=\yii::$app->request;
        $goods=Goods::find()->where(['id'=>$id])->one();
        $intro=GoodsIntro::find()->where(['goods_id'=>$id])->one();
        $brand=Brand::find()->all();
        if($request->getIsPost()){
            $intro->load($request->post());
            $goods->load($request->post());
            //验证成功则保存
            if($goods->validate() && $intro->validate() ){

                $count=GoodsDayCount::find()->where(['day'=>date('Ymd')])->one();
                if($count){
                    $count->count += 1;
                    $goods->sn=$count->day.sprintf('%04d',$count->count);
                }else{
                    $count=new GoodsDayCount();
                    $count->day=date('Ymd');
                    $count->count=1;
                    $goods->sn=date('Ymd').sprintf('%04d',1);
                }
                $count->save();
                $goods->save();
                $intro->goods_id=$goods->id;
                $intro->save();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods/index']);
            }else{
                var_dump($goods->getErrors());exit;
            }
        }

        return $this->render('add',['goods'=>$goods,'brand'=>$brand,'intro'=>$intro]);
    }
    public function actionPhoto($id){
        $photos=GoodsGallery::find()->where(['goods_id'=>$id])->all();
        return $this->render('photo',['photos'=>$photos,'goods_id'=>$id]);
    }
    public function actionPhotodel($id,$gid){
        $photo=GoodsGallery::find()->where(['id'=>$id])->one();
        if($photo->delete()){
        \yii::$app->session->setFlash('success','删除成功');
    }else{
         \yii::$app->session->setFlash('success','删除失败');
        }
        return  $this->redirect(['goods/photo','id'=>$gid]);
    }
    public function actionShow($id){
           $photo=GoodsGallery::find()->where(['goods_id'=>$id])->all();
        $count=GoodsGallery::find()->count();
        $intro=GoodsIntro::find()->where(['goods_id'=>$id])->one();
        return $this->render('show',['photo'=>$photo,'count'=>$count,'intro'=>$intro]);
    }
    public function behaviors(){

        return [
            'rbac'=>[
                'class'=>RbacFiler::className(),
                'except'=>['login','logout','captcha','error','upload','s-upload','photo']
            ]
        ];
    }
}