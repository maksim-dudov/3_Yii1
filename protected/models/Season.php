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
	 * @var array список возможных названий сезонов
	 */
	protected $nameList = array(
		'Низкий сезон',
		'Средний сезон',
		'Высокий сезон',
		'Пиковый сезон',
		'Лётный сезон',
		'Зимний сезон',
		'Осенний сезон',
		'Весенний сезон',
		'Горнолыжный сезон'
	);

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
			'hotel'=>array(self::BELONGS_TO, 'Hotel','hotel_uid'),
			'rate'=>array(self::HAS_MANY, 'Rate','season_uid')

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
		return Yii::app()->db->createCommand()
			->delete('season');
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

				$seasons[$hotel['title']][$i]['start'] = $start->modify('+'.$start_shift.' day')->modify('-1 day')->format('Y-m-d');
				$seasons[$hotel['title']][$i]['end'] = $end->modify('+'.$end_shift.' day')->format('Y-m-d');

				$this->saveSeasonBySave(
//				$this->saveSeasonByQuery(
					$this->generateRandomName(),
					$hotel['uid'],
					$start->modify('+'.$start_shift.' day')->format('Y-m-d'),
					$end->modify('+'.$end_shift.' day')->format('Y-m-d')
				);

				$start_shift = $end_shift+1;
				$i++;
			}
		}
		return true;
	}

	/**
	 * Сохраняет сезон по прямому запросу
	 * @param $title название сезона
	 * @param $hotel_uid идентификатор отеля
	 * @param $start начало сезона
	 * @param $end конец сезона
	 * @return результат создания новой строки в таблице
	 */
	protected function saveSeasonByQuery($title,$hotel_uid,$start,$end)
	{
		return Yii::app()->db->createCommand()
			->insert('season', array(
				'title' => 		$title,
				'hotel_uid' => 	$hotel_uid,
				'start' => 		$start,
				'end' => 		$end
			));
	}

	/**
	 * Сохраняет сезон через фреймворк
	 * @param $title название сезона
	 * @param $hotel_uid идентификатор отеля
	 * @param $start начало сезона
	 * @param $end конец сезона
	 * @return результат метода сохранения
	 */
	protected function saveSeasonBySave($title,$hotel_uid,$start,$end)
	{
		$newSeason = new Season();
		$newSeason->title = $title;
		$newSeason->hotel_uid = $hotel_uid;
		$newSeason->start = $start;
		$newSeason->end = $end;
		return $newSeason->save();
	}

	/**
	 * Возвращает текущее состояние - набор имеющихся в базе сезонов
	 * @return array список сезонов
	 */
	static public function getCurrentState()
	{
		return Yii::app()->db->createCommand()
			->select('uid,title,hotel_uid,start,end')
			->from('season')
			->queryAll();
	}

	static public function getCurrentStateByRel()
	{
		return self::model()->with('hotel')->findAll();
	}

	/**
	 * Возвращает случайное название для сезона.
	 * @return string название сезона
	 */
	protected function generateRandomName()
	{
		return $this->nameList[array_rand($this->nameList)];
	}
}
