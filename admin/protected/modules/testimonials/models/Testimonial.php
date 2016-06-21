<?php

class Testimonial extends Back
{    	
    public $imagefolder = 'testimonial';
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return '{{testimonials}}';
	}

	public function rules()
	{
	
		return array(
			array('active, order', 'numerical', 'integerOnly'=>true),
            
			array('id, testimonial, answer, name, phone, email, img, date', 'safe'),
		);
	}


    public function behaviors(){
        
        return array(
            #для загрузки изображений
            'imageUpload' => array(
        		'class'             => 'ImageUploadBehavior',
        		'scenarios'         => array('insert', 'update'), // действия, при которых сробатывает бихевиор
 
        		'attributeNames'    => array('img'), // массив имён для обработки бихевиором
        		'uploadPath'        => DS . 'images' . DS . 'testimonial', // корнево путь для загрузки файлов данного модуля 
        		
        		'resize'            => array(
                            'width'   => 1200,
                            'height'  => 2000,
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
            'images'        => array(self::HAS_MANY, 'Image', 'object_id', 'order' => 'images.order ASC, images.name ASC, images.id DESC'),	
        );
	}

	public function attributeLabels()
	{
		return array(
			'id'             => 'ID',
			'name'           => 'Имя',
            'phone'          => 'Телефон',
            'email'          => 'E-mail',
			'testimonial'    => 'Отзыв',
            'answer'         => 'Ответ',            
			'active'         => 'Отображать',
			'img'            => 'Изображение',
		    'order'          => 'Порядок',
            'date'           => 'Дата'
		);
	}
	
	public function search()
	{ 
        $filter = $this->saveFilterParam('Material', array(
			'name' => $this->name,
			'date' => $this->date,
			'testimonial' => $this->testimonial,
		));
		$this->name = $filter['name'];
		$this->date = $filter['date'];
		$this->testimonial = $filter['testimonial'];
		
        $criteria=new CDbCriteria;
        
    	if(!isset($_GET['Testimonial_sort']))
			$criteria->order = "t.order ASC, id DESC";
	    
        $criteria->compare('testimonial', $this->testimonial,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('date',$this->date,true);
           
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
			     'pageSize' => 20,
			),
		));
	}    
    

}