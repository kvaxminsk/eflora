<?php
$month = array('01' => "Янв", '02' => "Фев", '03' => "Мар", '04' => "Апр", '05' => "Май", '06' => "Июн", '07' => "Июл", '08' => "Авг", '09' => "Сен", '10' => "Окт", '11' => "Ноя", '12' => "Дек");
$time = explode("-", $data->date);
?>

    <div class="post">
        <div class="row">
            <div class="grid_1">
                <div class="post_date">
                    <div class="post_date_icon"><i class="fa fa-file-text"></i></div>
                    <time datetime="<?= $data['date']; ?>"
                          title="<?= $month[$time['1']]; ?> <?= $time['2']; ?>"><?= $time['0']; ?></time>
                    <div class="date-carousel_date_comments"></div>
                </div>
            </div>
            <div class="grid_7">
                <div class="post_info">
                    <h4><a href="<?= $data->url; ?>"><?= $data->name; ?></a></h4>
                    <div class="post_link"><a href="#">Adminl</a></div>
                    <div class="row">
                        <div class="grid_3" style="float:left; margin: 7px 7px 7px 0px">
                            <? if (!empty($data->img['path'])): ?>
                                <img src="<?= $data->img['path']; ?>" alt="">
                            <? else: ?>
                                <img src="/../images/product-photo.jpg">
                            <? endif; ?>
                        </div>
                        <div class="grid_4" style="margin: 7px 0 7px 7px; float:right;">
                            <?= $data->summary; ?>
                            <a class="link" href="<?= $data['url']; ?>">подробнее...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
/*

<li class="ajax_block_product first-in-line first-item-of-tablet-line first-item-of-mobile-line col-xs-12">
    <div class="product-container">
        <div class="row">
            <? if (!empty($data->img['path'])): ?>
            <div class="left-block col-xs-4 col-xs-5 col-md-4">
                <div class="product-image-container">
                    <a class="product_img_link" href="<?=$data['url'];?>" title="<?=$data->name;?>">
                        <img class="replace-2x img-responsive" src="<?=image($data->img['path'], 'resize', '230', '230');?>" alt="<?=$data->name;?>" title="<?=$data->name;?>"/>
                    </a>
                </div>
            </div>
            <? endif; ?>
            
            <div class="center-block col-xs-4 col-xs-7 <? if (!empty($data->img['path'])): ?>col-md-8<? else: ?>col-md-12<? endif; ?>">    
                <h5>
                    <a class="product-name" href="<?=$data['url'];?>" title="<?=$data->name;?>">
                        <span class="list-name"><?=$data->name;?></span>
                    </a>
                </h5>
                <? if (trim($data->summary) != ''): ?>
                    <div class="product-desc">
                        <?=$data->summary;?>
                    </div>
                <? endif; ?>
                <a href="<?=$data['url'];?>">подробнее...</a>
            </div>
            
        </div>
    </div>
</li>
*/
?>