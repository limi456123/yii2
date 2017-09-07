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
}