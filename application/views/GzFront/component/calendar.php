<?php
if ($_GET['view_month'] ?? 1 > 1) {
    echo $tpl['abcalendar']->getMultiViewMonth();
} else {
    echo $tpl['abcalendar']->getMonthView();
    echo $tpl['abcalendar']->getLegend();
}
?>