<?php
use \kucha\ueditor\UEditor;
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($goods,'name')->textInput();

echo $form->field($goods,'logo')->hiddenInput();
echo \yii\helpers\Html::fileInput('test',null,['id'=>'test']);
//外部TAG
echo \flyok666\uploadifive\Uploadifive::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['someKey' => 'someValue'],
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
        console.log(data.fileUrl);

            $('#goods-logo').val(data.fileUrl);
             $('#img').attr('src',data.fileUrl);
    }

}
EOF
        ),
    ]
]);

echo \yii\bootstrap\Html::img($goods->logo,['id'=>'img']);
//echo $form->field($goods,'goods_category_id')->hiddenInput();
echo $form->field($goods,'goods_category_id')->hiddenInput();
echo '<div>
   <ul id="treeDemo" class="ztree"></ul>
</div>';

//stree 引入
/**
 * @var $this yii\web\View
 */
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$categoryes=json_encode(\backend\models\GoodsCategory::getNode());
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                }
            },
            callback: {//事件回调函数
		        onClick: function(event, treeId, treeNode){
		             //console.log(treeNode);
		             //获取当前点击节点的id,写入parent_id的值
		             $("#goods-goods_category_id").val(treeNode.id);
		        }
	        }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$categoryes};

        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        //修改 根据当前分类的parent_id来选中节点
        //获取你需要选中的节点
        var node = zTreeObj.getNodeByParam("id", "{$goods->goods_category_id}", null);
        zTreeObj.selectNode(node);
JS
));

echo $form->field($goods,'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map($brand,'id','name'));
echo $form->field($goods,'market_price')->textInput(['type'=>'number']);
echo $form->field($goods,'shop_price')->textInput(['type'=>'number']);
echo $form->field($goods,'stock')->textInput(['type'=>'number']);
echo $form->field($goods,'is_on_sale',['inline'=>true])->radioList(['下架','在售']);
echo $form->field($goods,'status',['inline'=>true])->radioList(['回收站','正常']);
echo $form->field($goods,'sort')->textInput(['type'=>'number']);
echo $form->field($intro,'content')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();