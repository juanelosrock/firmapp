<?php

/**
 * This is the model class for table "firmas".
 *
 * The followings are the available columns in table 'firmas':
 * @property integer $id
 * @property integer $cliente
 * @property integer $documento
 * @property string $fecha
 * @property integer $validacion
 * @property string $foto1
 * @property string $foto2
 * @property string $firma
 *
 * The followings are the available model relations:
 * @property Clientes $cliente0
 * @property Documentos $documento0
 */
class Firmas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'firmas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('validacion, foto1, foto2, firma', 'required'),
			array('cliente, documento, validacion', 'numerical', 'integerOnly'=>true),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cliente, documento, fecha, validacion, foto1, foto2, firma', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cliente0' => array(self::BELONGS_TO, 'Clientes', 'cliente'),
			'documento0' => array(self::BELONGS_TO, 'Documentos', 'documento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cliente' => 'Cliente',
			'documento' => 'Documento',
			'fecha' => 'Fecha',
			'validacion' => 'Validacion',
			'foto1' => 'Foto1',
			'foto2' => 'Foto2',
			'firma' => 'Firma',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('cliente',$this->cliente);
		$criteria->compare('documento',$this->documento);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('validacion',$this->validacion);
		$criteria->compare('foto1',$this->foto1,true);
		$criteria->compare('foto2',$this->foto2,true);
		$criteria->compare('firma',$this->firma,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function reducirimagen($imagen){
		$salida = "";
		$foto1 = str_replace('data:image/jpeg;base64,','',$imagen);
		$percent = 0.5;		
		list($width, $height) = getimagesizefromstring(base64_decode($foto1));
		$new_width = $width * $percent;
		$new_height = $height * $percent;
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromstring(base64_decode($foto1));	
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		
		ob_start();
		imagejpeg($image_p);
		$data = ob_get_contents();
		ob_end_clean();
		
		$salida = base64_encode($data);
		$salida = 'data:image/jpeg;base64,'.$salida;
		
		return $salida;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Firmas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
