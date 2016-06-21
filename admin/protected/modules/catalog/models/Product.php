<?php

class Product extends Back
{    	
    public $imagefolder = 'product';
    
    public $product_flags = array(
        'active'        =>  'Активные',
        'stock'        =>   'Акция',
        'non-active'    =>  'Не активные',
        'is_top'        =>  'ТОП',
        'is_main'       =>  'На главную',
        'is_new'        =>  'Новинки',
        'is_pop'        =>  'Популярные',
        'is_sale'       =>  'Распродажа',
    );
    
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{catalog_products}}';
	}

	public function rules()
	{
       return array(
			array('name', 'required'),
			array('category_id, brand_id, active,stock, meta_id, is_top, is_new, order, is_main, is_sale, is_pop, count', 'numerical', 'integerOnly'=>true),
            
			array('id, summary, content, img, articul, price, discount, specifications, desc, price_1c, price_xls, 1c_id, img_size, articul, brand_model, manufacturer, original', 'safe')
		);
	}
    
    public function behaviors(){
        
        return array(
            
            #для связных моделей
            'withRelated' => 'WithRelatedBehavior',
            
            #для загрузки изображений
            'imageUpload' => array(
        		'class'             => 'ImageUploadBehavior',
        		'scenarios'         => array('insert', 'update'), // действия, при которых сробатывает бихевиор
                        
                        //'requiredOn'      => array('insert', 'update'), // действия, при которых поле с изображением является обазательным
        		'attributeNames'    => array('img'), // массив имён для обработки бихевиором
        		'uploadPath'        => DS . 'images' . DS . 'product', // корнево путь для загрузки файлов данного модуля 
        		
        		'resize'            => array(
                    'width'   => 800,
                    'height'  => 800
                ),
                'tumbs'             => array(
                    'small'             => array('width' => 100, 'height' => 100),
                    'medium'            => array('width' => 223, 'height' => 223),
                    'big'               => array('width' => 500, 'height' => 500),
                )
            ),
       	 );
    }

	public function relations()
	{
	    return array(
            'category'      => array(self::BELONGS_TO, 'Category', 'category_id'),
			'brand'      	=> array(self::BELONGS_TO, 'Subjects', 'brand_id'),
            'metatag'       => array(self::BELONGS_TO, 'MetaTag', 'meta_id'),
            'images'        => array(self::HAS_MANY, 'Image', 'object_id', 'order' => 'images.order ASC, images.name ASC, images.id DESC'),	
        );
	}

	public function attributeLabels()
	{
		return array(
			'id'             => 'ID',
			'name'           => 'Название',
            'desc'           => 'Краткое описание',
			'summary'        => 'Описание',
//            'specifications' => 'Алюминизированность',
            'content'        => 'Содержание',
//            'articul'        => 'Артикул',
			'price'          => 'Цена',
            'discount'      => 'Скидка',
			'category_id'    => 'Категория',
//            'brand_id'       => 'Марка автомобиля',
			'is_top'         => 'Распродажа',
			'active'         => 'Отображать в каталоге',
			'stock'         => 'Отображать в акциях',
//            'is_main'        => 'Популярные',
//			'is_top'         => 'ТОП',
//            'is_new'         => 'Новинка',
//            'is_sale'        => 'Распродажа',
//            'is_pop'         => 'Популярные',
			'img'            => 'Изображение',
		    'order'          => 'Порядок',
            'count'          => 'Остаток',
//			'brand_model'    => 'Модель автомобиля',
//			'manufacturer'   => 'Объем двигателя',
//			'original'       => 'Год выпуска'
		);
	}


	
	public function search()
	{
	    $criteria=new CDbCriteria;
		
		#Сохранение параметров поиска
		$filter = $this->saveFilterParam('Product', array(
			'price' => $_GET['Product']['price'],
			'name' => $_GET['Product']['name'],
			'articul' => $_GET['Product']['articul'],
			'category_id' => $_GET['Product']['category_id'],
			'active' => $_GET['Product']['active'],
		));
		
		if(isset($filter['category_id'])){
			$category = $filter['category_id'];
            $categories = array();
            $categories[] = $category;
            $categories_sub = Category::getChildsId($category);
            if(!empty($categories_sub))
                $categories = array_merge($categories, $categories_sub);
			$criteria->addInCondition('category_id', $categories);
		} 
                
        
    	if(!isset($_GET['Product_sort']))
			$criteria->order = "t.order ASC, t.id DESC";
	    
        if(!empty($filter['active'])){
            switch ($filter['active']){
                case 'non-active':
                    $criteria->addCondition('t.active=0');
                    break;
                default:
                    $criteria->addCondition('t.' . $filter['active'] . '=1');
				break;                        
            }
        }
		
		$this->name = $filter['name'];
		$this->price = $filter['price'];
		$this->articul = $filter['articul'];
		$this->category_id = $filter['category_id'];
		$this->active = $filter['active'];		
		
        $criteria->compare('t.name',$this->name,true);
        $criteria->compare('t.price',$this->price,true);
        $criteria->compare('t.articul',$this->articul,true);
        $criteria->with = array('category');
           
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
			     'pageSize' => 20,
			),
		));
	}

    protected function afterFind()
    {
        parent::afterFind();
        
        #тонкое место, ищем старницу типа "каталог" по type_id
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=5');
        $material = Material::model()->with('metatag')->find($criteria);
    
        $url = '';
        if(!empty($material)){
            $url = '/'. $material->metatag->uri. '/' . $material->metatag->alias;
            $url = str_replace('//', '/', $url);
        }
        if(!empty($this->metatag)){
            $url = $url . '/' . $this->metatag->uri . '/' . $this->metatag->alias;
            $url = str_replace('//', '/', $url); 
        }

        $this->url = $url;
    }
    
	
}