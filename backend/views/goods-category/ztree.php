
<!DOCTYPE html>
<HTML>
 <HEAD>
  <TITLE> ZTREE DEMO </TITLE>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="/zTree/css/demo.css" type="text/css">
  <link rel="stylesheet" href="/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
  <script type="text/javascript" src="/zTree/js/jquery-1.4.4.min.js"></script>
  <script type="text/javascript" src="/zTree/js/jquery.ztree.core.js"></script>
  <SCRIPT LANGUAGE="JavaScript">
   var zTreeObj;
   // zTree �Ĳ������ã�����ʹ����ο� API �ĵ���setting ������⣩
   var setting = {};
   // zTree ���������ԣ�����ʹ����ο� API �ĵ���zTreeNode �ڵ�������⣩
   var zNodes = [
   {name:"test1", open:true, children:[
      {name:"test1_1"}, {name:"test1_2"}]},
   {name:"test2", open:true, children:[
      {name:"test2_1"}, {name:"test2_2"}]}
   ];
   $(document).ready(function(){
       zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
   });
  </SCRIPT>
 </HEAD>
<BODY>
<div>
   <ul id="treeDemo" class="ztree"></ul>
</div>
</BODY>
</HTML>