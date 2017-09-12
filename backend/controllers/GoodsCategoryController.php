<?php
namespace backend\controllers;
use backend\models\GoodsCategory;
use yii\web\Controller;

class GoodsCategoryController extends Controller{
    //列表
    public function actionIndex(){
        $goodscategorys=GoodsCategory::find()->all();
        return $this->render('index',['goodscategorys'=> $goodscategorys]);

    }
    //添加
    public function actionAdd(){
        $category=new GoodsCategory();
        $request=\yii::$app->request;
        if($request->getIsPost()){
            $category->load($request->post());
            if($category->validate()){
               if($category->parent_id){
                   $parent=GoodsCategory::findOne(['id'=>$category->parent_id]);
                   $category->prependTo($parent);
               }else{
                   $category->makeRoot();
               }
               return $this->redirect(['goods-category/index']);
            }
        }
        return $this->render('add',['category'=>$category]);
    }
    //删除
    public function actionDelete(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $category=GoodsCategory::find()->where(['id'=>$id])->one();
        if($category->isLeaf()){
            $category->deleteWithChildren();
            \yii::$app->session->setFlash('success','删除成功');
        }else{
            \yii::$app->session->setFlash('success','不能删除');
        }
        return $this->redirect(['goods-category/index']);
    }
    //修改
    public function actionEdit(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $category=GoodsCategory::find()->where(['id'=>$id])->one();
        if($request->getIsPost()){
            $category->load($request->post());
            if($category->validate()){
                if($category->parent_id){
                    $parent=GoodsCategory::findOne(['id'=>$category->parent_id]);
                    $category->prependTo($parent);
                }else{
                    if($category->getOldAttribute('parent_id')){
                        $category->save();
                    }else{
                        $category->makeRoot();
                    }

                }
                return $this->redirect(['goods-category/index']);
            }
        }
        return $this->render('add',['category'=>$category]);
    }
}