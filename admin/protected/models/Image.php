<?php
Yii::import('application.helpers.YFile');

class Image extends CActiveRecord
{
    public $path = '/images/image';
    
    public $imagefolder = 'image';
         
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{images}}';
	}

	public function rules()
	{
		return array(
			array('id, object_id, photo, order, name, active, model', 'safe'),
		);
	}
    
    public function behaviors() {
        return array(
          
            #для загрузки изображений
            'imageUpload' => array(
				'class' => 'ImageUploadBehavior',
				'scenarios' => array('insert', 'update'), // действия, при которых сробатывает бихевиор
		  
				'attributeNames' => array('photo'), // массив имён для обработки бихевиором
				'uploadPath' => DS . 'images' . DS . 'image', // корнево путь для загрузки файлов данного модуля 
				
				'resize' => array(
					'width' => 800,
					'height' => 800
				),
				'tumbs' => array(
					'small' => array('width' => 80, 'height' => 80),
					'medium' => array('width' => 200, 'height' => 200),
					'big' => array('width' => 500, 'height' => 500),
				)
            )
        );
    }

	public function attributeLabels()
	{
		return array(
			'object_id'      => 'Идентификатор объекта',
			'photo'          => 'Изображение',
            'order'          => 'Порядок',
			'name'           => 'Название',
			'active'         => 'Активность',
            'model'          => 'Модель',
		);
	}
    
    public function afterDelete()
    {
        $folder = getImageFolder('image', $this->object_id);
        $name = $this->photo;
        if (@is_file(HOME . $folder . $name)) {

            $ext = end(explode('.', $name));
            $fileName = str_replace('.'.$ext, '', $name);
            
            foreach (glob(HOME . $folder . $fileName . '-' . '*') as $file){
                @unlink($file);
            }
            
            @unlink(HOME . $folder . $name);
        }
    }


    function savephoto_old($files, $object_id, $model){
        $quality = 100;
        $width = self::WIDTH;
        $height = self::HEIGHT;
        
        if(empty($files['name'][0]))
            return false;
        
        for ($i=0; $i< count($files['name']); $i++){
            
            $img = new Image;
            
            $tmp_name = '';
            $tmp_name = $files['name'][$i];         
            if(empty($tmp_name))
                continue;   
            $mas =  explode('.', $tmp_name);       
            $img->name              = substr($tmp_name, 0, strpos($tmp_name, end($mas)) - 1);
            $img->object_id         = $object_id;
            $img->model             = $model;
            $img->active            = 1;
            
            $tmpName = $files['tmp_name'][$i];
            $imageName = Image::_getImageName($files['name'][$i]);
            
            
            $image = Yii::app()->image->load($tmpName)->quality($quality);
            $uploadPath = Image::imageFolder($object_id);
             
            #проверка на возможность записи в папку
            if ( ! $newFile = YFile::pathIsWritable($imageName, $image->ext, HOME.$uploadPath))
                continue;
                
            if (($width !== null && $image->width > $width) || ($height !== null && $image->height > $height))
                $image->resize($width, $height);
                
    	    if ($image->save($newFile))
                $img->photo = pathinfo($newFile, PATHINFO_BASENAME);
            
            if(!empty($img->tumbs)){
                foreach($img->tumbs as $type => $size){
                    $image = Yii::app()->image->load($tmpName)->quality($quality);
                    $imageNameTumb = $imageName . '-' . $type . '-' . $size['width'] . 'x' . $size['height'];
                    $width = $size['width'];
                    $height = $size['height'];
                    if (($width !== null && $image->width > $width) || ($height !== null && $image->height > $height))
                        $image->resize($width, $height);
                    if ( ! $newFile = YFile::pathIsWritable($imageNameTumb, $image->ext, HOME.$uploadPath))
                        continue;
                    $image->save($newFile);
                }
            }
            
            $img->save();                
        }         
    }
    
    function savephoto($files, $object_id, $model) {
        if(empty($files['name'][0]))
            return false;
        
        for ($i=0; $i< count($files['name']); $i++){
            unset($_FILES);
            $_FILES['Image']['name']['photo']     = $files['name'][$i];
            $_FILES['Image']['type']['photo']     = $files['type'][$i];
            $_FILES['Image']['tmp_name']['photo'] = $files['tmp_name'][$i];
            $_FILES['Image']['error']['photo']    = $files['error'][$i];
            $_FILES['Image']['size']['photo']     = $files['size'][$i];
            
            $image = new Image();
            
            $tmp_name = '';
            $tmp_name = $files['name'][$i];         
            if(empty($tmp_name))
                continue;           
         
            $mas = explode('.', $tmp_name);     
            $image->name              = substr($tmp_name, 0, strpos($tmp_name, end($mas)) - 1);
            $image->object_id         = $object_id;
            $image->active            = 1;
            $image->model             = $model;
            $image->photo             = $tmp_name;
            $image->save();               
        }         
    }
    
    
}