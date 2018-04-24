<p>Существующие отели:</p>

<ul>
<?php
$echo = '';
foreach($currentState['hotels'] as $hotel)
{
    $echo .= '<li>'.$hotel['title'];
    if (isset($currentState['seasons'][$hotel['title']]))
    {
        $echo .= '<ul>';
        foreach($currentState['seasons'][$hotel['title']] as $season)
        {
            $echo .= '<li>';
            $echo .= $season['start'].' - '.$season['start'];
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
?>
