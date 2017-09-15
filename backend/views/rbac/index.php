<?php
/* @var $this yii\web\View */
?>
<a href="<?=\yii\helpers\Url::to(['rbac/add'])?>">添加</a>
<table class="table table-bordered">
    <tr>
        <th>授权名称</th>
        <th>描述</th>
        <th>操作</th>

    </tr>
    <?php foreach($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->description?></td>
        <td>
            <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['rbac/delete','name'=>$model->name])?>">删除</a>
            <a class="btn btn-info" href="<?=\yii\helpers\Url::to(['rbac/edit','name'=>$model->name])?>">修改</a>
        </td>
    </tr>
    <?php endforeach;?>
</table>
