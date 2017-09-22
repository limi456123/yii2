<?php
namespace frontend\models;
use yii\base\Model;

class Login extends Model{
    public $password ;
    public $username ;
    public $num;
    public function rules(){
        return [
          [['password','username'],'required'],
          ['num','safe']
        ];
    }
}