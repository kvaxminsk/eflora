<?php

//15.05.13 - ахуенный модуль превратился в говнокод!


class CCreateButton extends CWidget{
	
	function run(){
		
		$items=$this->getItems();
		$module="";
		$controller="";
		$param="";
		$buttontext='';
		if(isset(Yii::app()->controller->module->id)){
			$module=Yii::app()->controller->module->id;
		}
		$html="";

		if(isset(Yii::app()->controller->id)){
			$controller=Yii::app()->controller->id;
		}
		if($module=='gallery'){
			$controller=Yii::app()->controller->id;
			if($controller=='albumPhoto'){
				$module='photo';
			}
		}
		
		if($module=='catalog'){
			$controller=Yii::app()->controller->id;
			if($controller=='product'){
				$module='product';
			}
		}
		
		
		for($i=0;$i<count($items);$i++){
			unset($outUrl);
			if($items[$i]['create_button_show']==1  && $items[$i]['module']!=$module){
				/* if($items[$i]['module']=="createcategory" && $module=="catalog" && $controller=="category"){
					$outUrl=$url;
				}  */

				if(!isset($outUrl)){	
					$outUrl=$items[$i]['create_action'];
				}
				if($items[$i]['module']=="catalog"){
						if(isset($_GET['category'])){
								$outUrl=$outUrl.'/category/'.$_GET['category'];
							} 
				}
				$html.='<a class="button" href="'
				.Yii::app()->baseUrl.$outUrl.
				'"><span class="cb_ico"><img src="'.Yii::app()->request->baseUrl.'/images/'.$items[$i]['create_button_ico'].'"></span><span class="btn_title">'
				.$items[$i]['create_action_text'].
				// '['.$items[$i]['module'].']'.
				'</span></a>';
			} 
			if($items[$i]['module']==$module && $items[$i]['create_action']){
				if($items[$i]['create_action']){
					// var_dump($items[$i]);
					$outUrl=$items[$i]['create_action'];
					if($module=="product"){
						if(isset($_GET['category'])){
								$defaulta=$outUrl.'/category/'.$_GET['category'];
								$buttontext=$items[$i]['create_action_text'];
							} else {
								$defaulta=$outUrl;
								$buttontext=$items[$i]['create_action_text'];
							}
					} else {
						if($module=='photo'){
							if(isset($_GET['album'])){
								$defaulta=$outUrl.'/album/'.$_GET['album'];
								$buttontext=$items[$i]['create_action_text'];
							} else {
								$defaulta=$outUrl;
								$buttontext=$items[$i]['create_action_text'];
							}
						} else {
							$defaulta=$outUrl;
							$buttontext=$items[$i]['create_action_text'];
						}
					}
				}
			}
		}
		echo '<div class="left_button">
						<div class="select_custom">
							<div class="open">
								<span class="openhide"></span>
								<a class="button';
		if(!isset($defaulta)){
			echo ' grey';
		}
		echo '"';
		if(isset($defaulta)){						
			echo' href="'.Yii::app()->baseUrl.$defaulta.'"';
						
		}
								
								echo'><span class="ico add"></span><span class="btn_title">Добавить '. $buttontext .'</span></a>
							</div>
							<div class="close" style="">
								'.$html.'
							</div>
						</div>
					</div>';
	

	}
	private function getItems(){
		return Yii::app()->db->createCommand()->select('*')->from('{{modules}}')->order('create_button_sort ASC')->queryAll();
	}
	
}