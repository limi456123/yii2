<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $route
 * @property integer $sort
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

   const SCENARIO_ADD='add';
   const SCENARIO_EDIT='edit';
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort'], 'integer'],
            [['name', 'route'], 'string', 'max' => 255],
            ['name','unique','on'=>self::SCENARIO_ADD],
            ['name','validateName','on'=>self::SCENARIO_EDIT],
            ['status','required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'parent_id' => '上级菜单',
            'route' => '地址/路由',
            'sort' => '排序',
            'status' => '状态',
        ];
    }
    public static function getParm(){
        $auths=Yii::$app->authManager->getPermissions();
        $parms=[0=>'请选择路由'];
        foreach($auths as $auth){
            $parms[$auth->name]=$auth->name;
        }
        return $parms;

    }
    public static function getPamrent(){
       $pamrent= Menu::find()->where(['parent_id'=>0])->all();

        $pars=[0=>'顶级菜单'];
      foreach( $pamrent as $parm){
        $pars[$parm['id']]=$parm['name'];
      }
        return $pars;
    }
    public function validateName(){
        $id=Yii::$app->request->get('id');
        $name=Menu::find()->select(['name'])->where(['id'=>$id])->one();
        if($this->name !=$name->name ){
            if(Menu::findOne($this->name)){
                $this->addError('name','名称重复');
            }
        }
    }

}
