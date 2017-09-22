<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "addr".
 *
 * @property integer $id
 * @property string $name
 * @property integer $shen
 * @property integer $city
 * @property integer $qu
 * @property string $addr
 * @property string $del
 */
class Addr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shen', 'city', 'qu'], 'integer'],
            [['name', 'addr', 'del'], 'string', 'max' => 255],
            ['sname','required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '用户名',
            'shen' => '省ID',
            'city' => '市ID',
            'qu' => '区县ID',
            'addr' => '详细地址',
            'del' => '电话',
        ];
    }
//    public function getLocations(){
//    return    $this->hasOne(Locations::className(),['id'=>'shen']);
//    }
    public function getAddrname($id){
        $addrname=Locations::findOne(['id'=>$id]);
        return $addrname->name;
    }
}
