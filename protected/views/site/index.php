<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$this->menu=array(
	array('label'=>'Create Hotel', 'url'=>array('create')),
	array('label'=>'Manage Hotel', 'url'=>array('admin')),
);
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Это тестовый проект для сравнительного анализа быстродействия работы с БД инструментов настоящего фреймворка.</p>