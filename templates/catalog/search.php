<form method="get"
      action="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'search')) ?>">
    <input type="search" name="query" value="<?= $_GET['query'] ?>" placeholder="Поиск"/>
    <button  class="go_find"></button>
</form>
<div class="list_product">
    <? if ($_GET['query']): ?>
        <h1>Вы искали <span>«<?= $_GET['query'] ?>»</span></h1>
        <ul class="flower_products_catalog">
            <?
            $this->widget('SMListView',
                array(
                    'dataProvider' => $products,
                    'itemView' => '_products',
                    'ajaxUpdate' => true,
                    'template' => "{items}\n{pager}",
                    'enablePagination' => false
                )
            );
            ?>
        </ul>
        <? $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
        <br/>
        <br/>
        <br/>
    <? else: ?>
        <h1>По вашему запросу ничего не найдено</h1>
        <br/>
    <? endif ?>


