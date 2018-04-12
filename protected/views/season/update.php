<?php
/* @var $this SeasonController */
/* @var $model Season */

$this->breadcrumbs=array(
	'Seasons'=>array('index'),
	$model->title=>array('view','id'=>$model->uid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Season', 'url'=>array('index')),
	array('label'=>'Create Season', 'url'=>array('create')),
	array('label'=>'View Season', 'url'=>array('view', 'id'=>$model->uid)),
	array('label'=>'Manage Season', 'url'=>array('admin')),
);
?>

<h1>Update Season <?php echo $model->uid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>