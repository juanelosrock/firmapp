<?php
/* @var $this DocumentosController */
/* @var $model Documentos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'documentos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tetxo'); ?>
		<?php echo $form->textArea($model,'tetxo',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'tetxo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'colegio'); ?>
		<?php echo $form->textField($model,'colegio'); ?>
		<?php echo $form->error($model,'colegio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grado'); ?>
		<?php echo $form->textField($model,'grado'); ?>
		<?php echo $form->error($model,'grado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->