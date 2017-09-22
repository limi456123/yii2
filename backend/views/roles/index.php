<a href="<?=\yii\helpers\Url::to(['roles/add'])?>" class="btn btn-info">添加</a>
<table id="myTable" class="display">
    <thead>
    <tr>
        <th>角色</th>
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
            <a href="<?=\yii\helpers\Url::to(['roles/delete','name'=>$model->name])?>" class="btn btn-info">删除</a>
            <a href="<?=\yii\helpers\Url::to(['roles/edit','name'=>$model->name])?>" class="btn btn-info">修改</a>
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
