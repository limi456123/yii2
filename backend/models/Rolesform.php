<?php
namespace backend\models;
use yii\base\Model;

class Rolesform extends Model{
    public $name;
    public $describe;
    public $authority;
    const SCENARIO_ADD='add';
    const SCENARIO_EDIT='edit';
    public function rules(){
        return [
          [['name','describe'],'required'] ,
            ['authority','safe'],
            ['name','validateRe','on'=>self::SCENARIO_ADD],
            ['name','validateEdit','on'=>self::SCENARIO_EDIT]
        ];
    }
    public static function getRbacname(){
       $perms=\Yii::$app->authManager->getPermissions();
        $rbacbox=[];
        foreach($perms as $perm){
            $rbacbox[$perm->name]=$perm->description;
        }
        return $rbacbox;
    }
    public function validateEdit(){
        if(\Yii::$app->request->get('name')!=$this->name){
            $auth=\Yii::$app->authManager;
            if($auth->getRole($this->name)){
                return $this->addError('name','名称重复');
            }
        }
    }
    public function validateRe(){
        $auth=\Yii::$app->authManager;
        if($auth->getRole($this->name)){
            return $this->addError('name','名称重复');
        }
    }
}