<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/15
 * Time: 13:46
 */
namespace backend\models;
use yii\base\Model;

class Rbacform extends Model{
    public $name;
    public $describe;
    public function rules(){
        return [
          [['name','describe'],'required'],
            ['name','validatename']
        ];
    }
    public function validatename(){
        if(\Yii::$app->authManager->getPermission($this->name)){
            return $this->addError('name','名称重复');
        }
    }
    public function  attributeLabels(){
        return [
            'name'=>'权限名称',
            'describe'=>'权限描述'
        ];
    }
}