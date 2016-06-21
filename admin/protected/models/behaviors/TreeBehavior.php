<?php
class TreeBehavior extends CActiveRecordBehavior {

  /**
   * Сортировка данных: имя поля родителя, имя поля порядка
   * @property string
   */
  public $order = 'parent_id DESC, order ASC';
  
  public $ids = array();
  /**
   * Имя поля родительского ключа
   * @property string
   */
  public $idParentField = 'parent_id';
  /**
   * with-параметр для выборки
   * @var string
   */
  public $with = null;
  
  public $addCondition = array();
  
  private $_parent = null;
  private $_child = array();
  
  private static $_tree = array();
  
  /**
   * Установка родительского экземпляра
   * @param CActiveRecord $parent Родитель
   */
  public function setParent(CActiveRecord $parent) {
    $this->_parent = $parent;
  }
  /**
   * Установка дочерних экземепляров
   * @param array $child массив из дочерних экземпляров
   */
  public function setChild(array $child) {
    $this->_child = $child;
  }
  /**
   * Добавление дочки
   * @param CActiveRecord $child дочерний экземпляр
   */
  public function addChild(CActiveRecord $child) {
    $this->_child[] = $child;
  }
  
  /**
   * Получение дерева экземпляров модели
   */
  public function getTree() {
    $cacheKey = $this->owner->tableName();
    if ( isset(self::$_tree[$cacheKey]) ) {
      return self::$_tree[$cacheKey];
    }
   
    
    $tree = array();
    if (($cache = Yii::app()->cache) !== null && ($val = $cache->get($cacheKey)) !== false) {
      $tree = $val;
    } else {
      $criteria = new CDbCriteria();
      $criteria->order = $this->order;
      if(count($this->ids) > 0)
            $criteria->addInCondition('t.id',$this->ids);

     
      if ($this->addCondition != null){
        if(is_array($this->addCondition)){
            foreach($this->addCondition as $i => $con){
                $criteria->addCondition($con);
            }
        }
      }        
      
      if ($this->with != null) $criteria->with = $this->with;

      $items = $this->owner->model()->findAll($criteria);
      
       
      $child = array();
      $countIntems = count($items);
      
      $idParentField = $this->idParentField;
     
      for($i = 0; $i < $countIntems; $i++) {
        $item = $items[$i];
        $id = $item->getPrimaryKey();
        $idParent = $item->$idParentField;
        
        if ($idParent !== null) {
          $child[$idParent][] = $item;
        }
      }
      $tree = $this->owner->model();
      for ($i = 0; $i < $countIntems; $i++) {
        $item = $items[$i];
        $id = $item->getPrimaryKey();
         
        if (isset($child[$id])) {
          $countChild = count($child[$id]);
          for($k = 0; $k < $countChild; $k++) {
            $child[$id][$k]->setParent($item);
          }
          $item->setChild($child[$id]);
        }
        
        #изменил для построения дерева
        if ($item->$idParentField == 0) {
          $tree->addChild($item);
        }
      }
      
      if ($cache !== null) {
        $cache->set($cacheKey, $tree, 3600);
      }
      
      
    }

    self::$_tree[$cacheKey] = $tree;
    
    return $tree;
  }
  
   
  /**
   * Получение родительского экземпляра
   */
  public function getParent() {
    $idParentField = $this->idParentField;
    if ($this->owner->$idParentField !== null && $this->_parent === null) {
      $this->_parent = $this->owner->model()->findByPk($this->owner->getPrimaryKey());
    } 
    return $this->_parent;
  }  
  
  /**
   * Получение количества детей
   */
  public function getChildCount() {
    return count($this->_child);
  }
  
  /**
   * Получение всех дочерних экземпляров
   */
  public function getChild() {
    return $this->_child;
  }
  
  /**
   * Есть ли дочерние экземпляры
   */
  public function isChildExists() {
    return ($this->getChildCount() > 0);
  }
  
  /**
   * Поиск потомка текущего экземпляра по ИД
   * Поддерживается только работа с не составным первичным ключом
   * @param mixed $id
   */
  public function getChildById($id) {
    $childCount = $this->getChildCount();
    
    $res = null;
    for($i = 0; $i < $childCount; $i++) {
      if ($this->_child[$i]->getPrimaryKey() == $id) {
        return $this->_child[$i];
      }
      $res = $this->_child[$i]->getChildById($id);
      
      if ($res !== null) {
        return $res;
      } 
    }
    
    return $res;
  }
  
  /**
   * Поиск предка текущего экземпляра по ИД
   * Поддерживается только работа с не составным первичным ключом
   * @param mixed $id
   */
  public function getParentById($id) {
    $parent = $this->getParent();
    if ($parent !== null) {
      if ($parent->getPrimaryKey() == $id) {
        return $parent;
      } else {
        return $parent->getParentById($id);
      }
    }
    return null;
  }
  
  /**
   * Является ли текущий объект предком для модели из параметров
   * @param DaActiveRecord $model
   */
  public function isAncestor(CActiveRecord $model) {
    return $model->getParentById($this->getPrimaryKey()) !== null;
  }
  
  /**
   * Является ли текущий объект потомком для модели из параметров
   * @param DaActiveRecord $model
   */
  public function isDescendant(CActiveRecord $model, $checkSelf = false) {
    if ($checkSelf && $this->owner->getPrimaryKey() == $model->getPrimaryKey()) return true;
    return $this->getParentById($model->getPrimaryKey()) !== null;
  }
  
  /**
   * Получение корневого предка
   */
  public function getRootParent() {
    $parent = $this->getParent();
    if ($parent === null) {
      return $this;
    }
    return $parent->getRootParent();
  }
  
  /**
   * Поиск экземпляра, включая проверку и текущего экземпляра
   * @param mixed $id
   */
  public function getById($id) {
    if ($this->owner->getPrimaryKey() == $id) {
      return $this;
    }
    return $this->getChildById($id);
  }
  
  /**
   * Получение данных дерева
   * @param mixed $id
   */
  public function getTreeData() {
    $categories = array();
    $this->order = 't.order ASC';
    $this->with = 'metatag';
    $tree = $this->getTree();
    
    $count = 0;
  
    foreach($tree->getChild() AS $category) {
        $categories[$count] = $category->attributes; 
        if(!empty($category->url))
            $categories[$count]['url'] = $category['url'];
                   
        if (!empty($category->metatag))
            $categories[$count]['metatag'] = $category->metatag->attributes;

        $categories[$count]['children'] = $this->getChildren($category->getChild());
  
        $count++;
    }
    return $categories;
  }  
  
    public function getTreeDataActive() {
    
        $categories = array();
        $this->order = 't.order ASC';
        $this->with = 'metatag';
        $this->addCondition[] = 't.active=1';
        $tree = $this->getTree();
        
        $count = 0;
      
        foreach($tree->getChild() AS $category) {
            $categories[$count] = $category->attributes; 
            if(!empty($category->url))
                $categories[$count]['url'] = $category['url'];
                       
            if (!empty($category->metatag))
                $categories[$count]['metatag'] = $category->metatag->attributes;
    
            $categories[$count]['children'] = $this->getChildren($category->getChild());
      
            $count++;
        }
        return $categories;
   }
   
   public function getTreeDataModule() {
    
        $categories = array();
        $this->order = 't.sort ASC';
        $this->addCondition[] = 't.active=1';
        $tree = $this->getTree();
        
        $count = 0;
      
        foreach($tree->getChild() AS $category) {
            $categories[$count] = $category->attributes; 
    
            $categories[$count]['children'] = $this->getChildren($category->getChild());
      
            $count++;
        }
        return $categories;
   }    
  
  /**
   * Получение данных дерева
   * @param mixed $id
   */
  public function getTreeDataWithId($ids = array()) {
    
    $categories = array();
    $this->order = 't.order ASC';
    $this->ids = $ids;
    $tree = $this->getTree();
    $count = 0;
  
    foreach($tree->getChild() AS $category) {
        
        $categories[$count] = $category->attributes;
        if(!empty($category->url))
            $categories[$count]['url'] = $category['url'];
            
        $categories[$count]['children'] = $this->getChildren($category->getChild()); 
        $count++;
    }
    return $categories;
  }
   
  /**
   * Получение дочерних элементов
   */
  public function getChildren($children) {
    $categories = array();
    $count = 0;
    foreach($children AS $category) {
        
        $categories[$count] = $category->attributes;
        if(!empty($category->url))
            $categories[$count]['url'] = $category['url'];
            
        $categories[$count]['parent'] = $category->parent->attributes;
        if(!empty($category->metatag))
            $categories[$count]['metatag'] = $category->metatag->attributes;
        $categories[$count]['children'] = $this->getChildren($category->getChild());
        $count++; 
    }

    return $categories;
  }
  
  /**
   * Получение массива с подкатегориями в отсортированном порядке
   */
  public function getTreeMain($categories) {
    $result = array();
    $count = 0;
    foreach($categories AS $category) {
        $category_temp = $category;
        unset($category_temp['children']);
        $result[] = $category_temp;
        if(!empty($category['children'])){
            $categories_temp = array();
            $categories_temp = $this->getChildrenMain($category['children']);
            $result = array_merge($result, $categories_temp);    
        }
    }
    foreach($result as $k => $v){
        $result[$k]['sortcolumn'] = $k; 
    }
    return $result;
  }
  
  /**
   * Получение дочерних элементов
   */
  public function getChildrenMain($children) {
    $categories = array();
    
    foreach($children AS $category) {
        $category_temp = $category;
        unset($category_temp['children']);
        $categories[] = $category_temp;
        if(!empty($category['children'])){
            $categories = array_merge($categories, $this->getChildrenMain($category['children']));            
        } 
    }
    
    return $categories;
  }
  
  
  /**
   * Получение массива с подкатегориями
   */
  public function getTreeList($categories, $str = '...') {
    $result = array();
    $count = 0;
    foreach($categories AS $category) {
        $result[$category['id']] = $category['name'];
        if(!empty($category['children'])){
            $categories_temp = array();
            $categories_temp = $this->getChildrenList($category['children'], $str);
            $result = $result + $categories_temp;    
            
        }
    }
    return $result;
  }
  
  /**
   * Получение дочерних элементов
   */
  public function getChildrenList($children, $str = '...') {
    $categories = array();
    
    foreach($children AS $category) {
        $categories[$category['id']] = $str.$category['name'];
        if(!empty($category['children'])){
            $categories = $categories + $this->getChildrenList($category['children'], $str.$str);            
        } 
    }
    
    return $categories;
  }
  
  
  
   

}
