<?php
/*
 * Calendar - zkušební stránka třídy Calendar
 * Copyright (c) 2011 Martin Nezval
 * Link: http://Calendar.Nezval.NET
 * E-mail: martin@nezval.net
 */

include 'calendar.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html lang="cs" xml:lang="cs" xmlns="http://www.w3.org/1999/xhtml"> 
<head>  
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
    <meta content="cs"  http-equiv="content-language" />  
    <meta name="author" content="Martin Nezval; e-mail:martin@nezval.net" />
    <title>PHP třída Calendar</title>
    <style type="text/css">
    <!--
    #obsah {
        display: block;
        width: 960px;
        padding: 0;
        margin: 0 auto;
    }
    table {
        margin: 20px 0;
        font-family: verdana;
        font-size: 0.8em;
    }
    
    .calendar table {        
        border: 1px solid #CBD9E0;
    }    
    .calendar td {       
        width: 30px;
        height: 30px;
        border: 1px solid #CBD9E0;
        background-color: #E9EFF8;
        text-align: center;
    }
    .calendar .calendar_tr_day td {
        background-color: #CBD9E0;        
        font-weight: bold;
    }
    .calendar .calendar_td_aktual {
        background-color: #CBD9E0;
    }
    .calendar span.calendar_navi_c {
        padding: 0 20px;        
    }
    
    .calendar2 table {        
        width: 100%;
        border: 1px solid #E1E2E4;
    }
    .calendar2 td {              
        width: 14%;
        height: 100px;
        padding: 2px;
        border: 1px solid #E1E2E4;        
        text-align: left;
        vertical-align: top;
    }
    .calendar2 .calendar_tr_navi td {
        height: 20px;
    }
    .calendar2 .calendar_tr_day td {
        height: 20px;
        background-color: #E1E2E4;        
        font-weight: bold;
    }
    .calendar2 .calendar_td_aktual {
        background-color: #F1F1F2;
    }
    .calendar2 span.calendar_navi_c {
        padding: 0 20px;        
    }
    .calendar2 .calendar_note {
        padding: 2px;
        font-size: 0.8em;
    }
        
    .calendar3 table {                
        border: 1px solid #E1E2E4;
    }
    .calendar3 td {              
        padding: 2px;        
        text-align: left;
        vertical-align: top;
    }
    .calendar3 .calendar_tr_aktual td {
        background-color: #F1F1F2;
    }
    .calendar3 .calendar_note {
        padding: 10px;                
    }
    .calendar3 .calendar_date {        
        font-weight: bold;        
    }
    .calendar3 .calendar_time {
        padding: 2px;
        margin: 0 20px 10px 0;
        background-color: #F1F1F2;
        font-weight: bold;
    }
    //-->
    </style>
</head>
<body>
    <div id="obsah">
        <h1>Calendar</h1>
        
        <p><b>Calendar</b> je PHP třída pro vizualzaci kalendářních dat.</p>
        
        <h2>Ukázky výstupů</h2>

<?php
        // --- C1 ---

        $c1 = new Calendar($_GET['year'] . '-' . $_GET['month'] . '-09 00:00:00');                
        $c1->typ = 'month';
        $c1->day_name = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
        $c1->link_navi = 'http://calendar.nezval.net/index.php?';
        
        $c1->linkDay('2011-11-10 00:00:00', 'http://calendar.nezval.net/');
        $c1->linkDay('2011-11-03 00:00:00', 'http://calendar.nezval.net/');
        
        echo '<h3>C1 - Calendar</h3>';
        echo '<div class="calendar">';
        echo $c1->getCalendar();
        echo '</div>';
        
        // --- C2 ---

        $c2 = new Calendar($_GET['year'] . '-' . $_GET['month'] . '-09 00:00:00');                
        $c2->typ = 'month';
        #$c2->day_name = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
        $c2->link_navi = 'http://calendar.nezval.net/index.php?';
        
        $c2->linkDay('2011-11-10 00:00:00', 'http://calendar.nezval.net/');
        $c2->linkDay('2011-11-03 00:00:00', 'http://calendar.nezval.net/');
        
        $c2->noteDay('2011-11-11 00:00:00', 'FFAD46', 'http://graph.nezval.net/', 'První poznámka - 111111.');
        $c2->noteDay('2011-11-03 00:00:00', '9FC6E7', '', 'Druhá poznámka - 111103.');
        $c2->noteDay('2011-11-08 00:14:01', '92E1C0', '', 'Třetí poznámka - 111108.');
        $c2->noteDay('2011-11-08 00:14:00', '9FC6E7', 'http://calendar.nezval.net/', 'Čtvrtá poznámka - 111108.');
        
        echo '<h3>C2 - Calendar</h3>';
        echo '<div class="calendar2">';
        echo $c2->getCalendar();
        echo '</div>';
        
        // --- C3 ---

        $c3 = new Calendar('');                
        $c3->typ = 'agenda';
        #$c3->day_name = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
        $c3->link_navi = 'http://calendar.nezval.net/index.php?';
        
        $c3->noteDay('2011-11-11 00:00:00', 'FFAD46', 'http://graph.nezval.net/', 'První poznámka - 111111.');        
        $c3->noteDay('2011-11-08 00:14:01', '92E1C0', '', 'Třetí poznámka - 111108.');
        $c3->noteDay('2011-11-08 00:14:00', '9FC6E7', 'http://calendar.nezval.net/', 'Čtvrtá poznámka - 111108.');
        $c3->noteDay('2011-11-15 02:12:00', '9FC6E7', '', 'Druhá poznámka - 111103.');
        $c3->noteDay('2011-11-15 00:12:01', '92E1C0', '', 'Pátá poznámka - 111115.');
        $c3->noteDay('2011-11-15 15:30:00', 'FFAD46', '', 'Šestá poznámka - 111115.');
        
        echo '<h3>C3 - Agenda</h3>';
        echo '<div class="calendar3">';
        echo $c3->getCalendar();
        echo '</div>';
?>
    
        <p style="text-align: right;"><a href="mailto:martin@nezval.net">martin@nezval.net</a></p>
        
    </div>       
</body>
</html>
