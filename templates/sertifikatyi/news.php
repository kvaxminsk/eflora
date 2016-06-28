<div class="grid_8">
    <div class="blog">


        <?php
        $month = array('01' => "Янв", '02' => "Фев", '03' => "Мар", '04' => "Апр", '05' => "Май", '06' => "Июн", '07' => "Июл", '08' => "Авг", '09' => "Сен", '10' => "Окт", '11' => "Ноя", '12' => "Дек");
        $time = explode("-", $model->date);
        ?>

        <div class="post">
            <div class="row">
                <div class="grid_1">
                    <div class="post_date">
                        <div class="post_date_icon"><i class="fa fa-file-text"></i></div>
                        <time datetime="<?= $model['date']; ?>"
                              title="<?= $month[$time['1']]; ?> <?= $time['2']; ?>"><?= $time['0']; ?></time>
                    </div>
                </div>
                <div class="grid_7">
                    <div class="post_info">
                        <h4><a href="<?= $model->url; ?>"><?= $model->name; ?></a></h4>
                        <div class="post_link"><a href="#">Adminl</a></div>
                        <div class="row">
                            <div class="grid_3" style="float:left; margin: 7px 7px 7px 0px">
                                <? if (!empty($model->img['path'])): ?>
                                    <img src="<?= $model->img['path']; ?>" alt="">
                                <? else: ?>
                                    <img src="/../images/product-photo.jpg">
                                <? endif; ?>
                            </div>
                            <div class="grid_4" style="margin: 7px 0 7px 7px; float:right;">
                                <?= $model->content; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>