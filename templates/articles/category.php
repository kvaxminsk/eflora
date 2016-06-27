<div class="content_scene_cat">
    <!-- Category image -->
    <div class="content_scene_cat_bg row">
        <div class="cat_desc  col-xs-12 col-sm-7 col-md-8 col-lg-12">
            <span class="category-name"><?= $this->h1; ?></span>
            <div id="category_description_short" class="rte text-tpl"><?= $model->content; ?></div>
        </div>
    </div>
</div>

<? if (!empty($subcategories)): ?>
    <h2>Список подкатегорий</h2>
    <ul class="product_list row list">
        <? foreach ($subcategories as $i => $cat): ?>
            <li class="ajax_block_product first-in-line first-item-of-tablet-line first-item-of-mobile-line col-xs-12">
                <div class="product-container">
                    <div class="row">
                        <? if (!empty($cat->img['path'])): ?>
                            <div class="left-block col-xs-4 col-xs-5 col-md-4">
                                <div class="product-image-container">
                                    <a class="product_img_link" href="<?= $cat['url']; ?>" title="<?= $cat->name; ?>">
                                        <img class="replace-2x img-responsive"
                                             src="<?= image($cat->img['path'], 'resize', '230', '230'); ?>"
                                             alt="<?= $cat->name; ?>" title="<?= $cat->name; ?>"/>
                                    </a>
                                </div>
                            </div>
                        <? endif; ?>

                        <div
                            class="center-block col-xs-4 col-xs-7 <? if (!empty($cat->img['path'])): ?>col-md-8<? else: ?>col-md-12<? endif; ?>">
                            <h5>
                                <a class="product-name" href="<?= $cat['url']; ?>" title="<?= $cat->name; ?>">
                                    <span class="list-name"><?= $cat->name; ?></span>
                                </a>
                            </h5>
                            <? if (trim($cat['summary']) != ''): ?>
                            <p class="product-desc">
                                <div class="product-desc">
                                    <?=$cat['summary'];?>
                                </div>
                            </p>
                        <? endif; ?>
                            <a href="<?= $cat['url']; ?>" title="<?= $cat->name; ?>">Подробнее...</a>
                        </div>

                    </div>
                </div>
            </li>

        <? endforeach; ?>
    </ul>
<? endif; ?>
<? if (!empty($articles->data)): ?>
    <h2>Список статей</h2>
    <div class="content_sortPagiBar clearfix">
        <!-- Pagination -->
        <?php $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
        <!-- /Pagination -->
    </div>

    <ul class="product_list row list">
        <?php
        $this->widget('SMListView',
            array(
                'dataProvider' => $articles,
                'itemView' => '_article',
                'ajaxUpdate' => true,
                'template' => "{items}\n{pager}",
                'enablePagination' => false
            )
        );
        ?>
    </ul>

    <div class="content_sortPagiBar">
        <!-- Pagination -->
        <?php $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
        <!-- /Pagination -->
    </div>

<? endif; ?>

