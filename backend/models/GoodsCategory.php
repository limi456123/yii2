<?php

namespace backend\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods_category".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property integer $parent_id
 * @property string $intro
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'parent_id'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => '名称',
            'parent_id' => '上级 ID',
            'intro' => '简介',
        ];
    }


    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new  MenuQuery(get_called_class());
    }
    public static function getNode(){
        $top = ['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        $category= GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        array_unshift($category, $top);
       return $category;

    }

   public static function getParentName($parent_id){

       return GoodsCategory::find()->where(['id'=>$parent_id])->one();
   }
    public static function getGoodsCategory(){
                  $redis=new \Redis();
                 $redis->connect('127.0.0.1');
                  $html=$redis->get('index');
    if(!$html){
                   $model=GoodsCategory::find()->all();
                   $html='';
                   $html.=  '<div class="cat_bd">';
            foreach($model as $v){
                         if($v->parent_id==0){
                   $html.= '<div class="cat item1">';
                   $html.= '<h3><a href="'.\yii\helpers\Url::to(['index/list','id'=>$v->id]).'">'.$v->name.'</a> <b></b></h3>';
                   $html.='<div class="cat_detail">';
                                    foreach($model as $i){
                                        if($i->parent_id==$v->id){
                   $html.='<dl class="dl_1st">';
                   $html.='<dt><a href="'.\yii\helpers\Url::to(['index/list','id'=>$i->id]).'">'.$i->name.'</a></dt>';
                                            foreach($model as $j){
                                                    if($j->parent_id==$i->id){
                   $html.=' <dd>';
                   $html.='<a href="'.\yii\helpers\Url::to(['index/list','id'=>$j->id]).'">'.$j->name.'</a>';
                   $html.= '</dd>';
                                                    }
                                                }
                   $html.='</dl>';
                                        }
                                    }
                   $html.='</div>';
                   $html.='</div>';
                         }
            }
                    $html.='</div>';
        $redis->set('index',$html);
        $html=$redis->get('index');
    }
        return $html;
    }
}
