<?php
namespace  backend\models;
use yii\base\Model;

class Login extends Model{
    public $code;
    public $name;
    public $password;
    public $num;

    public function rules(){
        return [
          [['name','password'],'required'],
           ['code','captcha','captchaAction'=>'admin/captcha'],
            ['num','safe']
        ];
    }
    public function attributeLabels(){
        return [
          'name'=>'用户名'  ,
            'password'=>'密码',
            'code'=>'验证码',
            'num'=>'记住我'
        ];
    }
}