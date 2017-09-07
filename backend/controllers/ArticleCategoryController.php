<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/7
 * Time: 16:32
 */
namespace backend\controllers;
use backend\models\ArticleCategory;
use yii\web\Controller;

class ArticleCategoryController extends Controller{
    public function actionIndex(){
        $articlecategorys=\backend\models\ArticleCategory::find()->where(['!=','status','-1'])->all();
        return $this->render('index',['articlecategorys'=>$articlecategorys]);
    }
    public function actionAdd(){
        $articlecategory=new ArticleCategory();
        $request=\yii::$app->request;
        if($request->getIsPost()){
            $articlecategory->load($request->post());
            if($articlecategory->validate()){
                $articlecategory->save();
                \yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article-category/index']);
            }
        }
        return $this->render('add',['articlecategory'=>$articlecategory]);
    }
    public function actionDelete(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $articlecategory=ArticleCategory::find()->where(['id'=>$id])->one();
        $articlecategory->status='-1';
        $articlecategory->save();

        \yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['article-category/index']);
    }
    public function actionEdit(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $articlecategory=ArticleCategory::find()->where(['id'=>$id])->one();
        $request=\yii::$app->request;
        if($request->getIsPost()){
            $articlecategory->load($request->post());
            if( $articlecategory->validate()){

                $articlecategory->save();
                \yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['article-category/index']);
            }
        }
        return $this->render('add',['articlecategory'=> $articlecategory]);

    }

}