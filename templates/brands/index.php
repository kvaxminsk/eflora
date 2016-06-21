<?php  $this->breadcrumbs=array(
'Бренды'
);
?>

<div class="box">
<div class="box_head">Бренды</div>

<div class="box_body content">
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_brand',
    'template'=>"{items}\n{pager}",
    'pagerCssClass'=>'pager',
    'pager'=>array(
    	'header'         => '',
    	'firstPageLabel' => '&lt;&lt;',
    	'prevPageLabel'  => '<<',
    	'nextPageLabel'  => '>>',
    	'lastPageLabel'  => '&gt;&gt;',
    ),
)); ?>
<div style="clear: both;"></div>
</div> 
</div>
