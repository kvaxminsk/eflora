<div class="cp_right_main_content">
    <div class="text_wrapper">
        <h1><?=$this->h1?></h1>
    <?
    $this->widget('SMListView',
        array(
            'dataProvider'      => $news,
            'itemView'          => '_news',
            'ajaxUpdate'        => true,
            'template'          => "{items}\n{pager}",
            'enablePagination'  => false
        )
    );
?>
<? $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
</div>
</div>
