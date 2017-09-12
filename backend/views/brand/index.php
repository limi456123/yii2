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
    <tr class="<?=$brand->id?>">
        <td><?=$brand->name?></td>
        <td><?=$brand->intro?></td>
        <td class="col-xs-2"><img src="<?=$brand->logo?>" class="col-xs-12 img-circle"/></td>
        <td><?=$brand->sort?></td>
        <td><?=$brand->status==1?'正常':'隐藏'?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['brand/edit','id'=>$brand->id])?>" class="btn btn-primary">修改</a>
            <a href="javascript:;" class="btn btn-primary del">删除</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php
echo  \yii\widgets\LinkPager::widget([
    'pagination'=>$pager
]);
/**
 * @var $this yii\web\View
 */
$url=\yii\helpers\Url::to(['brand/delete']);
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
        $('.del').on('click',function(){
            var id=$(this).closest('tr').attr('class');
            //console.log(id);
            var  data={'id':id};
            var self=$(this);
            $.getJSON("{$url}",data,function(data){
                 console.log(11);
                  if(data ==true){
                      self.closest('tr').remove();
                  }
            })
        })

JS

));

?>













