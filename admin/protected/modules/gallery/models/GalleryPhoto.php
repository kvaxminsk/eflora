<?php

class GalleryPhoto extends CActiveRecord
{
    public $imagefolder = 'gallery_photo';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{gallery_photo}}';
    }

    public function rules()
    {
        return array(
            array('id, gallery_id, image, name, active, order', 'safe'),
        );
    }

    public function behaviors()
    {
        return array(

            #для загрузки изображений
            'imageUpload' => array(
                'class' => 'ImageUploadBehavior',
                'scenarios' => array('insert', 'update'), // действия, при которых сробатывает бихевиор

                'attributeNames' => array('image'), // массив имён для обработки бихевиором
                'uploadPath' => DS . 'images' . DS . 'gallery_photo', // корнево путь для загрузки файлов данного модуля

                'resize' => array(
                    'width' => 800,
                    'height' => 800
                ),
                'tumbs' => array(
                    'small' => array('width' => 80, 'height' => 80),
                    'medium' => array('width' => 200, 'height' => 200),
                    'big' => array('width' => 500, 'height' => 500),
                )
            ),
        );
    }

    public function relations()
    {
        return array(//'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'galelry_id' => 'Альбом',
            'img' => 'Фото',
            'name' => 'Название',
            'active' => 'Отображать',
            'order' => 'Порядок'
        );
    }


    public function search()
    {

        $criteria = new CDbCriteria;

        if (isset($_GET['album'])) {
            $criteria->addCondition('album_id = :album');
            $criteria->params[':album'] = $_GET['album'];
        }

        $criteria->with = 'gallery';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
        ));
    }

    function savephoto($files, $gallery_id)
    {


        if (empty($files['name'][0]))
            return false;

        for ($i = 0; $i < count($files['name']); $i++) {
            unset($_FILES);
            $_FILES['GalleryPhoto']['name']['image'] = $files['name'][$i];
            $_FILES['GalleryPhoto']['type']['image'] = $files['type'][$i];
            $_FILES['GalleryPhoto']['tmp_name']['image'] = $files['tmp_name'][$i];
            $_FILES['GalleryPhoto']['error']['image'] = $files['error'][$i];
            $_FILES['GalleryPhoto']['size']['image'] = $files['size'][$i];

            $photo = new GalleryPhoto();

            $tmp_name = '';
            $tmp_name = $files['name'][$i];
            if (empty($tmp_name))
                continue;


            $mas = explode('.', $tmp_name);
            $photo->name = substr($tmp_name, 0, strpos($tmp_name, end($mas)) - 1);
            $photo->gallery_id = $gallery_id;
            $photo->active = 1;
            $photo->image = $tmp_name;

            $photo->save();
        }
    }

    public function afterDelete()
    {
        $folder = getImageFolder('gallery_photo', $this->id);

        $image = $this->image;
        $name = $image['name'];
        $path = $image['path'];

        if (@is_file(HOME . $path)) {
            $mas = explode('.', $name);
            $ext = end($mas);
            $fileName = str_replace('.' . $ext, '', $name);
            $files = glob(HOME . $folder . $fileName . '-' . '*');
            if (!empty($files)) {
                foreach ($files as $f) {
                    @unlink($f);
                }
            }

            @unlink(HOME . $path);
        }
    }

}