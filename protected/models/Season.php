<?php

/**
 * This is the model class for table "season".
 *
 * The followings are the available columns in table 'season':
 * @property string $uid
 * @property string $hotel_uid
 * @property string $title
 * @property string $start
 * @property string $end
 */
class Season extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'season';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hotel_uid', 'required'),
			array('hotel_uid', 'length', 'max'=>10),
			array('title', 'length', 'max'=>255),
			array('start, end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, hotel_uid, title, start, end', 'safe', 'on'=>'search'),
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
			'hotel_uid' => 'Hotel Uid',
			'title' => 'Title',
			'start' => 'Start',
			'end' => 'End',
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
		$criteria->compare('hotel_uid',$this->hotel_uid,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Season the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Метод удаляет все сезоны
	 */
	public function dropAllSeasons()
	{
		return false;
	}

	/**
	 * Метод заполняет отели сезонами со случайными датами начала и конца
	 */
	public function fillHotelsWithSeasons()
	{
		$hotels = Hotel::getCurrentState();
		$seasons = [];
		foreach($hotels as $hotel){
			$start_shift = 0;
			$end_shift = 1;
			$i = 0;
			while($end_shift <=100){
				$end_shift = $end_shift + rand(1, 30);

				$start = new DateTime('now');
				$end = new DateTime('now');

				$seasons[$hotel['title']][$i]['start'] = $start->modify('+'.$start_shift.' day')->format('d.m.Y');
				$seasons[$hotel['title']][$i]['end'] = $end->modify('+'.$end_shift.' day')->format('d.m.Y');

				Yii::app()->db->createCommand()
					->insert('season', array(
						'title' => 		'Сезон',
						'hotel_uid' => 	$hotel['uid'],
						'start' => 		$start->modify('+'.$start_shift.' day')->format('d.m.Y'),
						'end' => 		$end->modify('+'.$end_shift.' day')->format('d.m.Y')
					));

				$start_shift = $end_shift+1;
				$i++;
			}
		}
		return true;
	}

	/**
	 * Возвращает текущее состояние - набо существующих записей в БД
	 */
	static public function getCurrentState()
	{
		$hotels = Hotel::getCurrentState();
		$seasons = [];
		foreach($hotels as $hotel){
			$start_shift = 0;
			$end_shift = 1;
			$i = 0;
			while($end_shift <=100){
				$end_shift = $end_shift + rand(1, 30);

				$start = new DateTime('now');
				$end = new DateTime('now');

				$seasons[$hotel['title']][$i]['start'] = $start->modify('+'.$start_shift.' day')->format('d.m.Y');
				$seasons[$hotel['title']][$i]['end'] = $end->modify('+'.$end_shift.' day')->format('d.m.Y');

				$start_shift = $end_shift+1;
				$i++;
			}
		}
		return $seasons;
	}
}
