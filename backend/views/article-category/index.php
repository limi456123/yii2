<a href="<?=\yii\helpers\Url::to(['article-category/add'])?>" class="btn btn-primary">添加</a>
<table class="table table-bordered tab-content">
    <tr>
        <th>名称</th>
        <th>简介</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($articlecategorys as $articlecategory):?>
        <tr>
            <td><?=$articlecategory->name?></td>
            <td><?=$articlecategory->intro?></td>
            <td><?=$articlecategory->sort?></td>
            <td><?=$articlecategory->status==1?'正常':'隐藏'?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['article-category/edit','id'=>$articlecategory->id])?>" class="btn btn-primary">修改</a>
                <a href="<?=\yii\helpers\Url::to(['article-category/delete','id'=>$articlecategory->id])?>" class="btn btn-primary">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

