<?php
$this->breadcrumbs = array(
    'Отзывы' => array('index'),
    'Добавить отзыв'
);
?>
<div class="conteiner">
    <?php $this->renderPartial('_form', array(
        'model' => $model,

    )); ?>
</div>
