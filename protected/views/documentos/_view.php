<?php
/* @var $this DocumentosController */
/* @var $data Documentos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tetxo')); ?>:</b>
	<?php echo CHtml::encode($data->tetxo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('colegio')); ?>:</b>
	<?php echo CHtml::encode($data->colegio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grado')); ?>:</b>
	<?php echo CHtml::encode($data->grado); ?>
	<br />


</div>