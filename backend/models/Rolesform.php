<?php
namespace backend\models;
use yii\base\Model;

class Rolesform extends Model{
    public $name;
    public $describe;
    public $authority;

    public function rules(){
        return [
          [['name','describe'],'required'] ,
            ['authority','safe']
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
}