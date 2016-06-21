<?php

class MetaTag extends CActiveRecord {

    public $url;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{meta_tags}}';
    }

    public function rules() {
        return array(
            array('title, h1, keywords, description, other, alias, uri, action, module, controller', 'safe'),
        );
    }

    public function relations() {
        return array(
            'metatag' => array(self::HAS_ONE, 'Material, News', 'meta_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'title' => 'Title страницы',
            'h1' => 'H1 для страницы',
            'description' => 'Описание',
            'keywords' => 'Ключевые слова',
            'other' => 'Текстовый блок',
            'alias' => 'Псевдоним',
            'active' => 'Активность',
            'uri' => 'Ccылка без псевдонима',
            'module' => 'Модуль',
            'controller' => 'Контроллер',
            'action' => 'Функция'
        );
    }

    public function beforeSave() {
        #если совпадает псевдоним        
        $temp = MetaTag::model()->find('alias=:alias', array(':alias' => $this->alias));
        if (empty($temp->id) || ($temp->id != $this->id) || ($this->alias == '')){
            $this->alias = $this->createAlias($this->alias);
        }
        
        return parent::beforeSave();
    }

    public function createAlias($string = '') {
        if ($string == '/')
            return $string;

        $alias = totranslit($string, '-');

        $result = $alias;

        $n = 2;
        $s = $alias;
        while ($item = MetaTag::model()->find('alias=:alias', array(':alias' => $s))) {
            $s = $alias . '-' . $n;
            $result = $s;
            $n++;
        }
        return $result;
    }
    
    public function updateUri($in, $out, $class) {
        $result = $in->metatag->uri;
        if (!empty($in) && (!empty($out))){
            $table = Yii::app()->db->tablePrefix . 'meta_tags';
            
            $alias_old = $in->metatag->alias;
            $alias_new = $out->metatag->alias;
            
            #если изменили родительский элемент
            if (isset($out->parent_id)){
                $parent_id_old = $in->parent_id;
                $parent_id_new = $out->parent_id;
                
                if($parent_id_old != $parent_id_new){
                    $old_uri = '/' . $in->metatag->uri . '/' . $in->metatag->alias . '/';
                    $old_uri = str_replace('//', '/', $old_uri);
                    
                    $new_uri = '';
                    if ($parent_id_new > 0){
                        $parent_new = $class::model()->with('metatag')->findByPk($parent_id_new);
                        $new_uri = '/' . $parent_new->metatag->uri . '/' . $parent_new->metatag->alias . '/';
                        $new_uri = str_replace('//', '/', $new_uri);
                        $result = $new_uri;
                    }
                    
                    $new_uri = '/' . $new_uri. '/' . $in->metatag->alias . '/';
                    $new_uri = str_replace('//', '/', $new_uri);
                    //p($old_uri,0); p($new_uri);
                    Yii::app()->db->createCommand("UPDATE `$table` SET `uri` = REPLACE(`uri`, '$old_uri', '$new_uri')")->query();                 
                }
            }
            
            #если изменили категорию
            if (isset($out->category_id)){
                
                $category_id_old = $in->category_id;
                $category_id_new = $out->category_id;
                
                if($category_id_old != $category_id_new){                    
                    if ($category_id_new > 0){
                        $category_new = $class::model()->with('metatag')->findByPk($category_id_new);
                        $new_uri = '/' . $category_new->metatag->uri . '/' . $category_new->metatag->alias . '/';
                        $new_uri = str_replace('//', '/', $new_uri);
                        $result = $new_uri;
                    }                   
                }
            }
            
            #выполняем в самом конце, если изменился элиас
            if(($alias_old != '') && ($alias_old != $alias_new)){
                Yii::app()->db->createCommand("UPDATE `$table` SET `uri` = REPLACE(`uri`, '/$alias_old/', '/$alias_new/')")->query();
            }
    
        }
        
        return $result;

    }
    
     public function createUri($model, $class) {
        $result = '';
        if (!empty($model)){
            $table = Yii::app()->db->tablePrefix . 'meta_tags';
                        
            #если есть родительский элемент
            if (isset($model->parent_id)){
                if($model->parent_id > 0){
                    $parent_id = $model->parent_id;
                    $parent_new = $class::model()->with('metatag')->findByPk($parent_id);
                    $new_uri = '/' . $parent_new->metatag->uri . '/' . $parent_new->metatag->alias . '/';
                    $new_uri = str_replace('//', '/', $new_uri);
                    $result = $new_uri;
                }
            }
            
            #если есть категория
            if (isset($model->category_id)){
                if($model->category_id){
                    $category_id = $model->category_id;                 
                    $category_new = $class::model()->with('metatag')->findByPk($category_id);
                    $new_uri = '/' . $category_new->metatag->uri . '/' . $category_new->metatag->alias . '/';
                    $new_uri = str_replace('//', '/', $new_uri);
                    $result = $new_uri;
                }
            }
    
        }
        
        return $result;

    }

}
