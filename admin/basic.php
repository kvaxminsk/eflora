<?php
date_default_timezone_set("Europe/Moscow");

# вывод переменных в удоюном виде, если есть третий параметр, то функция срабатывает только
# при передаче такого параметра в гет
function p($var, $die = 1, $get = ''){
    if($get != ''){
        if(!empty($_GET[$get])){
            print '<pre>' . print_r($var, 1) . '</p>';
        }
    }else{
        print '<pre>' . print_r($var, 1) . '</p>';
    }
	if ($die) die();
}

# форматрирование числа
function pf($price, $decimals = 0, $dsep = '.', $tsep = '&nbsp;')
{
	return str_replace(' ', $tsep, number_format($price, $decimals, $dsep, ' '));
}

# генератор хэша пароля
function password($password)
{
    $copyright = 'sitemania';
    $birthday = '22022013';

	return md5($copyright . $password . $birthday);
}

# проверка на email
function isEmail($email)
{
	return preg_match("/[^@]+@[^\.]+\.\w+/", $email);
}

# получение папки с изображением
function getImageFolder($imgfolder, $id){
    $path = '/images/'. $imgfolder;

    $subdir = substr('00000'.$id, -6);
    $maindir = substr($subdir, 0, 3);

    $dir = $path . DS . $maindir . DS . $subdir . DS;
    $dir = str_replace(DS, '/', $dir);
    return $dir;
}

# получение имени изображения
function getImageName($image, $type = '', $width = 100, $height = 100){
    $ext = end(explode('.', $image));
    $name = str_replace('.'.$ext, '', $image);

    $imageName = $name;
    if($type == ''){
        $imageName = $imageName . '.' .$ext;
    }else{
        $imageName = $imageName . '-' . $type . '-' . $width . 'x' . $height . '.' . $ext;
    }
    return $imageName;
}


function totranslit($str, $lower = true, $punkt = false)
{
	$converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		'_' => '-',
    );
    $str = strtr($str, $converter);
	$str = strtolower($str);
	$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
	$str = trim($str, "-");

	return $str;
}


function sendEmail($message, $subject, $from, $to){
    $host = str_replace('www.', '', getEnv('HTTP_HOST'));

    $headers =  "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html;charset=utf-8 \r\n";

    if (ereg("(.*)<(.*)>", $from, $regs)) {
        $from = '=?UTF-8?B?'.base64_encode($regs[1]).'?= <'.$regs[2].'>';
    } else {
        $from = $from;
    }

    $headers .= 'From: '.$from;

    #Кому отправлять сообщение
    if(!is_array($to)){
        $to = explode(',' , $to);
        $to = array_map('trim', $to);
    }

    $flag = false;
    foreach ($to as $i => $mail){
	    if(@mail($mail, $subject, $message, $headers)){
            $flag = true;
        }
    }
    return $flag;
}

function rusdate($string, $showYear = false) {


	if (is_numeric($string))
		$string = date('Y-m-d', $string);

	list($y, $m, $d) = explode('-', $string);


	if (!intval($d)) $d = 1;

	$tmp = mktime($m, $d, $y);



	$lang = Array('', 'января', 'февраля', 'марта', 'апреля',
		'мая', 'июня', 'июля', 'августа', 'сентября',
		'октября', 'ноября', 'декабря');


	//$tmp = $d . ' ' . $lang[(int)$m] . ', ' . $y;
	if (!$showYear)
		$tmp = $d . ' ' . $lang[(int)$m];
	else
		$tmp = $d . ' ' . $lang[(int)$m] . ' ' . $y;

	return $tmp;
}

function ruswords($number, $word = array('товаров', 'товар', 'товара')) {
    if ($number == 0 or ($number % 10) == 0) return $word[0];
    if ($number >= 5 && $number <= 20) return $word[0];
    if ($number % 10 >= 5 && $number % 10 <= 9) return $word[0];
    if (($number % 10) == 1 ) return $word[1];
    if (($number % 10) >= 2 && ($number % 10) <= 4) return $word[2];
}

function mainPageLink() {
	if (Yii::app()->request->requestUri == '/') return '#';
	else return '/';
}
?>