<?php

class Back extends CActiveRecord {
    
    public $url;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function afterDelete() {
        if(!empty($this->meta_id)){
            $model = MetaTag::model()->findByPk($this->meta_id);
            if(!empty($model))
                $model->delete();
        }
        parent::afterDelete();
    }
	
	public function saveFilterParam($firstKey, $a = array()) {
		if (isset($a)) {
			foreach ($a as $k => $v) {
				if (isset($a[$k]))  {
					$_SESSION[$firstKey][$k] = $v;
					$result[$k] = $v;
				} else if ($_SESSION[$firstKey][$k]) $result[$k] = $_SESSION[$firstKey][$k];
			}
			return $result;
		}
	}
}
