<div class="conteiner">
	
	<div class="form_pretext">
		Поля отмеченные <sup class="form_title_marker">*</sup> обязательны для
		заполнения
		<?php if(Yii::app()->user->hasFlash('success')){?>
					<div id="flash-success">
						<?php echo Yii::app()->user->getFlash('success'); ?>
					</div>
		<?php } ?>
		<?php if(Yii::app()->user->hasFlash('error')){?>
					<div id="flash-error">
						<?php echo Yii::app()->user->getFlash('error'); ?>
					</div>
		<?php } ?>
	</div>
	<?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'cmaterial-form',
			'enableAjaxValidation' => false,
            )); 
    ?>
	<div class="form">
		<?php 
		$this->widget('application.components.formElems', 
			array('form'=>$form, 
				'model'=>$model, 
				'elems'=>
                    array(
						array('type' => FormElems::ELEM_TYPE_EMAIL, 'attribute' => 'email', 'lable'=>'Email', 'req'=>1),
						array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'user', 'label'=>'Имя пользователя', 'req'=>1),
						array('type' => FormElems::ELEM_TYPE_PASS, 'attribute' => 'old_password', 'lable'=>'Старый пароль'),	
                        array('type' => FormElems::ELEM_TYPE_PASS, 'attribute' => 'new_password', 'lable'=>'Новый пароль'),
                        array('type' => FormElems::ELEM_TYPE_PASS, 'attribute' => 'confirm_password', 'lable'=>'Повторить новый пароль'),
								
                    ),
				'buttonText' => 'Сохранить', 
				'buttonIco' => FormElems::BUTTON_ICO_OK,		
	))?>
	</div>
	<?php $this->endWidget(); ?>

</div>