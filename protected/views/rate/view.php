<?php
/* @var $this RateController */
/* @var $model Rate */

$this->breadcrumbs=array(
	'Rates'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Rate', 'url'=>array('index')),
	array('label'=>'Create Rate', 'url'=>array('create')),
	array('label'=>'Update Rate', 'url'=>array('update', 'id'=>$model->uid)),
	array('label'=>'Delete Rate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->uid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Rate', 'url'=>array('admin')),
);
?>

<h1>View Rate #<?php echo $model->uid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'uid',
		'season_uid',
		'title',
	),
)); ?>
