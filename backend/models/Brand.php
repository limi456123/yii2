<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/7
 * Time: 14:55
 */
namespace backend\models;
use yii\db\ActiveRecord;

class Brand extends ActiveRecord{
   public $file;
    public function rules(){
        return [
            [['name','intro','sort','status'],'required'],
            ['file','file','extensions'=>['jpg','png','gif']]
        ];
    }
}