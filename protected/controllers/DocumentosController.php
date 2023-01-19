<?php

class DocumentosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','admin','delete','firmar','getpdf'),
				'users'=>array('@'),
			),			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	 public function actionGetpdf(){
		
		$idfirma = $_GET['firma'];				
		$firma = Firmas::model()->findByPk($idfirma);			
		$documento = Documentos::model()->findByPk($firma->documento);
		$firma->foto1 = str_replace(' ','+',$firma->foto1);
		$firma->foto2 = str_replace(' ','+',$firma->foto2);
		$firma->firma = str_replace(' ','+',$firma->firma);		
		
		$mPDF1 = Yii::app()->ePdf->mpdf('win-1252','Letter','','arial',20,15,15,25,10,10);		                     
        $mPDF1->WriteHTML($this->renderPartial('getpdf',array('documento'=>$documento, 'firma'=>$firma),true)); 	

        $mPDF1->Output();
		
	 }
	
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionFirmar()
	{		
		$firma = new Firmas;
		$firma->cliente = $_POST['cliente'];
		$firma->documento = $_POST['documento'];
		$firma->foto1 = $_POST['image1'];		
		$firma->foto2 = $_POST['image2'];
		$firma->firma = $_POST['image3'];
		$firma->foto1 = str_replace(' ','+',$firma->foto1);
		$firma->foto2 = str_replace(' ','+',$firma->foto2);
		$firma->firma = str_replace(' ','+',$firma->firma);
		$firma->foto2 = Firmas::reducirimagen($firma->foto2);
		$firma->foto1 = Firmas::reducirimagen($firma->foto1);		
		$firma->validacion = 1;
		$firma->fecha = date('Y-m-d H:i:s');
		if($firma->save()){
			echo "OK";
		}else{
			print_r($firma->errors);
			$log = new Log;
			$log->error = CJSON::encode($firma->errors);
			$log->save();
		}
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->layout = '//layouts/column1';
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Documentos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Documentos']))
		{
			$model->attributes=$_POST['Documentos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Documentos']))
		{
			$model->attributes=$_POST['Documentos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->layout = '//layouts/column1';
		$cliente = Clientes::model()->findByPk(Yii::app()->user->id);	
		$criteria = new CDbCriteria();
		$criteria->compare('cliente',$cliente->id);
		$criteria->compare('colegio',$cliente->colegio);
		$relclientegrado = Relclientegrado::model()->findAll($criteria);
		$this->render('index',array(
			'cliente'=>$cliente,
			'relclientegrado'=>$relclientegrado
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Documentos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Documentos']))
			$model->attributes=$_GET['Documentos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Documentos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Documentos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Documentos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='documentos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
