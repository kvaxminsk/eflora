<?php
/**
 * Базовый класс для всех контроллеров панели управления
 */


class BackController extends CController
{    
    
    public $layout = '//layouts/column2';
    
    public $modulerun;
    
    public $title = 'Админка';
    
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array( 'index', 'create', 'update', 'delete', 'public', 'all', 'deleteimg'),
				'users' => array('@'),
			),
            array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}
    
    public $breadcrumbs=array();
   

    public function init()
    {
        parent::init();
      
    }
    
    #выставляем активность объекта
    public function actionPublic(){

        $class = $this->modulerun;        
        $model = $class::model()->findByPk($_GET['id']);
		if($model->active == 1){
			$model->active = 0;
		}else{
			$model->active = 1;
		}	
		$model->save();
	}
    
    #удаляем объект
    public function actionDelete($id){
        
        $class = $this->modulerun;
        $model = $class::model()->findByPk($_GET['id']);
        $model->delete();
    }
    
    #действие с несколькими объектами
    function actionAll(){  
        $class = $this->modulerun;  
        
		if(isset($_POST['values']) && isset($_POST['action'])){
			$values = explode(';', $_POST['values']);
			switch($_POST['action']){
			    case 'save':
                    $inputs = json_decode($_POST['values']);
                    
                    foreach($inputs as $k => $v){
                        $model = $class::model()->findByPk($v->id);
                        foreach($v as $k1 => $v1){
                            if($k1 != 'id'){
                                $model->$k1 = $v1;
                            }
                        }
                        $model->save();
                    }
					break;  
                case 'on':
                    for($i = 0; $i < count($values); $i++){
						$model = $class::model()->findByPk($values[$i]);
						$model->active = 1;
						$model->save();
					}
					break;
				case 'off':
                    for($i = 0; $i < count($values); $i++){
						$model = $class::model()->findByPk($values[$i]);
						$model->active = 0;
						$model->save();
					}
					break;
				case 'del':					
                    for($i = 0; $i < count($values); $i++){
						$model = $class::model()->findByPk($values[$i]);
						if ($class == 'Variables') {
							if ($model->delete_allow) $model->delete();
						} else $model->delete();
					}
					break;
			}
		}
		return 1;
	}
    
    #функция для удаления изображений в остальных объектах
    public function actionDeleteimg()
	{
	    
	    $objectid = $_POST['objectid'];
        $class    = $_POST['model'];
        $attr     = $_POST['attr'];
        
 
	    $imagefolder = $class::model()->imagefolder;
        $model = $class::model()->findByPk($objectid);
        $name= $model->$attr;
        $model->$attr = '';
	    $model->save();
        
        $folder = getImageFolder($imagefolder, $objectid);
        if (@is_file(HOME . $folder . $name)) {
            $mas = explode('.', $name);
            $ext = end($mas);
            $fileName = str_replace('.'.$ext, '', $name);
            
            foreach (glob(HOME . $folder . $fileName . '-' . '*') as $file){
                @unlink($file);
            }
            
            @unlink(HOME . $folder . $name);
        }
        return 1;
	}    
}
