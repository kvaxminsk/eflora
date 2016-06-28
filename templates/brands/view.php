<?php $this->breadcrumbs = array(
    'Бренды' => array('/brands'),
    $model->name,
);
?>
<div class="box">
    <!-- <div class="box_head"></div>	 -->

    <div class="box_body content">


        <div class="page_title">
            <h1><?php echo $model->name; ?></h1>
        </div>
        <div>
            <?php if ($model->logo != "") { ?>
                <img class="image" style="max-width:100px; max-height:100px; float:left; margin:5px;"
                     src="<?php echo Yii::app()->request->baseUrl . '/images/producer/small/' . $model->logo; ?>"
                     alt="">
            <?php } else { ?>
                <img class="image" style="max-width:100px; max-height:100px; float:left; margin:5px;"
                     src="<?php echo(Yii::app()->request->baseUrl . '/images/no-photo.gif'); ?>" alt="">
            <?php } ?>
            <?php echo $model->description; ?>
        </div>
        <a href="<?php echo CHtml::normalizeUrl(array('/brands')) ?>">Назад к списку брендов</a>
        <div style="clear: both;"></div>


    </div>
</div>

<div class="box">
    <div class="box_head">Товары бренда <?php echo $model->name; ?></div>

    <div class="box_body content">

        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $res['products'],
            'itemView' => '_product',
            'ajaxUpdate' => true,
            'template' => "{items}\n{pager}",

            'pagerCssClass' => 'pager',
            'pager' => array(
                'header' => '',
                'firstPageLabel' => '&lt;&lt;',
                'prevPageLabel' => '<<',
                'nextPageLabel' => '>>',
                'lastPageLabel' => '&gt;&gt;',
            ),
        )); ?>
        <div style="clear: both;"></div>


    </div>
</div>
