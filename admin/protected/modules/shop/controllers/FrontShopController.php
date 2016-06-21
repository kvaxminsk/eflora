<?php

class FrontShopController extends FrontController
{
    
	public function __construct()
	{
		parent::__construct();
	}
    
    public function start($meta)
	{
	    $criteria = new CDbCriteria;
        $criteria->addCondition('t.active=1');
        $criteria->addCondition('type_id=18');
        $material = Material::model()->with('metatag')->find($criteria);
        if(!empty($material)){
            $urlroot = '/'. $material->metatag->uri. '/' . $material->metatag->alias;
            $urlroot = str_replace('//', '/', $urlroot);
            $this->urlroot = $urlroot; 
            $this->breadcrumbs[] = array(
                'meta_id'   => $material->metatag->id,
                'name'      => $material->name,
                'url'       => $urlroot, 
            ); 
        }
	}
     
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
		);
	}
    
	public function actionIndex($alias, $meta)
    {
        
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
    
        if (!empty($_GET['result']))
        {
        	if ($_GET['result'] == 'ok')
        	{ 
                Order::model()->clean(); 
        	}
        }
        elseif (!empty($_POST['data']['order']['product']))
        {

        	$ids = array_keys($_POST['data']['order']['product']);
        	$ids = array_map('trim', $ids);
			$ids = array_filter($ids);

			$products = Order::model()->loadProducts($ids);
            

			$op = array();
			if ($products)
			{
				$totalPrice = 0;
				foreach ($products as $k => $p)
				{
					$product_id = $id = $p['id'];
					$shop_price = $_POST['data']['order']['price'][$id];    

					$shop_count = $_POST['data']['order']['product'][$id];

					$total_price = $shop_price * $shop_count;

					$totalPrice += $total_price;

					$op[$k] = compact('product_id', 'shop_price', 'shop_count', 'total_price');
                    
					$products[$k] = array_merge($op[$k], $p);
				}
			}


            $order = new Order();
            $order->user_name           = $_POST['data']['order']['user_name'];
            $order->user_phone          = $_POST['data']['order']['user_phone'];
            $order->user_address        = (!empty($_POST['data']['order']['user_address'])) ? $_POST['data']['order']['user_address'] : '';
            $order->user_email          = isEmail($_POST['data']['order']['user_email']) ? $_POST['data']['order']['user_email'] : '';
            $order->user_comment        = $_POST['data']['order']['user_comment'];
            $order->user_city           = $_POST['data']['order']['user_city'];
            $order->user_come           = $_POST['data']['order']['user_come'];
			$order->user_time           = $_POST['data']['order']['user_time_s'] . ' - ' . $_POST['data']['order']['user_time_e'];
            $order->date                = date('Y-m-d H:i:s');
            $order->price               = $totalPrice;
            $order->user_id             = 0;
            $order->status_id           = 1;
            $order->active              = 0;

		

			if ($order->save())
			{
                $order_id = $order->id;
				foreach ($products as $pr)
				{

				    $op = new OrderProducts();
                    $op->order_id = $order_id;
                    $op->product_id = $pr['id'];
                    $op->price = $pr['shop_price'];
                    $op->count = $pr['shop_count'];
                    $op->active = 1;
                    $op->save();
				}
			} 

            $email_to = $this->variables['email'];
            $email = explode(',' , $email_to);
            $email_from = $email[0];
            if ($email)
            {
                $message = $this->createLetter($order, $products, $totalPrice,true);
                $subject = 'Заказ №' . $order->id . ' от ' . date('d.m.Y, H:i', strtotime($order->date));
                sendEmail($message, $subject, $email_from, $email_to);
			}
            if(isEmail($_POST['data']['order']['user_email']))
            {
                $message = $this->createLetter($order, $products, $totalPrice, false);
                $subject = 'Ваш заказ №' . $order->id . ' от ' . date('d.m.Y, H:i', strtotime($order->date));
                sendEmail($message, $subject, $email_from, array($_POST['data']['order']['user_email']));
            }
            
            $geturl = '?result=ok&order_id='.$order->id;

        	$this->redirect('/' . $geturl);
        }
        
        parent::meta($model, $meta);
        
        /*$this->render('index',array(
           'model' => $model,
           'meta'  => $meta
        ));  */
    }
    
    public function getViewPath() {
                $controllername = $this->getId();
                $newPath = "webroot.templates.shop";
                $newPath = YiiBase::getPathOfAlias($newPath);
                return $newPath;
    }
    
    public function createLetter($order, $products, $total, $adminflag = true){
        $host = str_replace('www.', '', getEnv('HTTP_HOST'));
        $host = 'http://'.$host;
        $text = '';
        $text .= '<p>Заказ № ' . $order->id . 'от ' . date('d.m.Y, H:i', strtotime($order->date)). '</p>';
        if ($adminflag){
            $text .= '<p>';
            $text .= '<b>Заказчик:</b> ' . $order->user_name. '<br>';
            $text .= '<b>Телефон:</b> ' . (($order->user_phone != '') ? $order->user_phone : 'Не указано'). '<br>';
            $text .= '<b>E-mail:</b> ' . (($order->user_email != '') ? $order->user_email : 'Не указано'). '<br>';
            $text .= '<b>Адрес доставки:</b> ' . (($order->user_address != '') ? $order->user_address : 'Не указано'). '<br>';
            $text .= '</p>';
            $text .= (($order->user_comment != '') ? 'Комментарий:<hr>' . $order->user_comment . '<hr>' : '');
        }
        
        $text .= 
            '<br>Заказанная продукция: <hr>
                <table border="1" cellpadding="5" cellspacing="1">
                    <tr>
                    	<td><b>#</b></td>
                    	<td><b>Фото</b></td>
                    	<td><b>Наименование</b></td>
                    	<td><b>Цена</b></td>
                    	<td><b>Количество</b></td>
                    	<td><b>Стоимость</b></td>
                    </tr>';
        if(!empty($products)){
            foreach($products as $i => $pr){
                $text .= '<tr>';
                $text .= '<td>' . ($i+1) . '</td>';
                $text .= '<td>' . (($pr['img']['name']) ? '<img src="' . $host . $pr['img']['big'] . '" alt="" width="100"/>' : '') . '</td>';
                $text .= '<td>' . $pr['name'] .  '</td>';
                $text .= '<td>' . $pr['shop_price'] .  '</td>';
                $text .= '<td>' . $pr['shop_count'] .  '</td>';
                $text .= '<td>' . $pr['total_price'] . '</td>';
                $text .= '</tr>';
            }
            $text .= '<tr>';
            $text .= '<td colspan="4"></td>';
            $text .= '<td>Итого:</td>';
            $text .= '<td>' . $total . '</td>';
            $text .= '</tr>';
        }
        $text .= '</table>';
        
        return $text;

    }

}
