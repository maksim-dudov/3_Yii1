<?php

/**
 * This is the model class for table "price".
 *
 * The followings are the available columns in table 'price':
 * @property integer $uid
 * @property integer $block_uid
 * @property integer $rate_uid
 * @property string $date
 * @property integer $value
 */
class Price extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid', 'required'),
			array('uid, block_uid, rate_uid, value', 'numerical', 'integerOnly'=>true),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, block_uid, rate_uid, date, value', 'safe', 'on'=>'search'),
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
			'rate'=>array(self::BELONGS_TO, 'Rate','rate_uid'),
			'block'=>array(self::BELONGS_TO, 'Block','block_uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'block_uid' => 'Block Uid',
			'rate_uid' => 'Rate Uid',
			'date' => 'Date',
			'value' => 'Value',
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('block_uid',$this->block_uid);
		$criteria->compare('rate_uid',$this->rate_uid);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Price the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Сохраняет цены по прямому запросу к БД
	 * @param $block_uid идентификатор категории
	 * @param $rate_uid идентификатор тарифа
	 * @param $date дата для цены
	 * @param $value цена (целое значение)
	 * @return результат создания новой строки в таблице
	 */
	protected function savePriceByQuery($block_uid, $rate_uid, $date, $value)
	{
		return Yii::app()->db->createCommand()
			->insert('season', array(
				'block_uid' => 	$block_uid,
				'rate_uid' => 	$rate_uid,
				'date' => 		$date,
				'value' => 		$value,
			));
	}


	/**
	 * Сохраняет цены через фреймворк
	 * @param $block_uid идентификатор категории
	 * @param $rate_uid идентификатор тарифа
	 * @param $date дата для цены
	 * @param $value цена (целое значение)
	 * @return результат сохранения
	 */
	protected function savePriceBySave($block_uid, $rate_uid, $date, $value)
	{
		$newPrice = new Price();
		$newPrice->block_uid = $block_uid;
		$newPrice->rate_uid = $rate_uid;
		$newPrice->date = $date;
		$newPrice->value = $value;
		return $newPrice->save();
	}

	/**
	 * Метод удаляет все цены
	 * @return void
	 */
	public function dropAllPrices()
	{
		return Yii::app()->db->createCommand()
			->delete('block');
	}
}
