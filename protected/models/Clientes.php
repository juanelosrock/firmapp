<?php

/**
 * This is the model class for table "clientes".
 *
 * The followings are the available columns in table 'clientes':
 * @property integer $id
 * @property string $nombre
 * @property string $cedula
 * @property string $celular
 * @property string $correo
 * @property string $clave
 * @property string $fecha
 * @property integer $colegio
 *
 * The followings are the available model relations:
 * @property Colegios $colegio0
 * @property Firmas[] $firmases
 * @property Relclientegrado[] $relclientegrados
 */
class Clientes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('correo, clave', 'required'),
			array('colegio', 'numerical', 'integerOnly'=>true),
			array('nombre, cedula, correo, clave', 'length', 'max'=>50),
			array('celular', 'length', 'max'=>20),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, cedula, celular, correo, clave, fecha, colegio', 'safe', 'on'=>'search'),
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
			'colegio0' => array(self::BELONGS_TO, 'Colegios', 'colegio'),
			'firmases' => array(self::HAS_MANY, 'Firmas', 'cliente'),
			'relclientegrados' => array(self::HAS_MANY, 'Relclientegrado', 'cliente'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'cedula' => 'Cedula',
			'celular' => 'Celular',
			'correo' => 'Correo',
			'clave' => 'Clave',
			'fecha' => 'Fecha',
			'colegio' => 'Colegio',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('clave',$this->clave,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('colegio',$this->colegio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function validatePassword($password)
	{
		return $this->hashPassword($password)===$this->clave;
	}
	
	public function hashPassword($password)
	{
		return $password;
	} 

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
