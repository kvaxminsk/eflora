<?
$this->breadcrumbs=array(
	'Новости'
);
?>

<div class="form_pretext" style="padding-top: 12px;">
	Новости на сайте сортируются по дате следования!
</div>
	
<?
$actions=array( 
    array('value' => 'save',  'name' => 'Сохранить'),
    array('value' => 'on',    'name' => 'Опубликовать'),
    array('value' => 'off',   'name' => 'Снять с публикации'),
    array('value' => 'del',   'name' => 'Удалить'),
);

$template='{public} {update} {delete}';


$this->widget('zii.widgets.grid.CGridView', array(
        'id'                      =>  'cmaterial-grid',
		'jqurl'                   =>  Yii::app()->baseUrl.'/news/news/all',
		'rowCssClassExpression'   =>  '($data->active == 1) ? "row-public":"row-unpublic"',
		'dataProvider'            =>  $model->search(),
		'filter'                  =>  $model,
		'summaryText'             =>  '',
		'enableSorting'           =>  true,
		
		'enablePagination'        =>  true,
		'cssFile'                 =>  Yii::app()->baseUrl.'/css/gridView.css',
		'allActions'              =>  $actions,
		'columns'                 =>
        array(
    		array(
    		      'class'=>'CCheckBoxColumn',
    		      'selectableRows' => 3,
    		      'checkBoxHtmlOptions' => array('class' => 'chboxes'),
    
 			),
             array(
                'name'              =>  'order',
                'type'              =>  'raw',
                'header'            =>  'Порядок',
                'filter'            =>  '',
                'value'             =>  function ($data) {
                    return CHtml::textField('order', $data->order, array('style' => 'width:50px;'));
                },
                'htmlOptions'       =>  array('class' => 'textcolumn'),
                'headerHtmlOptions' =>  array('class' => 'textcolumn', 'style' => 'width:100px;')
            ),
                        
            array(		
					'name'              =>  'name',
					'type'              =>  'html',
					'value'             =>  'CHtml::link("$data->name",array("/news/news/update/","id"=>$data->id), array("title"=>"Просмотреть новость"))',
                    'header'            =>  'Название',
                    'htmlOptions'       =>  array('class' => 'textcolumn'),
                    'headerHtmlOptions' =>  array('class' => 'textcolumn') 
            ),	
            /*array(
				'name'                  =>  'date',
				'type'                  =>  'html',
				'htmlOptions'           =>  array('class' => 'textcolumn'),
                'headerHtmlOptions'     =>  array('class' => 'textcolumn')
            ),*/	
		
            array(
    			'class'          =>  'CButtonColumn',
    			'template'       =>  $template,
    			'buttons'=>array(
    					'public' => CGridView::getPublicButton(),
    					'update' => CGridView::getEditButton(),
    					'delete' => CGridView::getDeleteButton(),
                    ),      
            ), 
	   )
)); ?> 
