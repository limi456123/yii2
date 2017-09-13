<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class GoodsSearch extends Model
{
    public $name;
    public $sn;
    public function rules()
    {
        return [
            [['name','sn'], 'string'],
        ];
    }

    public static function getSeek($model){
        $seek=Goods::find();
        $seek->andFilterWhere(['like','name' ,$model->name]);
        $seek->andFilterWhere(['like','sn' ,$model->sn]);
        return $seek;
    }
}