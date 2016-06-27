<?php

class Article extends Back
{
    public $imagefolder = 'article';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return '{{articles}}';
    }

    public function rules()
    {

        return array(
            array('name', 'required'),
            array('category_id, active, meta_id, is_new, order, is_main, precent', 'numerical', 'integerOnly' => true),

            array('id, summary, content, img, date', 'safe'),
        );
    }


    public function behaviors()
    {

        return array(

            #для связных моделей
            'withRelated' => 'WithRelatedBehavior',

            #для загрузки изображений
            'imageUpload' => array(
                'class' => 'ImageUploadBehavior',
                'scenarios' => array('insert', 'update'), // действия, при которых сробатывает бихевиор

                'attributeNames' => array('img'), // массив имён для обработки бихевиором
                'uploadPath' => DS . 'images' . DS . 'article', // корнево путь для загрузки файлов данного модуля

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
            'category' => array(self::BELONGS_TO, 'ArticleCategory', 'category_id'),
            'metatag' => array(self::BELONGS_TO, 'MetaTag', 'meta_id'),
            'images' => array(self::HAS_MANY, 'Image', 'object_id', 'order' => 'images.order ASC, images.name ASC, images.id DESC'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название',
            'summary' => 'Краткое содержание',
            'content' => 'Полное содержание',
            'category_id' => 'Категория статьи',
            'active' => 'Отображать',
            'is_main' => 'Отображать на главной',
            'is_new' => 'Новая',
            'img' => 'Изображение',
            'order' => 'Порядок',
            'date' => 'Дата',
            'precent' => 'Скидка'
        );
    }


    public function search()
    {
        #Сохранение параметров поиска
        $filter = $this->saveFilterParam('Article', array(
            'category_id' => $_GET['Article']['category_id'],
            'name' => $this->name,
        ));
        $this->name = $filter['name'];

        $criteria = new CDbCriteria;
        if (isset($filter['category_id'])) {
            $category = $filter['category_id'];
            $categories = array();
            $categories[] = $category;
            $categories_sub = ArticleCategory::getChildsId($category);
            if (!empty($categories_sub))
                $categories = array_merge($categories, $categories_sub);
            $criteria->addInCondition('category_id', $categories);
        }

        if (!isset($_GET['Article_sort']))
            $criteria->order = "t.order ASC, id DESC";

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

        #тонкое место, ищем старницу типа "статьи" по type_id
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=2');
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