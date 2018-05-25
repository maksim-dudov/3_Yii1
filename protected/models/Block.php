<?php

/**
 * This is the model class for table "block".
 *
 * The followings are the available columns in table 'block':
 * @property integer $uid
 * @property integer $hotel_uid
 * @property string $title
 */
class Block extends CActiveRecord
{

	/**
	 * @var array список возможных названий категорий
	 */
	protected $nameList = array(
		'Отдельный номер с удобствами',
		'Отдельный номер без удобств',
		'Апартаменты',
		'Апартаменты с кухней',
		'Стандартный с двуспальной кроватью',
		'Стандартный с двумя односпальными кроватями',
		'8-местный мужской дорм',
		'8-местный женский дорм',
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'block';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hotel_uid', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, hotel_uid, title', 'safe', 'on'=>'search'),
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
			'price'=>array(self::HAS_MANY, 'Price','block_uid')
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
		$criteria->compare('hotel_uid',$this->hotel_uid);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Block the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Сохраняет категорию по прямому запросу
	 * @param $title название категории
	 * @param $hotel_uid идентификатор отеля
	 * @return результат создания новой строки в таблице
	 */
	protected function saveBlockByQuery($title,$hotel_uid)
	{
		return Yii::app()->db->createCommand()
			->insert('season', array(
				'title' => 		$title,
				'hotel_uid' => 	$hotel_uid,
			));
	}

	/**
	 * Метод удаляет все категории
	 * @return void
	 */
	public function dropAllBlocks()
	{
		return Yii::app()->db->createCommand()
			->delete('block');
	}

	/**
	 * Возвращает случайное название для категории.
	 * @return string название категории
	 */
	protected function generateRandomName()
	{
		return $this->nameList[array_rand($this->nameList)];
	}

	/**
	 * Сохраняет категорию через фреймворк
	 * @param string $title название категории
	 * @param int $hotel_uid идентификатор отеля
	 * @return результат метода сохранения
	 */
	protected function saveBlockBySave($title,$hotel_uid)
	{
		$newItem = new Block();
		$newItem->title = $title;
		$newItem->hotel_uid = $hotel_uid;
		return $newItem->save();
	}

	/**
	 * Метод заполняет отели категориями со случайными названиями
	 */
	public function fillHotelsWithSeasons()
	{
		$hotels = Hotel::getCurrentState();
		foreach($hotels as $hotel){
			$i = 0;
			while($i <= rand(1, count($this->nameList))){

				$this->saveBlockBySave(
					$this->generateRandomName(),
					$hotel['uid']
				);
				$i++;
			}
		}
		return true;
	}
}
