<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/8
 * Time: 10:46
 */
namespace backend\models;
use yii\db\ActiveRecord;

class ArticleDetail extends ActiveRecord{
    public function rules(){
        return [
         [['content'],'required']
        ];
    }
}