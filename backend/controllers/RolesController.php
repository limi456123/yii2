<?php
namespace backend\controllers;
use backend\models\Rolesform;
use yii\web\Controller;

class RolesController extends Controller{
    public function actionAdd(){
        $model=new Rolesform();
        return $this->render('add',['model'=>$model]);
    }
}