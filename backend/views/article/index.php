<a href="<?=\yii\helpers\Url::to(['article/add'])?>" class="btn btn-info">添加</a>
<table class="table tab-content table-bordered">
    <tr>
        <th>名称</th>
        <th>简介</th>
        <th>文章分类id</th>
        <th>排序</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($articles as $article): ?>
    <tr>
        <td><?=$article->name?></td>
        <td><?=$article->intro?></td>
        <td><?=$article->article_category_id?></td>
        <td><?=$article->sort?></td>
        <td><?=$article->status?'隐藏':'正常'?></td>
        <td><?=date("Y-m-d H:i:s",$article->create_time)?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['article/edit','id'=>$article->id])?>">修改</a>
            <a href="<?=\yii\helpers\Url::to(['article/show','id'=>$article->id])?>">查看</a>
            <a href="javascript:;"  class="btn btn-primary del">删除</a>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<script type="text/javascript" >
    window.onload = function(){
        $('.del').on('click',function(){
            var id=$(this).closest('tr').attr('class');
            console.log(id);
            var  data={'id':id};
            var self=$(this);
            $.getJSON('<?php echo \yii\helpers\Url::to(['brand/delete']);?>',data,function(data){
                if(data ==true){
                    self.closest('tr').remove();
                }
            })
        })
    }
</script>