<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_ADD='add';
   public $password ;
    public $num;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {

        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ 'status', 'integer'],
            [['username'], 'string', 'max' => 50],
            [['password_hash', 'email'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 11],
            [['email','tel'],'required','on'=>self::SCENARIO_ADD],
            [['password','username'],'required'],
            ['num','safe']
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
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'email' => '邮箱',
            'tel' => '电话',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录时间',
            'status' => '状态',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
        ];
    }
    public function validateName($name){
        $member=Member::find()->where(['username'=>$name])->one();
        return $member;
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
    public static function Usercookie(){
        //同步cookie到数据库
        $cooke=\Yii::$app->request->cookies;
        $value=$cooke->getValue('carts');
        if($value){
            $carts=unserialize($value);
            foreach($carts as $k=>$v){
                $cart=Cart::find()->where(['goods_id'=>$k])->andWhere(['member_id'=>\Yii::$app->user->identity->id])->one();

                if($cart){
                    $cart->amount +=$v;
                    $cart->save(false);

                }else{
                    $cart=new Cart();
                    $cart->goods_id=$k;
                    $cart->amount=$v;
                    $cart->member_id=\Yii::$app->user->identity->id;
                    $cart->save(false);

                }
            }
            $cookie=\Yii::$app->request->cookies;
            $cooke=$cookie->get('carts');
            $cookies=\Yii::$app->response->cookies;
            $cookies->remove($cooke);
        }
    }
}
