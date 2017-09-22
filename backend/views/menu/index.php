<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/17
 * Time: 14:11
 */
?>
<table class="table table-bordered">
    <tr>
        <th>名称</th>

        <th>路由</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    <?php foreach($menus as $menu):?>
    <tr>
        <td><?=$menu['name']?></td>
        <td><?=$menu['route']?></td>
        <td><?=$menu['sort']?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['menu/delete','id'=>$menu['id']])?>">删除</a>
            <a href="<?=\yii\helpers\Url::to(['menu/edit','id'=>$menu['id']])?>">修改</a>
        </td>
    </tr>
    <?php endforeach;?>
</table>
