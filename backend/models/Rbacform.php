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
    const SCENARIO_ADD='add';
    const SCENARIO_EDIT='edit';
    public function rules(){
        return [
          [['name','describe'],'required'],
            ['name','validateName','on'=>self::SCENARIO_ADD],
            ['name','validateEdit','on'=>self::SCENARIO_EDIT]
        ];
    }
    public function validateName(){
        if(\Yii::$app->authManager->getPermission($this->name)){
             $this->addError('name','名称重复');
        }
    }
    public function validateEdit(){
        if(\Yii::$app->request->get('name')!=$this->name){
            if(\Yii::$app->authManager->getPermission($this->name)){
                $this->addError('name','名称重复');
            }
        }
    }
    public function  attributeLabels(){
        return [
            'name'=>'权限名称',
            'describe'=>'权限描述'
        ];
    }
}