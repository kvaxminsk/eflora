<?php
/* @var $this ManageController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Вопросы'=>array('index'),
	'Новый вопрос',
);

?>

<div class="conteiner" style="margin-bottom:10px;margin-top:10px;">
						<div class="center">
							<p style="font-size:18px;font-family:tahoma;margin-top:15px;">Новоя вопрос</p>
						</div>
						<div class="right">
							<a href="<?php echo CHtml::normalizeUrl(array('manage/index'))?>" class="big_button add_new">Список вопросовы</a>
						</div>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>