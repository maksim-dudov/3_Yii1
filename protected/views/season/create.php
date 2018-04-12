<?php
/* @var $this SeasonController */
/* @var $model Season */

$this->breadcrumbs=array(
	'Seasons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Season', 'url'=>array('index')),
	array('label'=>'Manage Season', 'url'=>array('admin')),
);
?>

<h1>Create Season</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>