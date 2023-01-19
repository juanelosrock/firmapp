<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,		
	),
	'htmlOptions'=>array(
		'class'=>'form-login'
	),
)); ?>
	<h2 class="form-login-heading">Ingresar</h2>
	<div class="login-wrap">
			  
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'username'); ?>
		<br/>

		
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'password'); ?>
		<br/>


	
		<?php echo CHtml::submitButton('Login',array('class'=>'btn btn-theme btn-block')); ?>
		
	</div>		
<?php $this->endWidget(); ?>

