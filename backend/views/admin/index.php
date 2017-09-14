<a href="<?=\yii\helpers\Url::to(['admin/add'])?>" class="btn btn-info">添加</a>
<table class="table table-bordered">
    <tr>
        <th>用户名</th>
        <th>密码</th>
        <th>email</th>
        <th>状态</th>
        <th>生成时间</th>
        <th>修改时间</th>
        <th>最后登录时间</th>
        <th>最后登录IP</th>
        <th>操作</th>
    </tr>
    <?php foreach($admins as $admin): ?>
        <tr>
            <td><?=$admin->username ?></td>
            <td><?=$admin->password_hash ?></td>
            <td><?=$admin->email ?></td>
            <td><?=$admin->status?'正常':'不正常'?></td>
            <td><?=date('Y-m-d H:i:s',$admin->created_at) ?></td>
            <td><?=date('Y-m-d H:i:s',$admin->updated_at) ?></td>
            <td><?=date('Y-m-d H:i:s',$admin->last_login_time) ?></td>
            <td><?=$admin->last_login_ip ?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['admin/delete','id'=>$admin->id])?>" class="btn btn-info">删除</a>
                <a href="<?=\yii\helpers\Url::to(['admin/edit','id'=>$admin->id])?>" class="btn btn-info">修改</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>