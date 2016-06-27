<?php

class Faq extends Back
{
    public $imagefolder = 'faq';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return '{{faqs}}';
    }

    public function rules()
    {

        return array(
            array('active, order', 'numerical', 'integerOnly' => true),

            array('id, question, answer, name, phone, email, img, date', 'safe'),
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
                'uploadPath' => DS . 'images' . DS . 'faq', // корнево путь для загрузки файлов данного модуля

                'resize' => array(
                    'width' => 800,
                    'height' => 800
                ),
                'tumbs' => array(
                    'small' => array('width' => 100, 'height' => 100),
                    'medium' => array('width' => 300, 'height' => 300),
                    'big' => array('width' => 500, 'height' => 500),
                )
            ),
        );
    }

    public function relations()
    {
        return array(
            'images' => array(self::HAS_MANY, 'Image', 'object_id', 'order' => 'images.order ASC, images.name ASC, images.id DESC'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'active' => 'Отображать',
            'img' => 'Изображение',
            'order' => 'Порядок',
            'date' => 'Дата'
        );
    }

    public function search()
    {
        $filter = $this->saveFilterParam('Faq', array(
            'question' => $this->question,
            'name' => $this->name,
        ));
        $this->question = $filter['question'];
        $this->name = $filter['name'];

        $criteria = new CDbCriteria;

        if (!isset($_GET['Faq_sort']))
            $criteria->order = "t.order ASC, id DESC";

        $criteria->compare('question', $this->question, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }


}