<?php

class Material extends Back {
    
    public $imagefolder = 'material';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{material}}';
    }

    public function rules() {
        return array(
            #обязательно для заполнения
            array('name', 'required'),
            #указываем все остальные поля, у которых нет правил
            array('content, summary, order, active, type_id, parent_id, img, code1, code2', 'safe'),
        );
    }

    public function relations() {
        return array(
            'parent'        => array(self::BELONGS_TO, 'Material', 'parent_id'),
            'childrens'     => array(self::HAS_MANY, 'Material', 'parent_id'),
            'metatag'       => array(self::BELONGS_TO, 'MetaTag', 'meta_id'),
            'images'        => array(self::HAS_MANY, 'Image', 'object_id', 'order' => 'images.order ASC, images.name ASC, images.id DESC'),
            'menu'          => array(self::MANY_MANY, 'Menu',
                Yii::app()->db->tablePrefix . 'menu_material(material_id, menu_id)'),
        );
    }

    public function behaviors() {
        return array(
            #для деревьев
            'TreeBehavior' => array(
                'class' => 'TreeBehavior',
                'order' => 't.name ASC',
                'idParentField' => 'parent_id',
                'with' => 'parent'
            ),
            
            #для связных моделей
            'withRelated' => 'WithRelatedBehavior',
            
            #для загрузки изображений
            'imageUpload' => array(
        		'class'             => 'ImageUploadBehavior',
        		'scenarios'         => array('insert', 'update'), // действия, при которых сробатывает бихевиор
                        
                        //'requiredOn'      => array('insert', 'update'), // действия, при которых поле с изображением является обазательным
        		'attributeNames'    => array('img'), // массив имён для обработки бихевиором
        		'uploadPath'        => DS . 'images' . DS . 'material', // корнево путь для загрузки файлов данного модуля 
        		
        		'resize'            => array(
                    'width'   => 800,
                    'height'  => 800
                ),
                'tumbs'             => array(
                    'small'             => array('width' => 50, 'height' => 50),
                    'medium'            => array('width' => 100, 'height' => 100),
                    'big'               => array('width' => 400, 'height' => 400),
                )
            ),
        	
        );
    }

    public function attributeLabels() {
        return array(
            'id'                => '№',
            'parent_id'         => 'Родитель',
            'name'              => 'Название',
            'desc'              => 'Описание',
            'order'             => 'Порядок',
            'content'           => 'Содержание',
            'keywords'          => 'Ключевые слова (keywords)',
            'description'       => 'Описание (description)',
            'title'             => 'Название страницы в окне браузера (title)',
            'h1'                => 'Заголовок',
            'active'            => 'Активность',
            'type_id'           => 'Тип страницы',
            'img'               => 'Изображение',
            'code1'             => 'Код 1',
            'code2'             => 'Код 2',
        );
    }

    public function search() {
		#Сохранение параметров поиска
		$filter = $this->saveFilterParam('Material', array(
			'name' => $this->name,
			'parent_id' => $this->parent_id,
		));
		$this->name = $filter['name'];
		$this->parent_id = $filter['parent_id'];
		
        $criteria = new CDbCriteria;
        $criteria->order = 't.order ASC, t.name ASC';
        $criteria->compare('name', $this->name, true);
        $criteria->compare('t.parent_id',$this->parent_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function getTreeData() {
        return Material::model()->TreeBehavior->getTreeData();
    }

    public function getTreeList($str = '...') {
        $tree = Material::model()->getTreeData();
        $materials = Material::model()->TreeBehavior->getTreeList($tree, '..');

        return $materials;
    }

    public function findAllData() {
        $materials = Material::model()->with('metatag')->findAll(array('order' => 't.order ASC'));
        $result = array();
        foreach ($materials as $key => $val) {
            $result[$key] = $val->attributes;
            $result[$key]['metatag'] = $val->metatag->attributes;
            $result[$key]['url'] = $val['url']; 
        }
        return $result;
    }
    
    protected function afterFind()
    {
        parent::afterFind();
        
        $url = '';
        if(!empty($this->metatag)){
            $url = $url . '/' . $this->metatag->uri . '/' . $this->metatag->alias;
            $url = preg_replace('#\/+#', '/', $url); 
        }
        $this->url = $url;
    }
    

    protected function afterSave() {
        $this->refreshMenu();
        parent::afterSave();
    }

    protected function refreshMenu() {
        $menu = $this->menu;
        
        if (is_array($menu) && (sizeof($menu) > 0)){
            if(is_numeric($menu[0])){
                
                MenuMaterial::model()->deleteAllByAttributes(array('material_id' => $this->id));
                
                foreach ($menu as $id) {
                    if (Menu::model()->exists('id=:id', array(':id' => $id))) {
    
                        $mm = new MenuMaterial();
                        $mm->material_id = $this->id;
                        $mm->menu_id = $id;
                        $mm->save();
                    }
                }
            }
        }
        
        if($menu == '#0#')
            MenuMaterial::model()->deleteAllByAttributes(array('material_id' => $this->id));
    }

}
