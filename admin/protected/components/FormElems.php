<?php

class FormElems extends CWidget{
	
	public $elems;
    
    public $buttons = false;
	
	public $form;
	
	public $model;
	
	public $chtml = false;
	
	public $buttonIco = 'ico none';
	
	public $buttonText;
	
	public $view = 'element';
    
	private $listsId = array();
	
	private $lineId = null;
	
	public $noError = null;
	
	const BUTTON_ICO_EYE           =   'ico public';
	const BUTTON_ICO_TRASH         =   'ico delete';
	const BUTTON_ICO_EDIT          =   'ico edit';
	const BUTTON_ICO_CANCEL        =   'ico cancel';
	const BUTTON_ICO_OK            =   'ico ok';
	
	const ELEM_TYPE_TEXT           =   'text';
	const ELEM_HIDDEN              =   'hidden';
	const ELEM_TYPE_EMAIL          =   'email';
	const ELEM_TYPE_DATALIST       =   'dataText';
	const ELEM_TYPE_URL            =   'url';
	const ELEM_TYPE_CHECKBOX       =   'checkbox';
	const ELEM_TYPE_DATE           =   'date';
	const ELEM_TYPE_TIME           =   'time';
	const ELEM_TYPE_RADIO          =   'radio';
	const ELEM_TYPE_TEXTAREA       =   'textArea';
	const ELEM_TYPE_SELECT         =   'select';
    const ELEM_TYPE_MULTISELECT    =   'multiSelect';
	const ELEM_TYPE_TEXTEDIT       =   'textEdit';
	const ELEM_TYPE_FILE           =   'fileInput';
    const ELEM_TYPE_IMAGE          =   'imageInput';
	const ELEM_TYPE_PASS           =   'password';
	
	function run($return=null){
		for($i=0;$i<count($this->elems);$i++){
			if(!isset($this->elems[$i][0])){
				$itemelem=$this->getElement($this->elems[$i]);
				if($itemelem!=null){
					switch ($itemelem['type']){
						case 'password':
							$element=$this->passwordField($itemelem);
						break;
						case 'text':
							$element=$this->textField($itemelem);
						break;
						case 'hidden':
							$element=$this->hiddenField($itemelem);
						break;
						case 'email':
							$element=$this->emailField($itemelem);
						break;
						case 'dataText':
							$element=$this->dataText($itemelem);
						break;
						case 'url':
							$element=$this->urlField($itemelem);
						break;
						case 'checkbox':
							$element=$this->checkboxField($itemelem);
						break;
						case 'date':
							$element=$this->dateField($itemelem);
						break;
						case 'time':
							$element=$this->timeField($itemelem);
						break;
						case 'radio':
							$element=$this->radioButtons($itemelem);
						break;
						case 'textArea':
							$element=$this->textArea($itemelem);
						break;
						case 'select':
							$element=$this->selectField($itemelem);
						break;
                        case 'multiSelect':
							$element=$this->multiSelectField($this->elems[$i]);
						break;
						case 'textEdit':
							$element=$this->textEdit($itemelem);
						break;
						case 'fileInput':
							$element=$this->fileInput($itemelem);
						break;
                        case 'imageInput':
							$element=$this->imageInput($itemelem);
						break;
  
						
						default:
							$element=$this->textField($itemelem);
						break;
					}
					$view='formElems/';
					if (isset($itemelem['view'])) {
						$view.=$itemelem['view'];
					} else {
						$view.=$this->view;
					}
					if(!$return){
						if($itemelem['type']=='hidden'){
							echo $this->render($view, array('elem'=>$element, 'lable'=>'', 'lineId'=>$itemelem['lineId'], 'req'=>$itemelem['req'], 'error'=>$itemelem['error']));
							//return '';
						}else{
							if($itemelem['type']=='zagolovok'){
								echo $this->render('formElems/zagolovok', array('text'=>$text));
							} else {
								echo $this->render($view, array('elem'=>$element, 'lable'=>$itemelem['lable'], 'lineId'=>$itemelem['lineId'], 'req'=>$itemelem['req'], 'error'=>$itemelem['error']));
							}
						}
						
					} else {
						if(!isset($html)){
							$html='';
						}
						if($itemelem['type']=='zagolovok'){
							$html.=$this->render('formElems/zagolovok', array('text'=>$text), true);
						} else {
							$html.=$this->render($view, array('elem'=>$element, 'lable'=>$itemelem['lable'], 'lineId'=>$itemelem['lineId'], 'req'=>$itemelem['req'], 'error'=>$itemelem['error']),1);
						}
					}
				} 
				}else {
					if(!$return){
						echo $this->elems[$i][0];
					} else {
						if(!isset($html)){
							$html='';
						}
						$html.=$this->elems[$i][0];
					}
			}
		}
		if(isset($this->buttonText)){
			$this->generateButton($this->buttonText, $this->buttonIco);
		}
        if($this->buttons){
            $this->buttonsBlock();
        }
        
		if($return){
			return $html;
		}
	}
	
    public function buttonsBlock(){
        $this->render('formElems/buttons');
    }
    
	public function addItem($item){
		$this->elems[]=$item;
	}
	
	//check & sets elements
	private function getElement($elem){
		$res=array();
		//element type
		if(isset($elem['type'])){
			$res['type']=$elem['type'];
			if($res['type']=='dataText'){
				if(!isset($elem['datalist'])){
					$res['type']='text';
				} else {
					$res['datalist']=$elem['datalist'];
					if(isset($elem['dataListId'])){
						$res['dataListId']=$elem['dataListId'];
					} else {
						$res['dataListId']=$this->generateId($res['type']);
						$elem['dataListId']=$res['dataListId'];
					}
				}
			}
			if($res['type']=='radio'){
				if(!isset($elem['datalist'])){
					return null;
				} else {
					$res['datalist']=$elem['datalist'];
				}
			}
			if($res['type']=='select'){
				if(!isset($elem['datalist'])){
					return null;
				} else {
					$res['datalist']=$elem['datalist'];
				}
			}
		} else {
			return null;
		}
		//element attribytefileInput
		if(isset($elem['attribute'])){
			$res['attribute']=$elem['attribute'];
			//datalist
		} else {
			return null;
		}
		//requrid *
		if(isset($elem['req'])){
			$res['req']=1;
		} else {
			$res['req']=0;
		}
		//placeholder
		if(isset($elem['placeholder'])){
			$res['placeholder']=$elem['placeholder'];
		} else {
			$res['placeholder']=null;
		}
		//htmlclass
		if(isset($elem['class'])){
			$res['class']=$elem['class'];
		} else {
			$res['class']=null;
		}
		//datalistid
		if(!isset($elem['dataListId'])){
			$res['dataListId']=null;
		}
		//element id
		if(isset($elem['id'])){
			$res['id']=$elem['id'];
		} else {
			$res['id']=null;
		}
		//lineId
		if(isset($elem['lineId'])){
			$res['lineId']=$elem['lineId'];
		} else {
			$res['lineId']=null;
		}
		//lable
		if(isset($elem['lable'])){
			$res['lable']=$elem['lable'];
		} else {
		   
			$lables=$this->model->attributeLabels();
			$res['lable']=$lables[$res['attribute']];
		}
		//error message
		if(!$this->noError){
			if(isset($elem['error'])){
				$res['error']=$elem['error'];
			} else {
				$res['error']=$this->form->error($this->model, $res['attribute']);
			}
		} else {
			$res['error']='';
		}
		//htmloptions
		if(isset($elem['htmlOptions'])){
			$res['htmlOptions']=$elem['htmlOptions'];
		} else {
			$res['htmlOptions']=array();
		}
		return $res;
	}
	
	
	//get htmlOptions array
	private function getHtmlOptions($elem){
		$res=array();
		if(count($elem['htmlOptions'])>0){
			$res=$elem['htmlOptions'];
		}
		if(!empty($elem['class'])){
			$res['class']=$elem['class'];
		}
		if(!empty($elem['placeholder'])){
			$res['placeholder']=$elem['placeholder'];
		}
		if(!empty($elem['req']) && $elem['type']!='textEdit'){
			$res['required']='';
		}
		if(!empty($elem['id'])){
			$res['id']=$elem['id'];
		}
		if (!empty($elem['dataListId'])){
			$res['list']=$elem['dataListId'];
		}
		return $res;
	}
	
	private function generateButton($text, $ico='ico none'){
		$this->render('formElems/button', array('text'=>$text, 'ico'=>$ico));
	}
	
	//generate dataListValues
	private function generateDataListValues($list, $listId){
		$html='<datalist id="'.$listId.'">'."\n";
		foreach ($list as $elem){
			$html.='<option value="'.$elem.'"></option>'."\n";
		}
		$html.='</datalist>'."\n";
		return $html;
	}
	
	//generate randomid
	private function generateId($text){
	if (count($this->listsId)){
			$stop=0;
			while ($stop==0){
				$ok=1;
				$value=$text.rand(0, 10000);
				for($i=0;$i<count($this->listsId);$i++){
					if($value==$this->listsId[$i]){
						$ok=0;
					}
				}
				if($ok==1){
					$stop=1;
				}
			}
			$this->listsId[]=$value;
		} else {
			$value=$text.rand(0, 10000);
			$this->listsId[]=$value;
		}
		return $value;
	}
	
	//-----------------------elems
	//password field
	private function passwordField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
        
		if(!$this->chtml){
			return $this->form->passwordField($this->model, $elem['attribute'], $htmloptions);
		} else {
			return CHtml::passwordField(get_class($this->model).'['.$elem['attribute'].']', '', $htmloptions);
		}
	}
	//hiddenfield
	private function hiddenField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
			if(!$this->chtml){
			return $this->form->hiddenField($this->model, $elem['attribute'], $htmloptions);
		} else {
			return CHtml::hiddenField(get_class($this->model).'['.$elem['attribute'].']', '', $htmloptions);
		}
	}//textField
	private function textField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
			if(!$this->chtml){
			return $this->form->textField($this->model, $elem['attribute'], $htmloptions);
		} else {
			return CHtml::textField(get_class($this->model).'['.$elem['attribute'].']', '', $htmloptions);
		}
	}
	
	//emailField
	private function emailField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		return $this->form->emailField($this->model, $elem['attribute'], $htmloptions);
	}
	
	//datalistText
	private function dataText($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		$datalist=$this->generateDataListValues($elem['datalist'], $elem['dataListId']);
		return 	$this->form->textField($this->model, $elem['attribute'], $htmloptions).$datalist;
	}
	
	//url Field
	private function urlField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		return $this->form->urlField($this->model, $elem['attribute'], $htmloptions);
	}
	
	//checkbox Field
	private function checkboxField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		return $this->form->checkBox($this->model, $elem['attribute'], $htmloptions);
	}
	
	//dateField
	private function dateField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		return $this->form->dateField($this->model, $elem['attribute'], $htmloptions);
	}
	
	//timeField
	private function timeField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		$htmloptions['type']='time';
		$htmloptions['name']=get_class($this->model).'['.$elem['attribute'].']';
		if(!isset($htmloptions['id'])){
			$htmloptions['id']=get_class($this->model).'_'.$elem['attribute'];
		}
		return CHtml::openTag('input', $htmloptions);
	}
	
	//radioButton
	private function radioButtons($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		return $this->form->radioButtonList($this->model, $elem['attribute'], $elem['datalist'], $htmloptions);
	}
	
	//textArea
	private function textArea($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		return $this->form->textArea($this->model, $elem['attribute'], $htmloptions);
	}
	
	//dropdown
	private function selectField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		if(!$this->chtml){
			return $this->form->dropDownList($this->model, $elem['attribute'], $elem['datalist'], $htmloptions);
		} else {
			return CHtml::dropDownList(get_class($this->model).'['.$elem['attribute'].']', '0', $elem['datalist']);
		}
	}
    //dropdown multi
	private function multiSelectField($elem){
		$htmloptions=$this->getHtmlOptions($elem);
        
		return $this->form->multiDropDownList($this->model, $elem['attribute'], $elem['datalist'], $elem['datalistselect'], $htmloptions);
		
	}
	
	//textedit
	private function textEdit($elem){
		$elem['htmlOptions'] = array_merge($elem['htmlOptions'],array('id'=>$elem['attribute'].'_id'));
	
		return $this->textArea($elem).'

		<script type="text/javascript">
    	CKEDITOR.replace( "'.$elem['attribute'].'_id'.'"
    		, {
			allowedContent: true,
            filebrowserBrowseUrl:" '.Yii::app()->baseUrl.'/vendor/kcfinder/browse.php?type=files",
         	filebrowserImageBrowseUrl:"'.Yii::app()->baseUrl.'/vendor/kcfinder/browse.php?type=images",
         	filebrowserFlashBrowseUrl:"'.Yii::app()->baseUrl.'/vendor/kcfinder/browse.php?type=flash",
         	filebrowserUploadUrl:"'.Yii::app()->baseUrl.'/vendor/kcfinder/upload.php?type=files",
         	filebrowserImageUploadUrl:"'.Yii::app()->baseUrl.'/vendor/kcfinder/upload.php?type=images",
         	filebrowserFlashUploadUrl:"'.Yii::app()->baseUrl.'/vendor/kcfinder/upload.php?type=flash",
		     }
    		);
		</script>';
	}
	
	private function fileInput($elem){
		$htmloptions=$this->getHtmlOptions($elem);
		return $this->form->fileField($this->model, $elem['attribute']);
	}
    
    private function imageInput($elem){
		$htmloptions = $this->getHtmlOptions($elem);
		return $this->form->imageField($this->model, $elem['attribute'], $htmloptions);
	}
}