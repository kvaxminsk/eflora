<?php

class Subjects extends Back
{
    public $imagefolder = 'catalog_subjects';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return '{{catalog_subjects}}';
    }


    public function rules()
    {
        return array(
            array('name', 'required'),
            array('id, meta_id, order, active, is_main', 'numerical', 'integerOnly' => true),

            array('content, summary, img', 'safe'),
        );
    }

    /**
     * Поведения для обработки определённых полей
     * вызов функции поведения $this->Название_поведения_в_модели->функция_в_поведении
     **/
    public function behaviors()
    {

        return array(

            #для связных моделей
            'withRelated' => 'WithRelatedBehavior',

            #для загрузки изображений
            'imageUpload' => array(
                'class' => 'ImageUploadBehavior',
                'scenarios' => array('insert', 'update'), // действия, при которых сробатывает бихевиор

                //'requiredOn'      => array('insert', 'update'), // действия, при которых поле с изображением является обазательным
                'attributeNames' => array('img'), // массив имён для обработки бихевиором
                'uploadPath' => DS . 'images' . DS . 'catalog_subjects', // корнево путь для загрузки файлов данного модуля

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
            'products' => array(self::HAS_MANY, 'Product', 'subjects_id'),
            'metatag' => array(self::BELONGS_TO, 'MetaTag', 'meta_id'),
            'images' => array(self::HAS_MANY, 'Image', 'object_id', 'order' => 'images.order ASC, images.name ASC, images.id DESC'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название бренда',
            'active' => 'Отображать на сайте',
            'is_main' => 'Отображать на главной',
            'summary' => 'Описание',
            'content' => 'Содержание',
            'img' => 'Изображение',
            'order' => 'Порядок'
        );
    }

    public function search()
    {
        #Сохранение параметров поиска
        $filter = $this->saveFilterParam('Subjects', array(
            'name' => $this->name,
        ));
        $this->name = $filter['name'];

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);


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

        #тонкое место, ищем старницу типа "Бренд" по type_id
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=10');
        $material = Material::model()->with('metatag')->find($criteria);

        $url = '';
        if (!empty($material)) {
            $url = '/' . $material->metatag->uri . '/' . $material->metatag->alias;
            $url = str_replace('//', '/', $url);
        }
        if (!empty($this->metatag)) {
            $url = $url . '/' . $this->metatag->uri . '/' . $this->metatag->alias;
            $url = str_replace('//', '/', $url);
        }

        $this->url = $url;
    }

}