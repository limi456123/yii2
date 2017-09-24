<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
    <?php if(Yii::$app->user->isGuest){

           echo' <ul>
                <li>您好，欢迎来到京西！
                    [<a href= '.\yii\helpers\Url::to(['member/login']).'>登录</a>]
                    [<a href=' .\yii\helpers\Url::to(['member/regist']).'>免费注册</a>]
                </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>
                 </ul>';
            }else{
            echo '<ul>
                    <li>您好&emsp;<b style="color: red;">'.Yii::$app->user->identity->username.'</b>，  欢迎来到京西！
                        [<a href='.\yii\helpers\Url::to(['member/logout']).'>退出</a>]

                    </li>
                    <li class="line">|</li>
                    <li>我的订单</li>
                    <li class="line">|</li>
                    <li>客户服务</li>
                     </ul>';
            }
    ?>

        </div>
    </div>
</div>