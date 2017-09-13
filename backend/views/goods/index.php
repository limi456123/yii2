<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($seach,'name')->textInput();
echo $form->field($seach,'sn')->textInput();
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();
?>
<a href="<?=\yii\helpers\Url::to(['goods/add'])?>" class="btn btn-info">添加</a>
<table class="table table-bordered">
    <tr>
        <th>名称</th>
        <th>货号</th>
        <th>LOGO图片</th>
        <th>商品分类id</th>
        <th>品牌分类</th>
        <th>市场价格</th>
        <th>商品价格</th>
        <th>库存</th>
        <th>是否在售(1在售 0下架)</th>
        <th>状态(1正常 0回收站)</th>
        <th>排序</th>
        <th>添加时间</th>
        <th>浏览次数</th>
        <th>操作</th>
    </tr>
    <?php foreach($goods as $good):?>
    <tr>
        <td><?=$good->name?></td>
        <td><?=$good->sn?></td>
        <td class="col-xs-1"><img src="<?=$good->logo?>" class="col-xs-12 img-circle"/></td>
        <td><?=$good->cat->name ?></td>
        <td><?=$good->brand->name ?></td>
        <td><?=$good->market_price?></td>
        <td><?=$good->shop_price?></td>
        <td><?=$good->stock?></td>
        <td><?=$good->is_on_sale?'在售':'下架'?></td>
        <td ><?=$good->status?'正常':'回收站'?></td>
        <td><?=$good->sort?></td>
        <td><?=date('Y-m-d H:i:s',$good->create_time)?></td>
        <td><?=$good->view_times?></td>
        <td class="col-xs-3
        ">
            <a href="<?=\yii\helpers\Url::to(['goods/edit','id'=>$good->id])?>" class="btn btn-info btn-sm">修改</a>
            <a href="<?=\yii\helpers\Url::to(['goods/delete','id'=>$good->id])?>" class="btn btn-info btn-sm">删除</a>
            <a href="<?=\yii\helpers\Url::to(['goods/show','id'=>$good->id])?>" class="btn btn-info btn-sm">预览</a>
            <a href="<?=\yii\helpers\Url::to(['goods/photo','id'=>$good->id])?>" class="btn btn-info btn-sm">照片墙</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php
 echo \yii\widgets\LinkPager::widget([
    'pagination' =>$pager
 ]);
