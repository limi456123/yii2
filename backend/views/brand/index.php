<a href="<?=\yii\helpers\Url::to(['brand/add'])?>" class="btn btn-primary">添加</a>
<table class="table table-bordered tab-content">
    <tr>
        <th>名称</th>
        <th>简介</th>
        <th>logo图片</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($brands as $brand):?>
    <tr>
        <td><?=$brand->name?></td>
        <td><?=$brand->intro?></td>
        <td class="col-xs-2"><img src="<?=$brand->logo?>" class="col-xs-12"/></td>
        <td><?=$brand->sort?></td>
        <td><?=$brand->status==1?'正常':'隐藏'?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['brand/edit','id'=>$brand->id])?>" class="btn btn-primary">修改</a>
            <a href="<?=\yii\helpers\Url::to(['brand/delete','id'=>$brand->id])?>" class="btn btn-primary">删除</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

