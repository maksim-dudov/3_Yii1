<?php

/**
 * This is the model class for table "hotel".
 *
 * The followings are the available columns in table 'hotel':
 * @property string $uid
 * @property string $title
 */
class Hotel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hotel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, title', 'safe', 'on'=>'search'),
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
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Hotel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Метод удаляет все отели в базе
	 */
	public function dropAllHotels()
	{
		return false;
	}

	/**
	 * Метод создаёт случайные отели.
	 */
	public function createRandomHotels()
	{
		$numlimit=10;
		$existingList=$this->getCurrentState();
		$doesUniquePossible=false;
		for($i=1; $i<=$numlimit*$numlimit; $i++){
			$newHotelTitle='Hotel_'.rand(1,$numlimit);
			$needle['title']=$newHotelTitle;
			if(in_array($needle,$existingList)===false) {
				$doesUniquePossible=true;
				break;
			}
			unset($needle);
		}
		return $doesUniquePossible===false
			? false
			: Yii::app()->db->createCommand()
				->insert('hotel', array(
					'title'=>$newHotelTitle,
				));
	}

	/**
	 * Возвращает текущее состояние - набо существующих записей в БД.
	 * Временно возвращает рандомные данные.
	 */
	static public function getCurrentState()
	{
		return Yii::app()->db->createCommand()
			->select('title')
			->from('hotel')
			->queryAll();
	}
}
