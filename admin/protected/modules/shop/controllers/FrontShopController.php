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
        if (!empty($material)) {
            $urlroot = '/' . $material->metatag->uri . '/' . $material->metatag->alias;
            $urlroot = str_replace('//', '/', $urlroot);
            $this->urlroot = $urlroot;
            $this->breadcrumbs[] = array(
                'meta_id' => $material->metatag->id,
                'name' => $material->name,
                'url' => $urlroot,
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
                'actions' => array('index'),
                'users' => array('*'),
            ),
        );
    }
    public function actionAjaxCreateOrder() {
        $kurs = $this->kurs;
        $kurs_rus_byn = $this->kurs_rus_byn;
        $kurs_rus_dollar = $this->kurs_rus_dollar;
        $totalAmout =0;
        $date = json_decode($_POST['data']);

//        var_dump($date);die();
//        var_dump($date->products);
        foreach($date->products as $product) {
//            var_dump($product->name);
            $productOrder = Order::model()->loadProduct($product[0]);
//            Product::model()->getPrimaryKey($product[0]);
//            var_dump($productOrder);
//            var_dump(Product::model()->getPrimaryKey($product[0]));
//            die();
//            $totalAmout += round($productOrder->price*$product[1]);
            if($productOrder->discount != 0 ) {
                $totalAmout += round($productOrder->price*$product[1]- $productOrder->price*$product[1]*$productOrder->discount/100);
            }
            else {
                $totalAmout += round($productOrder->price*$product[1]);
            }

//
        }

        if($date->currency == 'us') {
            $this->currency ='us';
            $currencyType = 'US';
            $moneyTotal = round($totalAmout,2);
            $moneyTotalString = 'US ' . number_format($moneyTotal/10000, 0, '', ' ');
            $moneyTotalRus = $totalAmout / $kurs_rus_dollar;
            $rus_money = 'RU '  . number_format($moneyTotalRus - fmod($moneyTotalRus,1), 0, '', ' ') . ' руб '  . round(fmod($moneyTotalRus,1),2) * 100 .  ' коп ';
        }
        elseif ($date->currency == 'br') {
            $totalAmout = round($kurs * $totalAmout,2);
            $currencyType = 'BYN';
            $this->currency ='br';
            $moneyTotal = round($totalAmout/10000,2);

            $moneyTotalString = 'BYN ' . number_format($moneyTotal - fmod($moneyTotal,1), 0, '', ' ') . ' руб '  . round(fmod($moneyTotal,1),2) * 100 .  ' коп ';

            $moneyTotalRus = $totalAmout / $kurs_rus_byn;
            $moneyTotalRus = round($moneyTotalRus,2);
            $rus_money = 'RU '  . number_format($moneyTotalRus - fmod($moneyTotalRus,1), 0, '', ' ') . ' руб '  . round(fmod($moneyTotalRus,1),2) * 100 .  ' коп ';
        }

        $order = new Order();
        $order->name_to = $date->name_to;
        $order->phone_to = $date->phone_to;
        $order->country_to = $date->country_to;
        $order->email_to = $date->email_to;

        $order->name_from = $date->name_from;
        $order->phone_from = $date->phone_from;
        $order->country_from = $date->country_from;
        $order->city_from = $date->city_from;
        $order->address_from = $date->address_from;
        $order->text_postcard = $date->text_postcard;
        $order->user_comment = $date->comment_postcard;

        $order->date = Date('Y-m-d');
        $order->date_delivery = $date->date_delivery;
        $order->total_amount = $totalAmout;

        $order->method_pay = $date->method_pay;
        $order->currency = $date->currency;
//        var_dump($date->text_postcard);die();
        if ($order->save()) {
            $order_id = $order->id;
            foreach ($date->products as $pr) {
                $productOrder = Order::model()->loadProduct($product[0]);

                $op = new OrderProducts();
                $op->order_id = $order_id;
                $op->product_id = $productOrder->id;
                $op->price = $productOrder->price*$product[1]- $productOrder->price*$product[1]*$productOrder->discount/100;
                $op->count = $product[1];
                $op->active = 1;
                $op->save();
            }
        }


//        $money = 'BYN ' . number_format($totalAmout/10000, 0, '', ' ') . ' руб '  . (fmod($totalAmout, 10000) /100) .  ' коп ';
        switch($order->method_pay) {
            case 'Наличные деньги курьеру':
                $methodPay = 'Наличные деньги курьеру';
                echo '<p> Спасибо что выбрали нашу службу.<br>
                        Ваш заказ #<span id="order_id">'  . $order->id . '</span> получен </p>';
                break;
            case 'VISA/MasterCard/Белкарт':
                $methodPay = 'VISA/MasterCard/Белкарт';
                echo '<p>  Спасибо что выбрали нашу службу.<br>
                        Ваш заказ #<span id="order_id">'  . $order->id . '</span> получен</br>';
                echo '</br><span id="order_id">Заказ не оплачен.</span></br>';
                echo 'Для оплаты нажмите:</br>';
                echo '<form action="https://pay111.paysec.by/pay/order.cfm" method="post" style="clear: left">
                        <input type="hidden" name="Merchant_ID" value="464011">

                        <!--input type="hidden" name="TestMode" value="0"-->

                        <input type="hidden" name="Delay" value="0">
                        <input type="hidden" name="Language" value="RU">
                        <input type="hidden" name="OrderCurrency" value="'. $currencyType . '">
                        <input type="hidden" name="AssistIDPayment" value="0">

                        <!--input type="hidden" name="CardPayment" value="1">
                        <input type="hidden" name="YMPayment" value="1">
                        <input type="hidden" name="WMPayment" value="1">
                        <input type="hidden" name="QIWIPayment" value="1"-->


                        <input type="hidden" name="ordernumber" value="'  . $order->id . '">
                        <input type="hidden" name="orderamount" value="' . $moneyTotal . '">
                        <input type="hidden" name="ordercomment" value="№'  . $order->id . '">
                        <input type="submit" name="submit" value="Оплатить" style = "display: block;
                        margin: 0 auto;margin-bottom: 10px;">
                    </form>';
                echo " <img src=\"/images/eflora/pay-assist.png\" style =\"display: block;
    margin: 0 auto;\">";
                echo "<div style =\"display:flex; justify-content:center\" ><img src=\"/images/eflora/3dsecure.jpg\" height=\"33px\">
                        <img src=\"/images/eflora/assist_logo.gif\" height=\"25px\" style=\"margin-left: 5px;margin-bottom: 10px;\"></div>";
                echo " </p>";
                break;
            case 'Оплата наличными в одном из наших салонов':
                $methodPay = 'Оплата наличными в одном из наших салонов';
                echo '<p> Спасибо что выбрали нашу службу.<br>
                        Ваш заказ #<span id="order_id">'  . $order->id . '</span> получен </p>';
                break;
            case 'WebMoney':
                $methodPay = 'WebMoney';
                echo '<p>  Спасибо что выбрали нашу службу.<br>
                        Ваш заказ #<span id="order_id">'  . $order->id . '</span> получен</br>';
                echo '</br><span id="order_id">Заказ не оплачен.</span></br>';
                echo 'Для оплаты нажмите:</br>';
                echo '<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp" style="clear: left;">
                        <input type="hidden" name="LMI_PAYMENT_NO" value="10044">
                        <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="' . $moneyTotal . '">
                        <input type="hidden" name="LMI_PAYMENT_DESC" value="Oplata zakaza '  . $order->id . ' sluzhbyi dostavki eFlora.by">
                        <input type="hidden" name="LMI_PAYEE_PURSE" value="B308187414389">
                        <input type="submit" name="submit" value="Оплатить" style ="display: block; margin: 0 auto;margin-bottom: 10px;">
                    </form>';
                echo " <img src=\"/images/eflora/webmoney.png\" style = \"display: block; margin : 0 auto;  \">";
                echo " </p>";
                break;
            case 'ЕРИП Расчёт':
                $methodPay = 'ЕРИП Расчёт';
                echo '<p> Спасибо что выбрали нашу службу.<br>
                        Ваш заказ #<span id="order_id">'  . $order->id . '</span> получен ';
                echo '<br><span id="order_id">Заказ не оплачен.</span><br>
                Для оплаты нужно перевести сумму заказа (' .  $moneyTotalString . ') через систему ЕРИП ("Расчёт")
                 (инфокиоск, интернет-банк, через оператора в банке или на почте).<br/>
                 <b>Интернет-магазины/сервисы (РБ) -> E -> Eflora.by - цветы</b><br/>
                 ВНИМАНИЕ! Необходимо указать в примечании платежа номер заказа и выслать,
                 нам скрин-шот квитанции об оплате на электронную почту <b></b>info.eflora@gmail.com</b></p>';
                break;
            case 'Оплата по безналичному расчету на наш расчетный счет для юридических лиц':
                $methodPay = 'Оплата по безналичному расчету на наш расчетный счет для юридических лиц';
                echo '<p> Спасибо что выбрали нашу службу.<br>
                        Ваш заказ #<span id="order_id">'  . $order->id . '</span> получен </p>';
                break;
            case 'Яндекс Деньги':
                $totalAmout = $totalAmout * 310;

                $methodPay = 'Яндекс Деньги';
                echo '<p> Спасибо что выбрали нашу службу.<br>
                        Ваш заказ #<span id="order_id">'  . $order->id . '</span> получен ';
                echo '<br/><b><span id="order_id">Заказ не оплачен.</span></b><br/>
 Оплата производится в российских рублях по курсу НБ РБ на день оплаты.</br>
 Сумма к оплате: (' . $rus_money . ')<br/>
  Для оплаты нужно перевести сумму заказа в системе Яндекс.
  Деньги на кошелёк <b>410013357501696</b>.<br/>
  <b>ВНИМАНИЕ!</b> Необходимо указать в примечании платежа номер заказа и выслать, нам скрин-шот квитанции об оплате на электронную почту <b>info.eflora@gmail.com</b></p>';
                break;
        }

        $email_to = $order->email_to;
        $email = explode(',', $email_to);
        $email_admin = $this->variables['email'] ;

        if ($email) {
            $message = $this->createLetter($order, $date->products, $totalAmout, true);
            $subject = 'Заказ №' . $order->id . '  от ' . date('d.m.Y, H:i', strtotime($order->date));
            sendEmail($message, $subject, $email_to,$email_admin );
        }
        if (isEmail($date->email_to)) {
            $message = $this->createLetter($order, $date->products, $totalAmout, false);
            $subject = 'Ваш заказ №' . $order->id . '  от ' . date('d.m.Y, H:i', strtotime($order->date));
            sendEmail($message, $subject, $email_admin, $email_to);
        }
//
//        die();
    }
    public function actionIndex($alias, $meta)
    {

        $this->layout = 'webroot.templates.layout-basket';
//        die('fdsf');
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        if (!empty($_GET['result'])) {
            if ($_GET['result'] == 'ok') {
                Order::model()->clean();
            }
        } elseif (!empty($_POST['data']['order']['product'])) {

//            $ids = array_keys($_POST['data']['order']['product']);
//            $ids = array_map('trim', $ids);
//            $ids = array_filter($ids);
//

//            $products = Order::model()->loadProducts($ids);
//
//
//            $op = array();
//            if ($products) {
//                $totalPrice = 0;
//                foreach ($products as $k => $p) {
//                    $product_id = $id = $p['id'];
//                    $shop_price = $_POST['data']['order']['price'][$id];
//
//                    $shop_count = $_POST['data']['order']['product'][$id];
//
//                    $total_price = $shop_price * $shop_count;
//
//                    $totalPrice += $total_price;
//
//                    $op[$k] = compact('product_id', 'shop_price', 'shop_count', 'total_price');
//
//                    $products[$k] = array_merge($op[$k], $p);
//                }
//            }
//
//
////            $order = new Order();
////            $order->name_to = $_POST['name_to'];
////            $order->phone_to = $_POST['phone_to'];
////            $order->country_to = $_POST['country_to'];
////            $order->email_to = $_POST['email_to'];
////
////            $order->name_from = $_POST['name_from'];
////            $order->phone_from = $_POST['phone_from'];
////            $order->country_from = $_POST['country_from'];
////            $order->city_from = $_POST['city_from]'];
////            $order->address_from = $_POST['address_from'];
////            $order->text_from = $_POST['text_postcard'];
//
////            $order->user_name = $_POST['data']['order']['user_name'];
////            $order->user_phone = $_POST['data']['order']['user_phone'];
////            $order->user_address = (!empty($_POST['data']['order']['user_address'])) ? $_POST['data']['order']['user_address'] : '';
////            $order->user_email = isEmail($_POST['data']['order']['user_email']) ? $_POST['data']['order']['user_email'] : '';
////            $order->user_comment = $_POST['data']['order']['user_comment'];
////            $order->user_city = $_POST['data']['order']['user_city'];
////            $order->user_come = $_POST['data']['order']['user_come'];
////            $order->user_time = $_POST['data']['order']['user_time_s'] . ' - ' . $_POST['data']['order']['user_time_e'];
////            $order->date = date('Y-m-d H:i:s');
////            $order->price = $totalPrice;
////            $order->user_id = 0;
////            $order->status_id = 1;
////            $order->active = 0;
//
//
//            if ($order->save()) {
//                $order_id = $order->id;
//                foreach ($products as $pr) {
//
//                    $op = new OrderProducts();
//                    $op->order_id = $order_id;
//                    $op->product_id = $pr['id'];
//                    $op->price = $pr['shop_price'];
//                    $op->count = $pr['shop_count'];
//                    $op->active = 1;
//                    $op->save();
//                }
//            }
//
//            $email_to = $this->variables['email'];
//            $email = explode(',', $email_to);
//            $email_from = $email[0];
//            if ($email) {
//                $message = $this->createLetter($order, $products, $totalPrice, true);
//                $subject = 'Заказ №' . $order->id . ' от ' . date('d.m.Y, H:i', strtotime($order->date));
//                sendEmail($message, $subject, $email_from, $email_to);
//            }
//            if (isEmail($_POST['data']['order']['user_email'])) {
//                $message = $this->createLetter($order, $products, $totalPrice, false);
//                $subject = 'Ваш заказ №' . $order->id . ' от ' . date('d.m.Y, H:i', strtotime($order->date));
//                sendEmail($message, $subject, $email_from, array($_POST['data']['order']['user_email']));
//            }
//
//            $geturl = '?result=ok&order_id=' . $order->id;
//
//            $this->redirect('/' . $geturl);
        }

        parent::meta($model, $meta);

        $this->render('index', array(
            'model' => $model,
            'meta' => $meta
        ));
    }

    public function getViewPath()
    {
        $controllername = $this->getId();
        $newPath = "webroot.templates.shop";
        $newPath = YiiBase::getPathOfAlias($newPath);
        return $newPath;
    }

    public function createLetter($order, $products, $total, $adminflag = true)
    {

        $host = str_replace('www.', '', getEnv('HTTP_HOST'));
        $host = 'http://' . $host;
        $text = '';
        $text .= '<p>Заказ № ' . $order->id . 'от ' . date('d.m.Y, H:i', strtotime($order->date)) . '</p>';
        if ($adminflag) {
            $text .= '<h2>Отправитель:</h2> ' . $order->name_to . '<br>';
            $text .= '<p>';
            $text .= '<b>Телефон:</b> ' . (($order->phone_to != '') ? $order->phone_to : 'Не указано') . '<br>';
            $text .= '<b>Страна:</b> ' . (($order->country_to != '') ? $order->country_to : 'Не указано') . '<br>';
            $text .= '<b>E-mail:</b> ' . (($order->email_to != '') ? $order->email_to : 'Не указано') . '<br>';
            $text .= '<b>Адрес доставки:</b> ' . (($order->user_address != '') ? $order->user_address : 'Не указано') . '<br>';
            $text .= '</p>' . '<br>';
            $text .= '<h2>Получатель:</h2> ' . $order->name_from;
            $text .= '<p>';
            $text .= '<b>Телефон:</b> ' . (($order->phone_from != '') ? $order->phone_from : 'Не указано') . '<br>';
            $text .= '<b>Страна:</b> ' . (($order->country_to != '') ? $order->country_to : 'Не указано') . '<br>';
            $text .= '<b>Город:</b> ' . (($order->city_from != '') ? $order->city_from : 'Не указано') . '<br>';
            $text .= '<b>Адрес:</b> ' . (($order->address_from != '') ? $order->address_from : 'Не указано') . '<br>';
            $text .= '<b>E-mail:</b> ' . (($order->email_to != '') ? $order->email_to : 'Не указано') . '<br>';
            $text .= '<b>Адрес доставки:</b> ' . (($order->user_address != '') ? $order->user_address : 'Не указано') . '<br>';
            $text .= '<b>Способ оплаты:</b> ' . (($order->method_pay != '') ? $order->method_pay : 'Не указано') . '<br>';
            $text .= '<b>Дата доставки:</b> ' . (($order->date_delivery != '') ? $order->date_delivery : 'Не указано') . '<br>';

            $text .= '</p>';
            $text .= (($order->text_postcard != '') ? 'Текст открытки:<hr>' . $order->text_postcard . '<hr>' : '');
            $text .= (($order->user_comment != '') ? 'Комментарий:<hr>' . $order->user_comment . '<hr>' : '');
        }

        $text .=
            '<br>Заказанная продукция: <hr>
                <table border="1" cellpadding="5" cellspacing="1">
                    <tr>
                    	<td><b>#</b></td>
                    	<td><b>Наименование</b></td>
                    	<td><b>Цена</b></td>
                    	<td><b>Количество</b></td>
                    	<td><b>Стоимость</b></td>
                    </tr>';
        if (!empty($products)) {
            foreach ($products as $i => $pr) {

                $productOrder = Order::model()->loadProduct($pr[0]);
                $text .= '<tr>';

                $text .= '<td>' . ($i + 1) . '</td>';
                $text .= '<td>' . $productOrder->name . '</td>';
                $text .= '<td>' . round($productOrder->price- $productOrder->price*$productOrder->discount/100) . '</td>';
                $text .= '<td>' . $pr[1] . '</td>';
                $text .= '<td>' . round($productOrder->price*$pr[1]- $productOrder->price*$pr[1]*$productOrder->discount/100 ). '</td>';
                $text .= '</tr>';
            }
            $text .= '<tr>';
            $text .= '<td colspan="3"></td>';
            $text .= '<td>Итого:</td>';
            $text .= '<td>' . $total . '</td>';
            $text .= '</tr>';
        }
        $text .= '</table>';

        return $text;

    }

}
