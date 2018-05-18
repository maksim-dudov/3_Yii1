<p>Существующие отели:</p>

<?php
$echo = '<ul>';
foreach($currentState['hotels'] as $hotel)
{
    $echo .= '<li>'.$hotel->title;

    if (count($hotel->season)) {
        $echo .= '<ul>';
        foreach ($hotel->season as $season) {
            $echo .= '<li>';
            $echo .= $season->start.' - '.$season->end . ' | ' . $season->title;
            $echo .= '</li>';
            if (count($season->rate)) {
                $echo .= '<ul>';
                foreach ($season->rate as $rate) {
                    $echo .= '<li>';
                    $echo .= $rate->title;
                    $echo .= '</li>';
                }
                $echo .= '</ul>';
            }
        }
        $echo .= '</ul>';
    }
    $echo .= '</li>';
}
$echo .= '</ul>';

$echo .= '<br /><br />';
$echo .= 'get - ' . (isset($get_time)?sprintf("%01.2f",$get_time):'na') . '<br />';
$echo .= 'add - ' . (isset($add_time)?sprintf("%01.2f",$add_time):'na') . '<br />';
$echo .= 'del - ' . (isset($del_time)?sprintf("%01.2f",$del_time):'na') . '<br />';
$echo .= '<br /><br />';

echo $echo;
$this->renderPartial('_init_links');
?>