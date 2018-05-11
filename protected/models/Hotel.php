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
	 * Максимальное число отелей
	 * @var int
	 */
	protected $hotelsLimit = 100;

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
			'season'=>array(self::HAS_MANY, 'Season','hotel_uid')
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
		return Yii::app()->db->createCommand()
			->delete('hotel');
	}

	/**
	 * Метод создает максимальный набор уникальных отелей
	 */
	public function createAllHotels()
	{
		do{
			$this->createRandomHotel();
		} while(count($this->getCurrentState())<$this->hotelsLimit);
	}

	/**
	 * Метод создаёт случайные отели.
	 * Имена задают по маске рандомно.
	 * Не создаёт, если отель с таким именем уже существует.
	 */
	public function createRandomHotel()
	{
		$newHotelTitle = $this->getUniqueHotelName();

		return $newHotelTitle===false
			? false
			: Yii::app()->db->createCommand()
				->insert('hotel', array(
					'title'=>$newHotelTitle,
				));

	}

	/**
	 * Метод создаёт случайный отель. Имя создаёт рандомно
	 * Не создаёт, если отель с таким именем уже существует.
	 * @return bool
	 */
	public function createRandomHotelBySave()
	{
		$newHotel = new Hotel();
		$newHotel->title = $this->getUniqueHotelName();

		return $newHotel->title===false
			? false
			: $newHotel->save();
	}

	protected function getUniqueHotelName(){
		$existingList=$this->getCurrentState();
		if(count($existingList)>=$this->hotelsLimit)
			return false;

		$doesUniquePossible=false;
		for($i=1; $i<=$this->hotelsLimit^2; $i++){
			$newHotelTitle='Hotel_'.rand(1,$this->hotelsLimit);
			$needle['title']=$newHotelTitle;
			if(in_array($needle,$existingList)===false) {
				$doesUniquePossible=true;
				break;
			}
			unset($needle);
		}
		return $doesUniquePossible===false
			? false
			: $newHotelTitle;
	}

	/**
	 * Возвращает текущее состояние - набор существующих записей в БД.
	 * @return array список отелей
	 */
	static public function getCurrentState()
	{
		return Yii::app()->db->createCommand()
			->select('uid,title')
			->from('hotel')
			->queryAll();
	}

	static public function getCurrentStateByRel()
	{
		return self::model()->with('season')->findAll();
	}
}
