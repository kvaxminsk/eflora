<?php

Yii::import('application.helpers.YFile');

class ImageUploadBehavior extends CActiveRecordBehavior
{
    /* 
     * Атрибуты модели для хранения изображения
     */
    public $attributeNames = array('image');


    /*
     * Загружаемое изображение
     */
    public $image = '';
    /*
     * Минимальный размер загружаемого изображения
     */
    public $minSize = 0;

    /*
     * Максимальный размер загружаемого изображения
     */
    public $maxSize = 5368709120;

    /*
     * Допустимые типы изображений
     */
    public $types = 'jpg,jpeg,png,gif';
    /*
     * Список сценариев в которых будет использовано поведение
     */
    public $scenarios = array('insert', 'update');
    /*
     * Директория для загрузки изображений
     */
    public $uploadPath;
    /*
     * Список сценариев в которых изображение обязательно, 'insert, update'
     */
    public $requiredOn;

    /*
     * Callback функция для генерации имени загружаемого файла
     */
    public $imageNameCallback;
    /*
     * Параметры для ресайза изображения
     */
    public $resize = array('quality' => 100);
    
    /*
     * Параметры для уменьшенных изображений
     */
    public $tumbs = array();
	public $wmFile = '/images/watermark.png';
    
    

    protected $_newImage = array();
    protected $_oldImage = array();
    protected $_imgName = array();

    public function attach($owner)
    {
        parent::attach($owner);
        
        if ($this->checkScenario())
        {
            if ($this->requiredOn)
            {
                foreach($this->attributeNames as $i => $an){
                    $requiredValidator = CValidator::createValidator('required', $owner, $an, array(
                        'on' => $this->requiredOn,
                    ));
                    $owner->validatorList->add($requiredValidator);    
                }
            }
            foreach($this->attributeNames as $i => $an){
                $fileValidator = CValidator::createValidator('file', $owner, $an, array(
                    'types'      => $this->types,
                    'minSize'    => $this->minSize,
                    'maxSize'    => $this->maxSize,
                    'allowEmpty' => true,
                ));
                $owner->validatorList->add($fileValidator);
            }
        }
    }

    public function afterFind($event)
    {   
        $this->uploadPath = $this->imageFolder($this->owner->id);
        foreach($this->attributeNames as $i => $an){
            $this->_oldImage[$i] = $this->uploadPath . $this->owner{$an};
            $result = array();
            $result['name'] = $this->owner{$an};
            if(trim($result['name']) != ''){
                if(is_file(HOME . $this->uploadPath . $this->owner{$an})){
                    if(!empty($this->tumbs)){
                        foreach($this->tumbs as $type => $size){
                            $mas = explode('.', $this->owner{$an});
                            $ext = strtolower(end($mas));
                            $imageName = str_replace('.' . $ext, '', $this->owner{$an});
                            $imageNameTumb = $imageName . '-' . $type . '-' . $size['width'] . 'x' . $size['height'] . '.' . $ext;
                            $result[$type] = $this->uploadPath . $imageNameTumb;
                        }
                    }
                    $result['path'] = $this->uploadPath . $this->owner{$an};
                }
            }
            $this->owner->{$an} = $result;
        }
    }

    public function beforeValidate($event)
    {
        
        foreach($this->attributeNames as $i => $an){
            $this->_newImage[$i] = CUploadedFile::getInstance($this->owner, $an);
        }        
        if ($this->checkScenario()) {
            foreach($this->attributeNames as $i => $an){
                if(!empty($this->_newImage[$i])){
                    $this->owner->{$an} = $this->_newImage[$i];
                }
            }
        }
    }

    public function beforeSave($event)
    {
        if ($this->checkScenario())
        {   
            $this->saveImageName();
        }
    }
    
    public function afterSave($event)
    {
        if ($this->checkScenario())
        {   if($this->owner->scenario == 'insert')
                $this->uploadPath = $this->imageFolder($this->owner->id);
            $this->saveImage();
            $this->deleteImage();
        }
    }

    public function beforeDelete($event)
    {
        $this->deleteImage();
    }

    /**
     * Удаление старых фото при закачке новых
     * */
    public function deleteImage()
    {
        foreach($this->_oldImage as $i => $oi){
            if (@is_file(HOME . $oi) && (!empty($this->_newImage[$i]))) {
                // Удаляем связанные с данным изображением превьюшки:
                $fileName = pathinfo($oi, PATHINFO_BASENAME);
                
                $mas = explode('.', $fileName);
                $ext = end($mas);
                $fileName = str_replace('.'.$ext, '', $fileName);
                
                $files = glob(HOME . $this->uploadPath . $fileName . '-' . '*');
                if(!empty($files)){
                    foreach ($files as $f){
                        @unlink($f);
                    }
                }                
                @unlink(HOME . $oi);
            }
        }
    }

    /**
     * Проверяет допустимо ли использовать поведение в текущем сценарии
     **/
    public function checkScenario()
    {
        return in_array($this->owner->scenario, $this->scenarios);
    }

    /**
     * Генерирует имя файла
     **/
    protected  function _getImageName($name) 
    {
        $mas = explode('.', $name);
        $ext = strtolower(end($mas));
        $name = str_replace('.'.$ext, '', $name);
        $name =  strtolower(totranslit(mt_rand(100, 999) . '-' . $name, true, true));
        return $name;

    }

    public function saveImageName()
    {        
        foreach($this->_newImage as $i => $nimg){
        
            if(empty($nimg->tempName)){
                if(!empty($this->owner{$this->attributeNames[$i]})){
                    $imgmas = $this->owner{$this->attributeNames[$i]};
                    $this->owner->{$this->attributeNames[$i]} = $imgmas['name'];
                }
                continue;
            }
            $tmpName = $nimg->tempName;
            
            $imageName = $this->_getImageName($nimg->name);
            $mas = explode('.', $nimg->name);
            $ext = strtolower(end($mas));
           
            $this->_imgName[$i] = $imageName;
            $this->owner->{$this->attributeNames[$i]} = $imageName . '.' . $ext;           
        }
    }
    
    public function saveImage()
    {
        $quality = 100;
        $width = isset($this->resize['width']) ? $this->resize['width'] : null;
        $height = isset($this->resize['height']) ? $this->resize['height'] : null;
        
        foreach($this->_newImage as $i => $nimg){
            if(empty($nimg->tempName))
                continue;
                
            $tmpName = $nimg->tempName;
            $imageName = $this->_imgName[$i];
            
            $mas = explode('.', $nimg->name);
            $ext = strtolower(end($mas));
            $image = Yii::app()->image->load($tmpName)->quality($quality);
			
            #проверка на возможность записи в папку
            if ( ! $newFile = YFile::pathIsWritable($imageName, $ext, HOME.$this->uploadPath))
                continue;
  
            if (($width !== null && $image->width > $width) || ($height !== null && $image->height > $height))
                $image->resize($width, $height);
                
    	    if ($image->save($newFile))
                $this->owner->{$this->attributeNames[$i]} = pathinfo($newFile, PATHINFO_BASENAME);
            
            if(!empty($this->tumbs)){
                foreach($this->tumbs as $type => $size){
                    $image = Yii::app()->image->load($tmpName)->quality($quality);
                    $imageNameTumb = $imageName . '-' . $type . '-' . $size['width'] . 'x' . $size['height'];
                    $width = $size['width'];
                    $height = $size['height'];
                    if (($width !== null && $image->width > $width) || ($height !== null && $image->height > $height))
                        $image->resize($width, $height);
                    $newFile = YFile::pathIsWritable($imageNameTumb, $ext, HOME.$this->uploadPath);
                    $image->save($newFile);
                }
            }
                        
            
         }
    }

    
    public function imageFolder($id){
        $path = explode('/', $this->uploadPath);
        $main_category = end($path);
        $subdir = substr('00000'.$id, -6);
        $maindir = substr($subdir, 0, 3);   
        
        if(!is_dir(HOME.$this->uploadPath)){
            mkdir(HOME.$this->uploadPath);
        }
        if(!is_dir(HOME.$this->uploadPath . DS . $maindir)){
            mkdir(HOME.$this->uploadPath . DS . $maindir);
        }
        
        if(!is_dir(HOME.$this->uploadPath . DS . $maindir . DS . $subdir)){
            mkdir(HOME.$this->uploadPath . DS . $maindir . DS . $subdir);
        }
        
        $dir = $this->uploadPath . DS . $maindir . DS . $subdir . DS;
        
        $dir = str_replace(DS, '/', $dir);        
        return $dir;
    }
}
