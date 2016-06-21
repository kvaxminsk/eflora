<?php
$this->breadcrumbs=array(
	'Товары'
);
 
$actions = array( 
    array('value' => 'save',  'name' => 'Сохранить'),
    array('value' => 'on',    'name' => 'Опубликовать'),
    array('value' => 'off',   'name' => 'Снять с публикации'),
    array('value' => 'del',   'name' => 'Удалить'),
);

$template='{public} {update} {delete}';

$this->widget('zii.widgets.grid.CGridView', array(
        'id'                      =>  'cmaterial-grid',
		'jqurl'                   =>  Yii::app()->baseUrl.'/catalog/product/all',
		'rowCssClassExpression'   =>  '($data->active == 1) ? "row-public":"row-unpublic"',
		'dataProvider'            =>  $model->search(),
		'filter'                  =>  $model,
		'summaryText'             =>  '',
		'enableSorting'           =>  true,
		'pager'                   =>  array('nextPageLabel' => '>>', 'prevPageLabel' => '<<',),
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
                    'name'              =>  'price',
                    'type'              =>  'raw',
                    'header'            =>  'Цена',
                    'value'             =>  function ($data) {
                        return CHtml::textField('price', $data->price, array('style' => 'width:100px;'));
                    },
                    'htmlOptions'       =>  array('class' => 'textcolumn'),
                    'headerHtmlOptions' =>  array('class' => 'textcolumn', 'style' => 'width:100px;')
            ),
            
    		array(
                'name' => 'Изображение',
                'type' => 'html',
                'htmlOptions' => array('class' => 'td_center'),
                'filter' => '',
                
                'value' => function ($data) {
                    if (isset($data->img['path'])) {
						return 
							'<a class="fancybox" href="'. $data->img['path'] . '">' . 
								CHtml::image($data->img['small'], $data->name, array('style' => 'height: 100px;')) . 
							'</a>';
					} else {
						return CHtml::image('/admin/images/no-photo.gif', $data->name, array('style' => 'height: 100px;'));
					}
                },
                'headerHtmlOptions' =>  array('class' => 'textcolumn', 'style' => 'width:100px;')
			),
            
            array(		
					'name' =>'name',
					'type' =>'html',
					'value' => 'CHtml::link("$data->name",array("/catalog/product/update/","id"=>$data->id), array("title"=>"Просмотреть товар"))',
                    'header'            =>  'Название',
                    'htmlOptions'       =>  array('class' => 'textcolumn'),
                    'headerHtmlOptions' =>  array('class' => 'textcolumn') 
            ),
//            array(
//                    'name'              =>  'articul',
//                    'type'              =>  'raw',
//                    'header'            =>  'Артикул',
//                    'value'             =>  function ($data) {
//                        return CHtml::textField('articul', $data->articul, array('style' => 'width:100px;'));
//                    },
//                    'htmlOptions'       =>  array('class' => 'textcolumn'),
//                    'headerHtmlOptions' =>  array('class' => 'textcolumn', 'style' => 'width:100px;')
//            ),
            array(
					'header'          => 'Категория',
					'name'            => 'category_id',
                    'filter'          => $categories,
					'value'           => function ($data) {
                        if(!empty($data->category->name)){
                            return CHtml::encode($data->category->name);
                        }else {
                            if($data->category_id > 0)
                                return 'Категория удалена';
                            else
                                return 'Нет';
                        }
                    },
                    'htmlOptions'     =>  array('class' => 'textcolumn', 'style' => 'width:100px;'),
                    'headerHtmlOptions'   =>  array('class' => 'textcolumn', 'style' => 'width:100px;'),           
			),
            
            /*array(
					'header'          => 'Ярлыки',
					'name'            => 'active',
                    'type'            => 'html',
                    'filter'          => $flags,
					'value'           => function ($data) {
					    $return = '';   
                        if(!empty($data->is_top)){
                            if($data->is_top){
                                $return .= 'ТОП<br/>';
                            }
                        }
                        if(!empty($data->is_main)){
                            if($data->is_main){
                                $return .= 'На главную<br/>';
                            }
                        }
                        if(!empty($data->is_new)){
                            if($data->is_new){
                                $return .= 'Новинка<br/>';
                            }
                        }
                        if(!empty($data->is_pop)){
                            if($data->is_pop){
                                $return .= 'Популярный<br/>';
                            }
                        }
                        if(!empty($data->is_sale)){
                            if($data->is_sale){
                                $return .= 'Распродажа<br/>';
                            }
                        }
                        return $return;
                    },
                    'htmlOptions'     =>  array('class' => 'textcolumn', 'style' => 'width:100px;'),
                    'headerHtmlOptions'   =>  array('class' => 'textcolumn', 'style' => 'width:100px;'),           
			),*/
			
		
            array(
    			'class'      => 'CButtonColumn',
    			'template'   => $template,
    			'buttons'    => array(
    					'public' => CGridView::getPublicButton(),
    					'update' => CGridView::getEditButton(),
    					'delete' => CGridView::getDeleteButton(),
                    ),      
            ), 
	   )
)); ?> 
