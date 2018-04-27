<p>Существующие отели:</p>

<ul>
<?php
$echo = '';
foreach($currentState['hotels'] as $hotel)
{
    $echo .= '<li>'.$hotel['title'];
    if (isset($currentState['state'][$hotel['title']]))
    {
        $echo .= '<ul>';
        foreach($currentState['state'][$hotel['title']] as $season)
        {
            $echo .= '<li>';
            $echo .= $season['start'].' - '.$season['end'] . ' | ' . $season['uid'] . ' | '. $season['title'];
            $echo .= '</li>';
        }
        $echo .= '</ul>';
    }
    $echo .= '</li>';
}
echo $echo;
?>
</ul>

<?php
echo CHtml::link('Создать все отели',array('site/createAllHotels'));
echo '<br /><br />';
echo CHtml::link('Создать случайный отель',array('site/createRandomHotel'));
echo '<br /><br />';
echo CHtml::link('Удалить все отели',array('site/dropAllHotels'));
echo '<br /><br />';
echo '<br /><br />';
echo CHtml::link('Создать в отелях сезоны',array('site/createAllSeasons'));
echo '<br /><br />';
echo CHtml::link('Удалить все сезоны',array('site/dropAllSeasons'));
?>
