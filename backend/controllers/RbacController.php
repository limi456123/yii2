<?php

namespace backend\controllers;

use backend\models\Rbacform;

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
        $request=\Yii::$app->request;
        if($request->isPost){
            $auth->load($request->post());
            if($auth->validate()){
              $rbac->remove($rba);
             $rbc=$rbac->createPermission($auth->name);
            $rbc->description=$auth->describe;
              $rbac->add($rbc);
                return $this->redirect(['rbac/index']);
            }
        }
        $auth->name=$rba->name;
        $auth->describe=$rba->description;
        return $this->render('add',['auth'=>$auth] );
    }
}
