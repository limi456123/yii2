<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/7
 * Time: 14:51
 */
namespace backend\controllers;
use backend\models\Brand;
use yii\web\Controller;
use yii\web\UploadedFile;

class BrandController extends Controller{
    public function actionIndex(){
        $brands=Brand::find()->where(['!=','status','-1'])->all();
        return $this->render('index',['brands'=>$brands]);
    }
    public function actionAdd(){
        $brand=new Brand();
        $request=\yii::$app->request;
        if($request->getIsPost()){
            $brand->load($request->post());
            $brand->file=UploadedFile::getInstance($brand,'file');
            if($brand->validate()){
                if($brand->file){
                $file='/upload/'.uniqid().'.'.$brand->file->getExtension();
                $brand->file->saveAs(\yii::getAlias('@webroot').$file,false);
                $brand->logo=$file;
                }
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
        $brand->status='-1';
        $brand->save();

        \yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['brand/index']);
    }
    public function actionEdit(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $brand=Brand::find()->where(['id'=>$id])->one();
        $request=\yii::$app->request;
        if($request->getIsPost()){
            $brand->load($request->post());
            $brand->file=UploadedFile::getInstance($brand,'file');
            if($brand->validate()){
                if($brand->file){
                    $file='/upload/'.uniqid().'.'.$brand->file->getExtension();
                    $brand->file->saveAs(\yii::getAlias('@webroot').$file,false);
                    $brand->logo=$file;
                }
                $brand->save();
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['brand/index']);
            }
        }
         return $this->render('add',['brand'=>$brand]);

    }

}