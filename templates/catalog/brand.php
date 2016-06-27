<div class="page-title category-title">
    <h1><?= $this->h1; ?></h1>
</div>

<div class="category-products">
    <div class="text">
        <?= $model->content; ?>
    </div>
    <ul class="products-grid">
        <?php
        $this->widget('zii.widgets.CListView',
            array(
                'dataProvider' => $products,
                'itemView' => '_product',
                'ajaxUpdate' => true,
                'template' => "{items}\n{pager}",
                'enablePagination' => false
            )
        ); ?>
    </ul>
    <?php
    $this->widget('CLinkPager',
        array(
            'header' => '',
            'firstPageLabel' => '<<',
            'prevPageLabel' => '<',
            'nextPageLabel' => '>',
            'lastPageLabel' => '<<',
            'htmlOptions' => array('class' => 'pagination_product'),
            'pages' => $pages,
        )
    ); ?>

    <script type="text/javascript">
        decorateGeneric($$('ul.products-grid'), ['odd', 'even', 'first', 'last'])
    </script>


</div>

