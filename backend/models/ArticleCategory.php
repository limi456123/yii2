<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/7
 * Time: 16:35
 */
namespace backend\models;
use yii\db\ActiveRecord;

class ArticleCategory extends ActiveRecord{
    public function rules(){
        return [
            [['name','intro','sort','status'],'required'],
        ];
    }
    public function attributeLabels(){
        return [
          'name'=>'名称',
            'intro'=>'简介',
            'sort'=>'排序',
            'status'=>'状态'
        ];
    }
}