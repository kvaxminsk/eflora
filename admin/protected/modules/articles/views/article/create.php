<?php
$this->breadcrumbs = array(
    'Акции'
);
if ($this->h1 != 'Все акции') {
    $this->breadcrumbs = array(
        'Статьи' => array('index'),
        $this->h1
    );
}

if (isset($category->parent)) {

    if ($this->h1 != 'Все акции') {
        $this->breadcrumbs = array(
            'Акции' => array('index'),
            $category->parent->name => array('/articles/article/index/category/' . $category->parent->id),
            $this->h1
        );
    }
} ?>
<div class="conteiner">
    <?php $this->renderPartial('_form', array(
        'model' => $model,
        'categories' => $categories,
    )); ?>
</div>
