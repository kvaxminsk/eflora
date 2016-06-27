<?php
$this->breadcrumbs = array(
    'Слайды' => array('index'),
    'Создать '
);
?>

<div class="conteiner">
    <div class="block_title_mini">Добавление слайда</div>
    <div class="form_pretext">
        Поля отмеченные <sup class="form_title_marker">*</sup> обязательны для заполнения
    </div>

    <?= $this->renderPartial('_form', array('model' => $model)); ?>
</div>