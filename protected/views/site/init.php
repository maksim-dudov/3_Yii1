<p>Существующие отели:</p>

<ul>
<?php
foreach($currentState['hotels'] as $hotel)
{
    echo '<li>'.$hotel['title'].'</li>';
}
?>
</ul>

<?php
echo CHtml::link('Создать случайный отель',array('site/createRandomHotel'));
?>
