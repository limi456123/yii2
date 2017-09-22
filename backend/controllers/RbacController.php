<?php

namespace backend\controllers;

use backend\models\Rbacform;
use backend\models\Rolesform;
use backend\filters\RbacFiler;

class RbacController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $auth=\Yii::$app->authManager;
        $models=$auth->getPermissions();

        return $this->render('index',['models'=>$models]);
    }

    public function actionAdd(){
        $auth=new Rbacform();
        $auth->scenario=Rbacform::SCENARIO_ADD;
        $request=\Yii::$app->request;
        if($request->isPost){
            $auth->load($request->post());
            if($auth->validate()){
              $model=\Yii::$app->authManager;
                $auths=$model->createPermission($auth->name);
                $auths->description=$auth->describe;
                $model->add($auths);
              return $this->redirect(['rbac/index']);
            }else{
                var_dump($auth->getErrors());exit;
            }
        }
        return $this->render('add',['auth'=>$auth]);
    }
    public function actionDelete($name){
        $auth=\Yii::$app->authManager;
        $model=$auth->getPermission($name);
        $auth->remove($model);
        return $this->redirect(['rbac/index']);
    }
    public function actionEdit($name){
         $rbac=\Yii::$app->authManager;
         $rba=$rbac->getPermission($name);
         $auth=new Rbacform();
        $auth->scenario=Rbacform::SCENARIO_EDIT;
        $request=\Yii::$app->request;
        if($request->isPost){
            $auth->load($request->post());
            if($auth->validate()){

                  $rba->name=$auth->name;
                   $rba->description=$auth->describe;
                   $rbac->update($name,$rba);

                return $this->redirect(['rbac/index']);
            }
        }
        $auth->name=$rba->name;
        $auth->describe=$rba->description;
        return $this->render('add',['auth'=>$auth] );
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
