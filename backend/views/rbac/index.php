<?php
/* @var $this yii\web\View */

?>

<a href="<?=\yii\helpers\Url::to(['rbac/add'])?>" class="btn btn-info">添加</a>
    <table id="myTable" class="display">
        <thead>
    <tr>
        <th>授权名称</th>
        <th>描述</th>
        <th>操作</th>

    </tr>
    </thead>
        <tbody>
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
        </tbody>
</table>

<?php
$this->registerJsFile('@web/datatables/js/jquery.dataTables.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerCssFile('@web/datatables/css/jquery.dataTables.css');
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
       $(document).ready(function(){
    $('#myTable').DataTable();
});
JS
));


