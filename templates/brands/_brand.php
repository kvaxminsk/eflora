<div class="news">
    <div class="conteiner">
        <div class="title">
            <a href="<?php echo CHtml::normalizeUrl(array('/brands/' . $data->alias)) ?>">
                <h2><?php echo $data->name; ?></h2></a>
        </div>
    </div>
    <div class="conteiner">
        <div class="text">
            <div>
                <?php if ($data->logo != "") { ?>
                    <img class="image" style="max-width:100px; max-height:100px; float:left; margin:5px;"
                         src="<?php echo Yii::app()->request->baseUrl . '/images/producer/small/' . $data->logo; ?>"
                         alt="">
                <?php } else { ?>
                    <img class="image" style="max-width:100px; max-height:100px; float:left; margin:5px;"
                         src="<?php echo(Yii::app()->request->baseUrl . '/images/no-photo.gif'); ?>" alt="">
                <?php } ?>
                <?php echo $data->description; ?>
            </div>
            <div class="link">
                <a href="<?php echo CHtml::normalizeUrl(array('/brands/' . $data->alias)) ?>"
                   class="add_new">Подробнее</a>
            </div>
            <div style="clear: both;"></div>

        </div>
    </div>

</div>
<br>


