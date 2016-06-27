<?php

class Slide extends CActiveRecord
{
    public $imagefolder = 'slides';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return '{{slides}}';
    }

    public function rules()
    {
        return array(
            array('name', 'required'),
            array('id, img, order, active, url, text1, text2, text3, slider_n', 'safe'),
        );
    }

    public function behaviors()
    {
        return array(
            #для загрузки изображений
            'imageUpload' => array(
                'class' => 'ImageUploadBehavior',
                'scenarios' => array('insert', 'update'), // действия, при которых сробатывает бихевиор

                'attributeNames' => array('img'), // массив имён для обработки бихевиором
                'uploadPath' => DS . 'images' . DS . 'slides', // корнево путь для загрузки файлов данного модуля

                'resize' => array(
                    'width' => 1200,
                    'height' => 1200
                ),
                'tumbs' => array(
                    'small' => array('width' => 100, 'height' => 100),
                    'medium' => array('width' => 300, 'height' => 300),
                    'big' => array('width' => 500, 'height' => 500),
                )
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название',
            'img' => 'Изображение',
            'order' => 'Порядок',
            'url' => 'Ссылка для слайда',
            'text1' => 'Текст 1',
            'text2' => 'Текст 2',
            'text3' => 'Текст 3',
            'active' => 'Активность',
            'slider_n' => 'Номер слайдера'
        );
    }

    public function search()
    {

        $criteria = new CDbCriteria;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 1000,
            ),
        ));
    }

}