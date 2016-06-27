<div class="wrap">
    <div class="wrap_contacts">
        <div class="content">
            <h1><?= $this->h1 ?></h1>
        </div>
    </div>
    <div class="content">
        <? include HOME . '/templates/blocks/breadcrumbs.php'; ?>

        <div class="left_content">
            <div class="about">
                <?
                $image = (isset($model->img['path'])) ? $model->img['path'] : '/images/no-photo.gif';
                $image = image($image, 'resize', '260', false);
                ?>

                <img src="<?= $image ?>"/>
                <? if (!empty($model->precent)): ?><h5 style="color: green;">Скидка -<?= $model->precent ?>
                    %</h5><? endif ?>
                <?= $model->content ?>
            </div>
            <div class="clear"></div>
            <a style="font-size: 12px;" href="<?= $linkcat; ?>">&laquo; Вернуться к списку акций</a>
        </div>

        <div class="right_block">
            <h1>Глушители по маркам автомобилей</h1>

            <? $this->widget('SubjectsBlock', array('file' => 'brand_block_right')) ?>

            <h1>ОТБОР ВЫХЛОПНЫХ СИСТЕМ</h1>
            <div class="selection">
                <form action="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'index')) ?>"
                      method="GET" id="catalogForm">
                    <? $this->widget('catalogIndex', array('file' => 'catalog_filter')) ?>
                    <input type="submit" value="ПОИСК >"/>
                </form>
            </div>

            <div id="slider">
                <? $this->widget('SlideBlock', array('file' => 'slider', 'sliderN' => 2)) ?>
            </div>
        </div>
    </div>
</div>
