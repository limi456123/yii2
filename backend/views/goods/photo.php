<?php

echo \yii\helpers\Html::fileInput('test',null,['id'=>'test']);
//外部TAG
echo \flyok666\uploadifive\Uploadifive::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['goods_id' => $goods_id],
        'width' => 120,
        'height' => 40,
        'onError' => new \yii\web\JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadComplete' => new \yii\web\JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
             $('#img').attr('src',data.fileUrl);

             var tr='<tr>'+
                       '<td><img class="img"></td>'+
                       '<td></td>'+
                     '</tr>';
              $('table').append(tr);
             $(".img").attr('src',data.fileUrl);
    }

}
EOF
        ),
    ]
]);

?>
<table class="table text-danger">
    <tr>
    <th>图片</th>
    <th>操作</th>
    </tr>
    <?php foreach($photos as $photo):?>
    <tr>
        <td class="col-xs-10"><img src="<?=$photo->path ?>"/></td>
        <td class="col-xs-2"><a href="<?=\yii\helpers\Url::to(['goods/photodel','id'=>$photo->id,'gid'=> $goods_id])?>" class="btn btn-info">删除</a></td>
    </tr>
    <?php endforeach;?>
</table>
