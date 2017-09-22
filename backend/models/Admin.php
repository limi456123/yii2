<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\HttpException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_time
 * @property integer $last_login_ip
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;
    public $newpass;
    public $vpass;
    public $roles;
    /**
     * @inheritdoc
     */
    const SCENARIO_ADD='add';
    const SCENARIO_EDIT='edit';
    const SCENARIO_LOGIN='login';
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */


    public function beforeSave($insert){
        if($insert){
            $this->password_hash=\Yii::$app->security->generatePasswordHash($this->password);
            $this->auth_key=\Yii::$app->security->generateRandomString();
            $this->created_at=time();
        }else{
            if($this->password){
                if(Yii::$app->security->validatePassword($this->password,$this->password_hash)){
                    $this->password_hash=Yii::$app->security->generatePasswordHash($this->newpass);
                    $this->updated_at=time();
                    $this->auth_key=Yii::$app->security->generateRandomString();
                }
            }

        }
        return parent::beforeSave($insert);
        }
public function rules()
{
    return [
        [['status', 'created_at', 'updated_at'], 'integer'],
        [['username', 'auth_key', 'password_hash',  'email'], 'string', 'max' => 255],
        [['username','email'],'required'],
        [['username','email'],'unique'],
        ['password','required','on'=>self::SCENARIO_ADD],
        [['vpass','newpass','password'],'string'],
        [[ 'last_login_time', 'last_login_ip'],'string','on'=>self::SCENARIO_LOGIN],
        ['roles','safe']
    ];
}

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => '口令',
            'password_hash' => '密码 Hash',
            'password_reset_token' => '确认密码',
            'email' => 'Email',
            'status' => '状态',
             'password'=>'密码',
            'vpass'=>'确认密码',
            'newpass'=>'新密码'
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
       return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
       return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $authKey==$this->auth_key;
    }
    public static function getRoles(){
        $auth=Yii::$app->authManager;
        $roles=$auth->getRoles();
        $rolebox=[];
        foreach($roles as $role){
            $rolebox[$role->name]=$role->description;
        }
        return $rolebox;
    }
    public function getMenu(){
        $menus=Menu::find()->where(['parent_id'=>0])->andWhere(['status'=>1])->all();
        $menuItems=[];
        foreach( $menus as $menu){
            $childs=Menu::find()->where(['parent_id'=>$menu->id])->andWhere(['status'=>1])->all();
            $items=[];
                foreach($childs as $child){
                      if(Yii::$app->user->can($child->route)){
                    $items[]=['label'=>$child->name,'url'=>[$child->route]];
                      }
                }
            if(count($items)){
            $menuItems[]=['label'=> $menu->name,'items'=>$items];
            }
        }
        return $menuItems;
    }

}
