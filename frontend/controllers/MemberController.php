<?php
namespace frontend\controllers;
use frontend\models\Login;
use frontend\models\Member;
use frontend\models\SmsDemo;
use yii\web\Controller;

class MemberController extends Controller{

    public function actionRegist(){

        return $this->renderPartial('regist');
    }
    public function actionName($username){

        $model=new Member();
            if($model->validateName($username)){
                return 'false';
            }else{
                return 'true';
            }

    }
    public function actionAdd(){
        $request=\Yii::$app->request;
        $model=new Member();
        $model->scenario=Member::SCENARIO_ADD;
        if($request->isPost){
            $model->load($request->post(),'');
            if($model->validate()){
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key=\Yii::$app->security->generateRandomString();
                $model->created_at=time();
                $model->save(false);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
    }
    public function actionLogin(){
        $request=\Yii::$app->request;
        $model=new Member();
        if($request->isPost){
            $model->load($request->post(),'');
            $num=$model->num;
            if($model->validate()){
                $member=Member::find()->where(['username'=>$model->username])->one();
                if($member){
                    if(\Yii::$app->security->validatePassword($model->password,$member->password_hash)){
                            $user=\Yii::$app->user;
                            $user->login($member,$num?$num:3600);
                            $member->last_login_time=time();
                            $member->last_login_ip=$request->getUserIP();
                            $member->save(false);
                         Member::Usercookie();
                        return $this->redirect(['index/index']);

                    }else{
                      echo ('密码不对');
                    }

                }else{
                    echo('用户名没有');
                }
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->renderPartial('login');
    }
   public function actionSms(){
       $request=\Yii::$app->request;
       $tel=$request->post('dal');
       $code=rand(100000,999999);
       $redis=new \Redis();
       $redis->connect('127.0.0.1');
       $redis->set($tel,$code);

       $demo = new SmsDemo(
           "LTAIsRvYMgs3zm1Q",
           "tJVkjCLD7wotNn2W06ih1ZvqoS8tZf"
       );

//       echo "SmsDemo::sendSms\n";
       $response = $demo->sendSms(
           "李觅", // 短信签名
           "SMS_97855022", // 短信模板编号
           $tel, // 短信接收者
           Array(  // 短信模板中字段的值
               "code"=>$code,
               "product"=>"dsd"
           )

       );

//       echo "SmsDemo::queryDetails\n";
//       $response = $demo->queryDetails(
//           "12345678901",  // phoneNumbers 电话号码
//           "20170718", // sendDate 发送时间
//           10, // pageSize 分页大小
//           1 // currentPage 当前页码
//       // "abcd" // bizId 短信发送流水号，选填
//       );

       print_r($response);
   }
    public function actionLogout(){
        \Yii::$app->user->logout();
        return $this->redirect(['member/login']);
    }
    public function actionSmsvalidate($tel,$sms){
        $redis=new \Redis();
        $code=$redis->get($tel);
        if($code==null || $code!=$sms){
            return false;
        }
    }

}