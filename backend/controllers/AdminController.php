<?php
namespace backend\controllers;
use backend\models\Admin;
use backend\models\Article;
use backend\models\Login;
use backend\models\Pass;
use yii\captcha\Captcha;
use yii\captcha\CaptchaAction;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\widgets\LinkPager;

class AdminController extends Controller{
    public function actionIndex(){
         $pager=new Pagination([
             'totalCount'=>Admin::find()->count(),
             'defaultPageSize'=>3
         ]);
        $admins=Admin::find()->limit($pager->limit)->offset($pager->offset)->all();;

        return $this->render('index',['admins'=>$admins,'pager'=>$pager]);
    }
    public function actionAdd(){
        $admin=new Admin();
        $admin->scenario=Admin::SCENARIO_ADD;
        $request=\yii::$app->request;
        if($request->getIsPost()){
            $admin->load($request->post());
            if($admin->validate()){

                $admin->save();
                return $this->redirect(['admin/index']);
            }


        }
        return $this->render('add',['admin'=>$admin]);
    }

    public function actionDelete($id){
        $admin=Admin::find()->where(['id'=>$id])->one();

        $admin->delete();
        return $this->redirect(['admin/index']);
    }

    public function actionEdit($id){
        $admin=Admin::find()->where(['id'=>$id])->one();

        $request=\Yii::$app->request;
        if($request->getIsPost()){
            $admin->load($request->post());
            if($admin->validate()){
                if($admin->save()){
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['admin/index']);
                }
            }else{

              \Yii::$app->session->setFlash('success','修改失败');
              $this->render(['admin/edit','id'=>$id]);
              var_dump($admin->getErrors());exit;
            }
        }
        return $this->render('edit',['admin'=>$admin]);
    }

    public function actions(){
        return [
            'captcha'=>[
                'class'=>CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>3,
                'maxLength'=>3,
            ]
        ];
    }
    public function actionLogin(){
        $login=new Login();
        $request=\yii::$app->request;
        if($request->getIsPost()){

            $login->load($request->post());
            $name=$login->name;
            $password=$login->password;
            $num=$login->num;

            $admin=Admin::find()->where(['username'=>$name])->one();
            $admin->scenario=Admin::SCENARIO_LOGIN;
            if($admin){
                $rst=\Yii::$app->security->validatePassword($password,$admin->password_hash);
                if($rst){
                    //保存信息
                    $user=\yii::$app->user;
                    $user->login($admin,$num?60:'');
                    $admin->last_login_time=time();
                    $admin->last_login_ip=\Yii::$app->request->getUserIP();
                    $admin->save(false);
                    \Yii::$app->session->setFlash('success','登录成功');
                    return $this->redirect(['admin/index']);
                }else{
                    \Yii::$app->session->setFlash('success','密码不对');
                    return $this->redirect(['admin/login']);
                }
            }else{
                \Yii::$app->session->setFlash('success','用户名不对');
                return $this->redirect(['admin/login']);
            }
        }

        return $this->render('login',['login'=>$login]);
    }

//    public function behaviors()
//    {
//        return [
//            'acf'=>[
//                'class'=>AccessControl::className(),
//                //只对以下操作生效
//                'only'=>['login','logout','index','add','edit'],
//                'rules'=>[
//                    [
//                        'allow'=>true,//是否允许
//                        'actions'=>['login'],//指定操作
//                        'roles'=>['?'],//指定角色 ?未登录用户   @已登录用户
//                    ],
//                    [
//                        'allow'=>true,
//                        'actions'=>['logout','index','add','edit'],
//                        'roles'=>['@']
//                    ],
//
//                ]
//            ],
//        ];
//    }
    public function actionLogout(){
       if( \Yii::$app->user->logout()){
        \Yii::$app->session->setFlash('退出成功');
        return $this->redirect(['admin/login']);
       }
    }
    public function actionPass(){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['admin/login']);
        }
        $model=new Pass();
        $request=\Yii::$app->request;
        if($request->isPost){
           $model->load($request->post());

            if($model->validate()){
               $admin=\Yii::$app->user->identity;
                $admin->password=$model->newpass;
                $admin->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('pass',['model'=>$model]);
    }
}