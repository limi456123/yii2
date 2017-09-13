<div class="img-wall" style="width:660px">

    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="4000" >

        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <?php for($i=1;$i<=$count;$i++):?>
                <li data-target="#myCarousel" data-slide-to="<?=$i?>"></li>
            <?php endfor;?>
        </ol>

        <div class="carousel-inner">
            <?php foreach($photo as$k=> $v):?>
            <div class="item <?php echo $k?'':'active'?>">

                <img src="<?=$v->path?>" alt="First slide">
                <div class="carousel-caption">标题 1</div>
            </div>
            <?php endforeach;?>
        </div>

        <a class="carousel-control left" href="#myCarousel"
           data-slide="prev">&lsaquo;</a>
        <a class="carousel-control right" href="#myCarousel"
           data-slide="next">&rsaquo;</a>
    </div>
</div>
<div>
    <?=$intro->content ?>
</div>
