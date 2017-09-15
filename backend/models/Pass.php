<?php
namespace backend\models;
use yii\base\Model;

class Pass extends Model{
    public $oldpass;
    public $newpass;
    public $repass;
    public function rules(){
        return [
          [['oldpass','newpass','repass'],'required'],
          ['repass','compare','compareAttribute'=>'newpass','message'=>'密码不一致'],
          ['oldpass','vaildatepass']

        ];
    }
    public function attributeLabels(){
        return [
          'oldpass'=>'旧密码',
            'newpass'=>'新密码',
            'repass'=>'确认新密码'
        ];
    }
    public function vaildatepass(){
        if(!\Yii::$app->security->validatePassword($this->oldpass,\Yii::$app->user->identity->password_hash)){
            return $this->addError('oldpass','密码不对');
        }
    }
}