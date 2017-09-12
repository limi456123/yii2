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
            [['name','intro','sort','status','logo'],'required'],
            ['file','file','extensions'=>['jpg','png','gif']]
        ];
    }
    public function attributeLabels(){
        return [
            'name'=>'名称',
            'intro'=>'简介',
            'sort'=>'排序',
            'status'=>'状态',
        ];
    }
}