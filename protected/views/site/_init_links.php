<?php
echo CHtml::link('Создать все отели',array('site/createAllHotels'));
echo '<br /><br />';
echo CHtml::link('Создать случайный отель',array('site/createRandomHotel'));
echo '<br /><br />';
echo CHtml::link('Создать сезоны в отелях',array('site/createAllSeasons'));
echo '<br /><br />';
echo CHtml::link('Создать тарифы в сезонах',array('site/createAllRates'));
echo '<br /><br />';
echo CHtml::link('Создать категории в отелях',array('site/createAllBlocks'));
echo '<br /><br />';
echo '<br /><br />';
echo CHtml::link('Удалить все отели',array('site/dropAllHotels'));
echo '<br /><br />';
echo CHtml::link('Удалить все сезоны',array('site/dropAllSeasons'));
echo '<br /><br />';
echo CHtml::link('Удалить все тарифы',array('site/dropAllRates'));
?>