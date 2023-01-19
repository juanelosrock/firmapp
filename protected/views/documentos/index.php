<?php
/* @var $this DocumentosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Documentoses',
);

?>
<?php if(!empty($relclientegrado)) { 
	foreach($relclientegrado as $info){
		$criteria = new CDbCriteria();
		$criteria->compare('colegio', $info->colegio);
		$criteria->compare('grado', $info->grado);
		$documento = Documentos::model()->find($criteria);
		if(!empty($documento)){
			$criteria = new CDbCriteria();
			$criteria->compare('cliente', Yii::app()->user->id);
			$criteria->compare('documento', $documento->id);
			$val_firma = Firmas::model()->find($criteria);			
?>
<div class="col-lg-4 col-md-4 col-sm-4 mb">
	<div class="weather-3 pn centered">
		<i class="fa fa-pencil"></i>
		<h1>FirmAPP</h1>
		<div class="info">
			<div class="row">
					<h5 class="centered"><?php echo $documento->nombre ?></h5>
				<div class="col-sm-6 col-xs-6 pull-left">
					<p class="goleft"><a <?php echo (empty($val_firma)) ? "" : "disabled"; ?> href="<?php echo Yii::app()->createUrl('/documentos/'.$documento->id) ?>" class="btn btn-primary">Revisar documento</a></p>
				</div>
				<div class="col-sm-6 col-xs-6 pull-right">
					<p class="goright"><?php echo (empty($val_firma)) ? "Tienes un documento por firmar" : CHtml::link('Revisa tu documento aqui', Yii::app()->createUrl('/documentos/getpdf', array('firma'=>$val_firma->id)), array('target'=>'_blank')); ?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } } } ?>

