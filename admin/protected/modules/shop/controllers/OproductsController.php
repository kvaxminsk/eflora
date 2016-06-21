<?php

class OproductsController extends BackController
{
	public $title='Заказы';
    
    public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('update', 'delete', 'public', 'all', 'addproduct', 'totalorder'),
				'users' => array('@'),
			),
            array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}
    
    #выставляем активность объекта
    public function actionPublic($id){        
        $model = OrderProducts::model()->findByPk($_GET['id']);
		if($model->active == 1){
			$model->active = 0;
		}else{
			$model->active = 1;
		}	
		$model->save();

	}
    
    public function actionTotalorder(){
        $order = Order::model()->findByPk($_GET['orderid']);
        if(!empty($order->price)){
            die($order->price);    
        }else{
            die('0');
        }
    }
    
    public function actionAddproduct(){
        $criteria = new CDbCriteria;
        if($_POST['id'] != ''){
            $criteria->addCondition('t.id=' . $_POST['id']);
        }elseif($_POST['articul'] != ''){
            $criteria->addCondition('t.articul=' . $_POST['articul']);
        }else{
            die('0');
        }
        
        $product = Product::model()->find($criteria);
        if(!empty($product->id)){
            $criteria = new CDbCriteria;
            $criteria->addCondition('t.product_id=' . $product->id);
            $criteria->addCondition('t.order_id=' . $_POST['orderid']);
            $op_temp = OrderProducts::model()->find($criteria);
            if(!empty($op_temp->id)){
                die('-1');
            }
            $op = new OrderProducts;
            $op->product_id = $product->id;
            $op->price = $product->price;
            $op->active = 1;
            $op->count = 1;
            $op->order_id = $_POST['orderid'];
            if($op->save()){
                $order = Order::model()->findByPk($_POST['orderid']);
                $order->price = $order->price + $product->price;
                $order->save(); 
                die('1');
            }else{
                die('0');
            }
        }else{
            die('0');
        }
    
    }
	#удаляем объект
    public function actionDelete($id)
	{
        $model = OrderProducts::model()->findByPk($_GET['id']);
        
        $order = Order::model()->findByPk($model->order_id);
        $order->price = $order->price - $model->price * $model->count;
        $order->save(); 
	    $model->delete();
	}
    
    #действие с несколькими объектами
    function actionAll(){  
 
		if(isset($_POST['values']) && isset($_POST['action'])){
			$values = explode(';', $_POST['values']);
			switch($_POST['action']){
                case 'save':
                    $inputs = json_decode($_POST['values']);
                    $price = 0;
                    $order_id = 0;
                    foreach($inputs as $k => $v){
                        $model = OrderProducts::model()->findByPk($v->id);
                        foreach($v as $k1 => $v1){
                            if($k1 != 'id'){
                                $model->$k1 = $v1;
                            }
                        }
                        $price += $model->count * $model->price;
                        $order_id = $model->order_id;
                        $model->save();
                    }
                    $order = Order::model()->findByPk($order_id);
                    $order->price = $price;
                    $order->save(); 
                    
					break; 
                case 'on':
                    for($i = 0; $i < count($values); $i++){
						$model = OrderProducts::model()->findByPk($values[$i]);
						$model->active = 1;
						$model->save();
					}
					break;
				case 'off':
                    for($i = 0; $i < count($values); $i++){
						$model = OrderProducts::model()->findByPk($values[$i]);
						$model->active = 0;
						$model->save();
					}
					break;
				case 'del':
                    $price = 0;
                    for($i = 0; $i < count($values); $i++){
						$model = OrderProducts::model()->findByPk($values[$i]);
                        $price += $model->count * $model->price;
                        $order_id = $model->order_id;
						$model->delete();
					}
                    $order = Order::model()->findByPk($order_id);
                    $order->price = $order->price - $price;
					break;
			}
		}
        
	}

}
