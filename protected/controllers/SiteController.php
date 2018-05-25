<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Создаёт случайный отель
	 */
	public function actionCreateRandomHotel()
	{
		$hotel = new Hotel();
		$hotel->createRandomHotels();
		$this->redirect($this->createUrl('site/init_by_rel'), 301);
	}

	/**
	 * Заполняет базу полным набором отелей
	 */
	public function actionCreateAllHotels()
	{
		$time = microtime(true);
		$hotel = new Hotel();
		$hotel->createAllHotels();
		$addTime = microtime(true)-$time;

		$time = microtime(true);
		$currentState = self::getCurrentStateByRel();
		$getTime = microtime(true)-$time;

		$this->render(
			'init_by_rel',
			array(
				'currentState' => $currentState,
				'get_time' => $getTime,
				'add_time' => $addTime
			)
		);
	}

	/**
	 * Заполняет имеющиеся отели набором случайных сезонов
	 * @todo учитывать имеющиеся периоды, чтобы не создавать пересечения
	 */
	public function actionCreateAllSeasons()
	{
		$time = microtime(true);
		$season = new Season();
		$season->fillHotelsWithSeasons();
		$addTime = microtime(true)-$time;

		$time = microtime(true);
		$currentState = self::getCurrentStateByRel();
		$getTime = microtime(true)-$time;

		$this->render(
			'init_by_rel',
			array(
				'currentState' => $currentState,
				'get_time' => $getTime,
				'add_time' => $addTime
			)
		);
	}

	/**
	 * Заполняет имеющиеся сезоны набором случайных тарифов
	 */
	public function actionCreateAllRates()
	{
		$time = microtime(true);
		$season = new Rate();
		$season->fillSeasonsWithRates();
		$addTime = microtime(true)-$time;

		$time = microtime(true);
		$currentState = self::getCurrentStateByRel();
		$getTime = microtime(true)-$time;

		$this->render(
			'init_by_rel',
			array(
				'currentState' => $currentState,
				'get_time' => $getTime,
				'add_time' => $addTime
			)
		);
	}

	/**
	 * Заполняет имеющиеся отели набором случайных категорий
	 */
	public function actionCreateAllBlocks()
	{
		$time = microtime(true);
		$block = new Block();
		$block ->fillHotelsWithSeasons();
		$addTime = microtime(true)-$time;

		$time = microtime(true);
		$currentState = self::getCurrentStateByRel();
		$getTime = microtime(true)-$time;

		$this->render(
			'init_by_rel',
			array(
				'currentState' => $currentState,
				'get_time' => $getTime,
				'add_time' => $addTime
			)
		);
	}

	/**
	 * Удаляет все имеющиеся сезоны.
	 */
	public function actionDropAllSeasons()
	{
		$time = microtime(true);
		$season = new Season();
		$season->dropAllSeasons();
		$delTime = microtime(true)-$time;

		$time = microtime(true);
		$currentState = self::getCurrentStateByRel();
		$getTime = microtime(true)-$time;

		$this->render(
			'init_by_rel',
			array(
				'currentState' => $currentState,
				'get_time' => $getTime,
				'del_time' => $delTime
			)
		);
	}

	/**
	 * Удаляет все имеющиеся тарифы.
	 */
	public function actionDropAllBlocks()
	{
		$time = microtime(true);
		$model = new Block();
		$model->dropAllBlocks();
		$delTime = microtime(true)-$time;

		$time = microtime(true);
		$currentState = self::getCurrentStateByRel();
		$getTime = microtime(true)-$time;

		$this->render(
			'init_by_rel',
			array(
				'currentState' => $currentState,
				'get_time' => $getTime,
				'del_time' => $delTime
			)
		);
	}

	/**
	 * Удаляет все имеющиеся тарифы.
	 */
	public function actionDropAllRates()
	{
		$time = microtime(true);
		$rate = new Rate();
		$rate->dropAllRates();
		$delTime = microtime(true)-$time;

		$time = microtime(true);
		$currentState = self::getCurrentStateByRel();
		$getTime = microtime(true)-$time;

		$this->render(
			'init_by_rel',
			array(
				'currentState' => $currentState,
				'get_time' => $getTime,
				'del_time' => $delTime
			)
		);
	}

	/**
	 * Удаляет все имеющиеся отели.
	 */
	public function actionDropAllHotels()
	{
		$time = microtime(true);
		$hotel = new Hotel();
		$hotel->dropAllHotels();
		$delTime = microtime(true)-$time;

		$time = microtime(true);
		$currentState = self::getCurrentStateByRel();
		$getTime = microtime(true)-$time;

		$this->render(
			'init_by_rel',
			array(
				'currentState' => $currentState,
				'get_time' => $getTime,
				'del_time' => $delTime
			)
		);
	}

	/**
	 * Отображает страницу для установки начальных тестовых данных.
	 * Данные приходят через relations (ORM).
	 */
	public function actionInitByRel()
	{
		$currentStateTime = microtime(true);
		$currentState = self::getCurrentStateByRel();
		$this->render(
			'init_by_rel',
			array(
				'currentState' => $currentState,
				'get_time' => microtime(true)-$currentStateTime
			)
		);
	}

	/**
	 * Отображает страницу для установки начальных тестовых данных.
	 * Данные приходят через прямые запросы к базе.
	 */
	public function actionInitByQuery()
	{
		$currentStateTime = microtime(true);
		$currentState = self::getCurrentState();
		$this->render(
			'init_by_query',
			array(
				'currentState' => $currentState,
				'get_time' => microtime(true)-$currentStateTime
			)
		);
	}

	/**
	 * Возвращает текущее состояние через relations.
	 * @return array
	 */
	public static function getCurrentStateByRel()
	{
		return array('hotels'=>Hotel::getCurrentStateByRel());
	}

	/**
	 * Возвращает текущее состояние.
	 * Получает данные через прямые запросы к базе.
	 * @return array
	 */
	public static function getCurrentState()
	{
		$hotels = Hotel::getCurrentState();
		$seasons = Season::getCurrentState();
		$rates = Rate::getCurrentState();

		$currentState = [];
		$currentState['hotels'] = 	$hotels;
		$currentState['seasons'] = 	$seasons;
		$currentState['rates'] = 	$rates;

		$return = [];
		foreach($hotels as $hotel) {
			$return[$hotel['uid']] = $hotel;
			foreach($seasons as $season) {
				if ($season['hotel_uid'] == $hotel['uid']) {
					$return[$hotel['uid']]['seasons'][$season['uid']] = $season;
				}
			}

			if(isset($return[$hotel['uid']]['seasons'])) {
				foreach ($return[$hotel['uid']]['seasons'] as $key => $cur_season) {
					foreach ($rates as $rate) {
						if ($rate['season_uid'] == $cur_season['uid']) {
							$return[$hotel['uid']]['seasons'][$key]['rates'][$rate['uid']] = $rate;
						}
					}
				}
			}

		}
		$currentState['state'] = $return;

		return $currentState;
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}