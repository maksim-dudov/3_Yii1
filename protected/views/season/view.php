<?php
/* @var $this SeasonController */
/* @var $model Season */

$this->breadcrumbs=array(
	'Seasons'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Season', 'url'=>array('index')),
	array('label'=>'Create Season', 'url'=>array('create')),
	array('label'=>'Update Season', 'url'=>array('update', 'id'=>$model->uid)),
	array('label'=>'Delete Season', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->uid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Season', 'url'=>array('admin')),
);
?>

<h1>View Season #<?php echo $model->uid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'uid',
		'hotel_uid',
		'title',
	),
)); ?>
