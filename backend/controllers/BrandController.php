<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/7
 * Time: 14:51
 */
namespace backend\controllers;
use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\widgets\LinkPager;
use flyok666\uploadifive\UploadAction;
use flyok666\qiniu\Qiniu;
use backend\filters\RbacFiler;

class BrandController extends Controller{
    public function actionIndex(){
        $pager=new Pagination([
            'totalCount'=>Brand::find()->count(),
            'defaultPageSize'=>3

        ]);
        $brands=Brand::find()->where(['!=','status',-1])->orderBy('sort')->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['brands'=>$brands,'pager'=>$pager]);
    }
    public function actionAdd(){
        $brand=new Brand();
        $request=\yii::$app->request;
        if($request->getIsPost()){
            $brand->load($request->post());
            if($brand->validate()){
                $brand->save();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/index']);
            }
        }
        return $this->render('add',['brand'=>$brand]);
    }
    public function actionDelete(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $brand=Brand::find()->where(['id'=>$id])->one();
        $brand->status= -1;
       if($brand->save(false)){
        echo  json_encode(true);
       }else{
           var_dump($brand->getErrors());exit;
       } ;
    }
    public function actionEdit(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $brand=Brand::find()->where(['id'=>$id])->one();
        $request=\yii::$app->request;
        if($request->getIsPost()){
            $brand->load($request->post());
            if($brand->validate()){
                $brand->save();
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['brand/index']);
            }
        }
         return $this->render('add',['brand'=>$brand]);

    }


    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
//                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filename = sha1_file($action->uploadfile->tempName);
//                    return "{$filename}.{$fileext}";
//                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
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
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"

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
                    $action->output['fileUrl'] =$url;




                },
            ],
        ];
    }
    public function behaviors(){

        return [
            'rbac'=>[
                'class'=>RbacFiler::className(),
                'except'=>['login','logout','captcha','error']
            ]
        ];
    }



}