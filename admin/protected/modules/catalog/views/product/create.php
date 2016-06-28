<?php
$this->breadcrumbs = array(
    'Товары' => array('index'),
    'Добавить товар'
);

?>
<div class="conteiner">

    <?php $this->renderPartial('_form', array(
        'model' => $model,
        'categories' => $categories,
        'brands' => $brands,
    )); ?>

</div>
