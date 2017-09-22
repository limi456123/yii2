<?php
namespace backend\controllers;
use backend\models\Rolesform;
use yii\web\Controller;
use backend\filters\RbacFiler;

class RolesController extends Controller{
    public function actionAdd(){
        $model=new Rolesform();
        $model->scenario=Rolesform::SCENARIO_ADD;
        $request=\Yii::$app->request;
        if($request->isPost){
           $model->load($request->post());
            if($model->validate()){
                $auth=\Yii::$app->authManager;
                $rbac=$auth->createRole($model->name);
                $rbac->description=$model->describe;
                $auth->add($rbac);
                if($model->authority){
                    foreach($model->authority as $thority){
                       $quan= $auth->getPermission($thority);
                        $auth->addChild($rbac,$quan);

                    }
                }
                return $this->redirect(['roles/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionIndex(){
        $roles=\Yii::$app->authManager;
        $modles=$roles->getRoles();
        return $this->render('index',['models'=>$modles]);
    }
    public function actionDelete($name){
        $auth=\Yii::$app->authManager;
        $roles=$auth->getRole($name);
        $auth->remove($roles);
        return $this->redirect(['roles/index']);
    }
    public function actionEdit($name){
        $model=new Rolesform();
        $model->scenario=Rolesform::SCENARIO_EDIT;
        $auth=\Yii::$app->authManager;
        $roles=$auth->getRole($name);
        $model->name=$roles->name;
        $model->describe=$roles->description;
       $perm=\Yii::$app->authManager->getPermissionsByRole($name);
        $model->authority=array_keys($perm);
          $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                   $roles->name=$model->name;
                    $roles->description= $model->describe;
                   $auth->update($name,$roles);
                $auth->removeChildren($roles);
                if($model->authority) {
                    foreach ($model->authority as $thority) {
                        $quan = $auth->getPermission($thority);
                        $auth->addChild($roles, $quan);
                    }
                }

                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['roles/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
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