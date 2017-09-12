<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
       $articles=Article::find()->where(['!=','status','-1'])->all();

        return $this->render('index',['articles'=>$articles]);
    }
    public function actionAdd(){
        $article=new Article();
        $articledetail=new ArticleDetail();
        $articlecategory=ArticleCategory::find()->all();
        $request=\yii::$app->request;
        if($request->getIsPost()){
            $article->load($request->post());
            $articledetail->load($request->post());
            if($article->validate() &&  $articledetail->validate()){
                $article->save();
               $id= \Yii::$app->db->getLastInsertID();
                $articledetail->article_id= $id;
                     $articledetail->save();

                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['article'=>$article,'articledetail'=> $articledetail,'articlecategory'=>$articlecategory]);
    }
    public function actionDelete(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $article=Article::find()->where(['id'=>$id])->one();
        $article->status='-1';
       if($article->save()){
           echo json_encode(true);
       }

    }
    public function actionEdit(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $article=Article::find()->where(['id'=>$id])->one();
        $articledetail=ArticleDetail::find()->where(['article_id'=>$id])->one();
        $articlecategory=ArticleCategory::find()->all();
        if($request->getIsPost()){
            $article->load($request->post());
            $articledetail->load($request->post());
            if($article->validate() &&  $articledetail->validate()){
                $article->save();

                $articledetail->article_id=$id ;
                $articledetail->save();

                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['article'=>$article,'articledetail'=> $articledetail,'articlecategory'=>$articlecategory]);

    }
    public function actionShow(){
        $request=\yii::$app->request;
        $id=$request->get('id');
        $articledetail=ArticleDetail::find()->where(['article_id'=>$id])->one();
        return $this->render('show',['articledetail'=> $articledetail]);
    }
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
}
