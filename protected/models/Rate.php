<?php

/**
 * This is the model class for table "rate".
 *
 * The followings are the available columns in table 'rate':
 * @property string $uid
 * @property string $season_uid
 * @property string $title
 */
class Rate extends CActiveRecord
{
	/**
	 * @var array список возможных названий сезонов
	 */
	protected $nameList = array(
		'Стандартный тариф',
		'Невозвратный тариф',
		'Базовый тариф',
		'Корпоративный тариф',
		'Групповой тариф',
		'Rack rate',
		'BAR',
		'Best Available rate',
		'LAR',
		'Lowest Available rate',
		'Non-refundable rate',
		'NON-REF'
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('season_uid', 'required'),
			array('season_uid', 'length', 'max'=>10),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, season_uid, title', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'season_uid' => 'Season Uid',
			'title' => 'Title',
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

		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('season_uid',$this->season_uid,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Метод удаляет все тарифы
	 */
	public function dropAllRates()
	{
		return false;
	}

	/**
	 * Метод заполняет тарифами имеющиеся сезоны в имеющихся отелей
	 */
	public function fillSeasonsWithRates()
	{
		return false;
	}

	/**
	 * Возвращает текущее состояние - набо существующих записей в БД
	 */
	static public function getCurrentState()
	{
		$return = [];
		return $return;
	}

	/**
	 * Возвращает случайный набор тарифов, от 2 до 5.
	 * @return array набор ключей к названиям тарифов
	 */
	protected function getRandomRates()
	{
		return array_rand($this->nameList,rand(2,5));
	}
}
