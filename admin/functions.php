<?
function price($number, $tag = '', $tagcur = 'span')
{
	$currency = SHOP_CURR_NAME;
	$decimals = SHOP_CURR_DEC;
 	$dsep = SHOP_CURR_DSEP;
 	$tsep = SHOP_CURR_TSEP;
 	$tsep = str_replace('_', '&nbsp;', $tsep);

	$price = pf($number, $decimals, $dsep, $tsep) . '&nbsp;';

	if ($tag) $price = '<'.$tag.'>' . $price . '</'.$tag.'>';

    if ($tagcur) $price .= '<'.$tagcur.'>';
	if ($currency) $price .= $currency;
    if ($tagcur) $price .= '</'.$tagcur.'>';

    return $price;
}


function image($path, $type = 'crop', $width = 100, $height = 100){
    
    $array = explode('/', $path);
    $imageName = end($array);
    
    $imagePath = str_replace($imageName, '', $path);
    
    $mas = explode('.', $imageName);
    $ext = strtolower(end($mas));
    $imageName = str_replace('.' . $ext, '', $imageName);

    $imageNameTumb = $imageName . '-' . $type . '-' . $width . 'x' . $height;
    
    if(is_file(HOME . $imagePath . $imageNameTumb . '.' . $ext))
        return $imagePath . $imageNameTumb . '.' . $ext;
    
    $image = Yii::app()->image->load(HOME.$path)->quality(100);
    
    if (($width !== null && $image->width > $width) || ($height !== null && $image->height > $height)){
        if($type == 'crop'){
            if($image->width > $image->height)
                $image->crop($image->height , $image->height);
            else
                $image->crop($image->width , $image->width);
            $image->resize($width , $height);
        }else{
            $image->resize($width , $height);
        }
    }
        
    #проверка на возможность записи в папку
    if (!$newFile = YFile::pathIsWritable($imageNameTumb, $ext, HOME.$imagePath))
        continue;

    $image->save($newFile);
    
    return $imagePath . $imageNameTumb . '.' . $ext;
}

?>