<?php
/* @var $this ManageController */
/* @var $data Faq */
?>

<div class="faq" style="margin-top:10px" ; id="<?php echo CHtml::encode($data->question); ?>">
    <div
        style="background:  -webkit-linear-gradient(top, #4f4f4f, #020202); border-radius: 5px 5px 5px 5px;  color: #FFF; border: 1px solid #eee; padding: 10px;">
        <strong><?php echo CHtml::encode($data->getAttributeLabel('question')); ?>
            : </strong><?php echo CHtml::encode($data->question); ?></div>

    <div style="
	border: 1px solid #eee; border-top:0; border-radius: 0px 0px 5px 5px; padding: 10px;">
        <strong><?php echo CHtml::encode($data->getAttributeLabel('answer')); ?>:</strong>
        <?php echo CHtml::encode($data->answer); ?></div>
    <br/>
</div> 