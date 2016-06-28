<?php
$this->breadcrumbs = array(
    'Переменные' => array('index'),
    'Редактирование переменной',
);
?>

<div class="conteiner">
    <div class="block_title_mini">Редактирование переменной [<?php echo $model->name; ?>]</div>
    <div class="form_pretext">
        Поля отмеченные <sup class="form_title_marker">*</sup> обязательны для
        заполнения
    </div>
    <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
</div>