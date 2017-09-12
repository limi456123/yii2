<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/10
 * Time: 20:44
 */
?>
<a href="<?=\yii\helpers\Url::to(['goods-category/add'])?>" class="btn btn-info">添加</a>
<a></a>
<table class="table table-bordered tab-content" >
    <tr>
        <th>名称</th>
        <th>上级分类</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach($goodscategorys as $goodscategory):?>
    <tr>
        <td><?=$goodscategory->name ?></td>
        <td><?=$goodscategory->parent_id==0?'无':\backend\models\GoodsCategory::getParentName($goodscategory->parent_id)['name'] ?></td>
        <td><?=$goodscategory->intro ?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['goods-category/delete','id'=>$goodscategory->id])?>" class="btn btn-info">删除</a>
            <a href="<?=\yii\helpers\Url::to(['goods-category/edit','id'=>$goodscategory->id])?>" class="btn btn-info">修改</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
