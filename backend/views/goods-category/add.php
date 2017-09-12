<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($category,'name')->textInput();
echo $form->field($category,'parent_id')->hiddenInput();
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
		             $("#goodscategory-parent_id").val(treeNode.id);
		        }
	        }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$categoryes};

        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        //修改 根据当前分类的parent_id来选中节点
        //获取你需要选中的节点
        var node = zTreeObj.getNodeByParam("id", "{$category->parent_id}", null);
        zTreeObj.selectNode(node);
JS
));
//stree结束
echo $form->field($category,'intro')->textInput();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();