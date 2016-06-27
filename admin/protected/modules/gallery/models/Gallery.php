<?php

class Gallery extends Back
{
    public $imagefolder = 'gallery';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{galleries}}';
    }


    public function rules()
    {

        return array(
            array('name', 'required'),
            array('parent_id, active, order, meta_id, is_main', 'numerical', 'integerOnly' => true),
            array('id, summary, content, img', 'safe'),
        );
    }

    public function behaviors()
    {
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
                'class' => 'ImageUploadBehavior',
                'scenarios' => array('insert', 'update'), // действия, при которых сробатывает бихевиор

                'attributeNames' => array('img'), // массив имён для обработки бихевиором
                'uploadPath' => DS . 'images' . DS . 'gallery', // корнево путь для загрузки файлов данного модуля

                'resize' => array(
                    'width' => 800,
                    'height' => 800
                ),
                'tumbs' => array(
                    'small' => array('width' => 50, 'height' => 50),
                    'medium' => array('width' => 200, 'height' => 200),
                    'big' => array('width' => 400, 'height' => 400),
                )
            ),
        );
    }

    public function relations()
    {
        return array(
            'parent' => array(self::BELONGS_TO, 'Gallery', 'parent_id'),
            'photo' => array(self::HAS_MANY, 'GalleryPhoto', 'gallery_id'),
            'metatag' => array(self::BELONGS_TO, 'MetaTag', 'meta_id'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название',
            'parent_id' => 'Родитель',
            'summary' => 'Описание',
            'content' => 'Содержание',
            'img' => 'Абложка',
            'active' => 'Опубликовать',
            'is_main' => 'На главную',
            'order' => 'Порядок',
        );
    }


    public function search()
    {
        $filter = $this->saveFilterParam('Gallery', array(
            'name' => $this->name,
            'parent_id' => $this->parent_id,
        ));
        $this->name = $filter['name'];
        $this->parent_id = $filter['parent_id'];

        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $criteria->compare('t.parent_id', $this->parent_id);
        $criteria->compare('t.order', $this->order);

        $criteria->order = 't.order ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' =>
                array(
                    'pageSize' => 100000,
                ),
        ));
    }

    public function getTreeData()
    {
        return self::model()->TreeBehavior->getTreeData();
    }

    public function getTreeList($str = '...')
    {
        $tree = self::model()->getTreeData();
        $categories = self::model()->TreeBehavior->getTreeList($tree, '..');

        return $categories;
    }

    static function getAlbums()
    {
        return self::model()->findAll();
    }

    protected function afterFind()
    {
        parent::afterFind();

        #тонкое место, ищем старницу типа "статьи" по type_id
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=6');
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