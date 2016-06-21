<?php

class News extends Back
{    	
    public $imagefolder = 'news';
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return '{{news}}';
	}

	public function rules()
	{
	
		return array(
			array('name', 'required'),
			array('active, meta_id, is_new, order, is_main', 'numerical', 'integerOnly'=>true),
            
			array('id, summary, content, img, date', 'safe'),
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
 
        		'attributeNames'    => array('img'), // массив имён для обработки бихевиором
        		'uploadPath'        => DS . 'images' . DS . 'news', // корнево путь для загрузки файлов данного модуля 
        		
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

	public function relations()
	{
	    return array(
            'metatag'       => array(self::BELONGS_TO, 'MetaTag', 'meta_id'),
            'images'        => array(self::HAS_MANY, 'Image', 'object_id', 'order' => 'images.order ASC, images.name ASC, images.id DESC'),	
        );
	}

	public function attributeLabels()
	{
		return array(
			'id'             => 'ID',
			'name'           => 'Название',
			'summary'        => 'Краткое содержание',
            'content'        => 'Полное содержание',            
			'active'         => 'Отображать',
			'is_main'        => 'Отображать на главной',
            'is_new'         => 'Новая',
			'img'            => 'Изображение',
		    'order'          => 'Порядок',
            'date'           => 'Дата'
		);
	}
	
	public function search()
	{ 
        $filter = $this->saveFilterParam('News', array(
			'name' => $this->name,
		));
		$this->name = $filter['name'];
		
        $criteria=new CDbCriteria;
        
    	if(!isset($_GET['Article_sort']))
			$criteria->order = "t.order ASC, id DESC";
	    
        $criteria->compare('name',$this->name,true);
        $criteria->compare('date',$this->date,true);
           
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
        
        #тонкое место, ищем старницу типа "новости" по type_id
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=12');
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