<?php
/* @var $this HotelController */
/* @var $model Hotel */

$this->breadcrumbs=array(
	'Hotels'=>array('index'),
	$model->title=>array('view','id'=>$model->uid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Hotel', 'url'=>array('index')),
	array('label'=>'Create Hotel', 'url'=>array('create')),
	array('label'=>'View Hotel', 'url'=>array('view', 'id'=>$model->uid)),
	array('label'=>'Manage Hotel', 'url'=>array('admin')),
);
?>

<h1>Update Hotel <?php echo $model->uid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>