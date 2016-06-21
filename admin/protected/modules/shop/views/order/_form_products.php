<? if($model->id > 0):?>
<input id="product-id" placeholder="ИД товара" type="text" class="input-simple"/> <!--или 
<input id="product-articul" placeholder="Артикул товара" type="text" class="input-simple"/>-->
<input type="hidden" id="order-id" value="<?=$model->id;?>"/>
<button class="button-simple" id="add-product-order">Добавить товар</button>
<br /><br />
ИТОГО: <b id="total-order"><?=$model->price;?></b><br /><br />
<?
$criteria = new CDbCriteria;
$criteria->compare('order_id',$model->id);
$criteria->with = 'orderproduct';
$products = OrderProducts::model()->findAll($criteria);

$products = new CActiveDataProvider('OrderProducts', array(
      'criteria' => $criteria,
      'pagination' => array(
        'pageSize' => 1000,
      ),
));

$actions=array( 
    array('value' => 'save',  'name' => 'Сохранить'),
    array('value' => 'del', 'name' => 'Удалить'),
);

if (!empty($products)):
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'                      =>  'order-products-grid',
		'jqurl'                   =>  Yii::app()->baseUrl.'/shop/oproducts/all',
        'rowCssClassExpression'   =>  '($data->active == 1) ? "row-public":"row-unpublic"',
		'dataProvider'            =>  $products,
        
		'summaryText'             =>  '',
		'enableSorting'           =>  true,
		
		'enablePagination'        =>  false,
		'cssFile'                 =>  Yii::app()->baseUrl.'/css/gridView.css',
		'allActions'              =>  $actions,
		'columns'                 =>
        array(
				array(
						'class' => 'CCheckBoxColumn',
						'selectableRows' => 2,
						'checkBoxHtmlOptions' => array('class' => 'chboxes'),
				),
                array(
                    'name' => 'Изображение',
                    'type' => 'html',
                    'htmlOptions' => array('class' => 'td_center'),
                    'filter' => '',
                    'value' => function ($data) {
                        if(!empty($data->orderproduct->img['path'])){
                            return CHtml::image($data->orderproduct->img['path'], $data->orderproduct->name, array('style' => 'height: 100px;'));
                        }else {
                            return CHtml::image('/admin/images/no-photo.gif', $data->orderproduct->name, array('style' => 'height: 100px;'));
                        }
                    },
                ),
                array(
                    'name'              =>  'orderproduct[name]',
                    'type'              =>  'raw',
                    'header'            =>  'Название',
                    'value'             =>  '$data->orderproduct->name',
                    'htmlOptions'       =>  array('class' => 'textcolumn'),
                    'headerHtmlOptions' =>  array('class' => 'textcolumn')
                ),
                
                array(
                    'name'              =>  'price',
                    'type'              =>  'raw',
                    'header'            =>  'Цена',
                    'value'             =>  function ($data) {
                        return CHtml::textField('price', $data->price, array('style' => 'width:100px;'));
                    },
                    'htmlOptions'       =>  array('class' => 'textcolumn'),
                    'headerHtmlOptions' =>  array('class' => 'textcolumn')
                ),
                array(
                    'name'              =>  'count',
                    'type'              =>  'raw',
                    'header'            =>  'Количество',
                    'value'             =>  function ($data) {
                        return CHtml::textField('count', $data->count, array('style' => 'width:100px;'));
                    },
                    'htmlOptions'       =>  array('class' => 'textcolumn'),
                    'headerHtmlOptions' =>  array('class' => 'textcolumn')
                ),

				array(
						'class' => 'CButtonColumn',
						'template' => '{public} {delete}',
						'buttons' => array(
                            'public' => CGridView::getCustomButton('/admin/shop/oproducts/public' , 'public'),    
                            'delete' => CGridView::getCustomButton('/admin/shop/oproducts/delete' , 'delete'),
						),
				),
		),
    ));
endif;
?>

<? endif; ?>
