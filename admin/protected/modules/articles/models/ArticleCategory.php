<?php

class ArticleCategory extends Back
{
	public $imagefolder = 'article_category';
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return '{{article_categories}}';
	}

	
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('parent_id, active, order', 'numerical', 'integerOnly'=>true),
            
			array('id, summary, content, img', 'safe'),
		);
	}
    
    /**
     * Поведения для обработки определённых полей
     * вызов функции поведения $this->Название_поведения_в_модели->функция_в_поведении
    **/
    public function behaviors(){
        
            return array(
                #для деревьев
                'TreeBehavior' => array(
                    'class' => 'TreeBehavior',
                    'order' => 't.parent_id DESC',
                    'idParentField' => 'parent_id',
                    'with' => 'parent'
                ),
                
                #для связных моделей
                'withRelated' => 'WithRelatedBehavior',
                
                #для загрузки изображений
                'imageUpload' => array(
            		'class'             => 'ImageUploadBehavior',
            		'scenarios'         => array('insert', 'update'), // действия, при которых сробатывает бихевиор
                            
            		'attributeNames'    => array('img'), // массив имён для обработки бихевиором
            		'uploadPath'        => DS . 'images' . DS . 'article_category', // корнево путь для загрузки файлов данного модуля 
            		
            		'resize'            => array(
                                    'width'   => 800,
                                    'height'  => 800
                    ),
                    'tumbs'             => array(
                                    'small'             => array('width' => 100, 'height' => 100),
                                    'medium'            => array('width' => 300, 'height' => 300),
                                    'big'               => array('width' => 500, 'height' => 500),
                    )
                ),
        	);
    }
        

	
	public function relations(){
            return array(
                'parent'        => array(self::BELONGS_TO, 'ArticleCategory', 'parent_id'),
                'childrens'     => array(self::HAS_MANY, 'ArticleCategory', 'parent_id'),
                'articles'      => array(self::HAS_MANY, 'Article', 'category_id'),
                'metatag'       => array(self::BELONGS_TO, 'MetaTag', 'meta_id'),
                'images'        => array(self::HAS_MANY, 'Image', 'object_id', 'order' => 'images.order ASC, images.name ASC, images.id DESC'),	
           );
	}


    public function attributeLabels(){
    	return array(
                'id'         => 'ID',
                'name'       => 'Название ',
                'parent_id'  => 'Родитель',
                'active'     => 'Отоброжать',
                'is_main'    => 'На главную',
                'order'      => 'Порядок',
                'summary'    => 'Описание',
                'content'    => 'Содержание',
                'img'        => 'Изображение',
    	);
    }

    public function search() {
		$filter = $this->saveFilterParam('Material', array(
			'name' => $this->name,
			'parent_id' => $this->parent_id,
		));
		$this->name = $filter['name'];
		$this->parent_id = $filter['parent_id'];
		
        $criteria=new CDbCriteria;
        
        if(!isset($_GET['ArticleCategory_sort']))
			$criteria->order = "t.order ASC, id DESC";
            
    	$criteria->compare('id',$this->id);
    	$criteria->compare('name',$this->name,true);
    	$criteria->compare('t.parent_id',$this->parent_id);
  
        
    	return new CActiveDataProvider($this, array(
            'criteria'      =>  $criteria,
            'pagination'    =>  array(
                'pageSize'  =>  100000,
            ),
    	));
    }

    
    public function getTreeData(){        
        return ArticleCategory::model()->TreeBehavior->getTreeData();
    }
    
    public function getTreeList($str = '...'){
        $tree = ArticleCategory::model()->getTreeData();
        $categories = ArticleCategory::model()->TreeBehavior->getTreeList($tree, '..');
        
        return $categories;
    }
    
    #функция получает все дочерние id
	static function getChildsId($parent_id, $categories=null){
	    $criteria=new CDbCriteria;
    	$criteria->compare('t.parent_id', $parent_id);
        
        $categories_temp = self::model()->findAll($criteria);
        
        if(!empty($categories_temp)){
            foreach($categories_temp as $i => $cat){
                $categories[] = $cat->id;
      
                $criteria=new CDbCriteria;
            	$criteria->compare('t.parent_id', $cat->id);
                $categories_temp2 = self::model()->findAll($criteria);
                if(!empty($categories_temp2)){
                    $categories = self::getChildsId($cat->id, $categories);
                }
            }
        }
		return $categories;
	}
    
    
    protected function afterFind()
    {
        parent::afterFind();
        
        #тонкое место, ищем старницу типа "статьи" по type_id
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=2');
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