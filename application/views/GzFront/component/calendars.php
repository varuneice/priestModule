<?php

if ($_GET['view_month'] ?? 1 > 1) {
    echo $tpl['abcalendar'][$cid]->getMultiViewMonth();
} else {
    echo $tpl['abcalendar'][$cid]->getMonthView();
    echo $tpl['abcalendar'][$cid]->getLegend();
}
?>