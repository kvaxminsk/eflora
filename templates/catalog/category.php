
<?// if(!empty($categoryModel->title_main)) {?>
<!--<div class="upper_text">-->
<!--           <h1>--><?//=$categoryModel->title_main;?><!--</h1>-->
<!--    <div class="text">-->
<!--        --><?//=$categoryModel->description_main;?>
<!--    </div>-->
<!---->
<!--</div>-->
<?//}?>
<?
$image = ($categoryModel->img['path']) ? $categoryModel->img['path'] : '/images/no-photo.gif';
$image = image($image, 'resize', '1500', '986');
?>
<div class="catalog_main_picture">
    <div class="photo" style="background: url('<?= $image; ?>') no-repeat 100% 100%;
    background-position:center; background-size:cover; width:100%; height:100%;"></div>
    <div class="slide_box">
        <div class="left_box show">
            <p><?=$categoryModel->name?>
            <div class="title_line"></div>
            </p>

            <div class="white_circle">

            </div>
        </div>
        <div class="right_box"><p class="right_box_title"><?= str_replace('\n', '', trim($categoryModel['title_main'] ? $categoryModel['title_main'] : $categoryModel['name'])); ?></p>
            <hr>
            </hr>
            <p class="rb_discribe">
                <?= str_replace('\n', '', trim($categoryModel['description_main'] ? $categoryModel['description_main'] : $categoryModel['name'])); ?>
            </p>
        </div>
        <div style="clear:both;"></div>
    </div>

</div>
<div class="under_slider">
    <div class="mobile_categoria">
        Акции
    </div>
    <div class="mobile_filter">
        <div class="filter_wrapper">
            <div id="criterion_filter" class="wrapper-dropdown-5 select_filter" tabindex="1">
									<span id='criterion_filter_text'>
									Сортировка</span>
                <ul class="dropdown " id="dropdown2">
                    <li class="choice_link_1"><a href=""><i class="icon-user"></i>По популярности</a></li>
                    <li class="choice_link_1"><a href=""><i class="icon-cog"></i>По цене:</a></li>
                    <!--                                <li><a href=""><i class="icon-remove"></i>До 100</a></li>-->
                    <!--                                <li><a href=""><i class="icon-remove"></i> До 200</a></li>-->
                    <li class="choice_link_1 old_price_1"> <a  href="">До 80 руб.</a></li>
                    <li class="choice_link_1 old_price_1"><a  href="">До 150 руб</a></li>
                    <li class="choice_link_1 old_price_1"><a  href="">До 300 руб</a></li>
                    <li class="choice_link_1 dollar_price_1"><a  href="">До 50$</a></li>
                    <li class="choice_link_1 dollar_price_1"><a  href="">До 100$</a></li>
                    <li class="choice_link_1 dollar_price_1"><a  href="">До 200$</a></li>
                </ul>
            </div>
        </div>
    </div>
    <p class="theme"> Тематика: </p>
    <div class="select_theme_wrapp">
        <? $this->widget('CatalogCategoryBlock', array('file' => 'catalog_select_tree')) ?>
    </div>
</div>
<div class="clearfix" style="clear:both"></div>

<div class="sort_criterion">
    <p class="choice">
        Сортировать по:
        <a class="choice_link" href="">Популярности</a><img class="orrange_arrow popular" src="">
        <a class="choice_link" href="">Цене</a><img class="orrange_arrow  price_link" src="">
        <a class="choice_link old_price_1" href="">До 80 руб</a>
        <a class="choice_link old_price_1" href="">До 150 руб</a>
        <a class="choice_link old_price_1" href="">До 300 руб</a>
        <a class="choice_link dollar_price_1" href="">До 50$</a>
        <a class="choice_link dollar_price_1" href="">До 100$</a>
        <a class="choice_link dollar_price_1" href="">До 200$</a>
    </p>
</div>
</div>
<!--<div class="list_product">-->
<!--    --><?// if (!empty($products->data)): ?>
<!--        <ul class="flower_products_catalog">-->
<!--            --><?//
//            $this->widget('SMListView',
//                array(
//                    'dataProvider' => $products,
//                    'itemView' => '_products',
//                    'ajaxUpdate' => true,
//                    'template' => "{items}\n{pager}",
//                    'enablePagination' => false
//                )
//            );
//            ?>
<!--        </ul>-->
<!--    --><?// else: ?>
<!--        	По вашим параметрам ничего не найдено-->
<!--    --><?// endif; ?>
<!--    --><?//=$contentCategory?>
<!--    	<div class="show_tile">-->
<!--    		--><?// //
//    //		$this->widget('SMListView',
//    //			array(
//    //				'dataProvider'      => $products,
//    //				'itemView'          => '_product_list_table',
//    //				'ajaxUpdate'        => true,
//    //				'template'          => "{items}\n{pager}",
//    //				'enablePagination'  => false
//    //			)
//    //		);
//    //		?>
<!--    	</div>-->
<!---->
<!--    <!--	--><?// // $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
<!--    <br/>-->
<!--    <br/>-->
<!--</div>-->
<!-- ***********************-->
<script>
//    alert($('a[data-category='+<?//=$category?>//+ ']').parent());

    $('a[data-category='+<?=$category?>+ ']').eq(0).parent().addClass('slick-active-catalog');
//    $('a[data-category='+<?//=$category?>//+ ']').parent().addClass('slick-active-catalog');
//alert($('a[data-category='+<?//=$category?>//+ ']').eq(0).text());
    var data = $('a[data-category='+<?=$category?>+ ']').eq(0).text();
    $('#theme_text').text(data);

    $('#theme_text').attr('data-category','<?=$category?>');
</script>
<div class="list_product">
    <ul class="flower_products_catalog flower_products">
    <!--	<div class="show_tile">-->
    <!--		--><? //
    //		$this->widget('SMListView',
    //			array(
    //				'dataProvider'      => $products,
    //				'itemView'          => '_product_list_table',
    //				'ajaxUpdate'        => true,
    //				'template'          => "{items}\n{pager}",
    //				'enablePagination'  => false
    //			)
    //		);
    //		?>
    <!--	</div>-->

    <!--	--><? // $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
    <br/>
    <br/>
  </ul>
</div>
<div class="bottomBlockCatalog"><?=$contentCategory?></div>