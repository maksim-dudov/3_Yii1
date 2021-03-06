<?php
/* @var $this RateController */
/* @var $model Rate */

$this->breadcrumbs=array(
	'Rates'=>array('index'),
	$model->title=>array('view','id'=>$model->uid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Rate', 'url'=>array('index')),
	array('label'=>'Create Rate', 'url'=>array('create')),
	array('label'=>'View Rate', 'url'=>array('view', 'id'=>$model->uid)),
	array('label'=>'Manage Rate', 'url'=>array('admin')),
);
?>

<h1>Update Rate <?php echo $model->uid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>