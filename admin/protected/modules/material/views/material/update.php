<?php
$this->breadcrumbs = array(
    'Страницы' => array('index'),
    'Редактировать страницу'
);
?>
<div class="conteiner">
    <div class="block_title">
        Редактировать страницу &laquo;<?= $model->name; ?>&raquo;
    </div>

    <div class="form_pretext">
        Поля отмеченные <sup class="form_title_marker">*</sup> обязательны для
        заполнения
    </div>

    <?= $this->renderPartial('_form', array('model' => $model, 'types' => $types, 'menu' => $menu, 'materials' => $materials)); ?>

</div>