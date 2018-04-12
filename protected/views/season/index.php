<?php
/* @var $this SeasonController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Seasons',
);

$this->menu=array(
	array('label'=>'Create Season', 'url'=>array('create')),
	array('label'=>'Manage Season', 'url'=>array('admin')),
);
?>

<h1>Seasons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
