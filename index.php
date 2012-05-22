<?php
/*
 * Calendar - zkušební stránka třídy Calendar
 * Copyright (c) 2011 Martin Nezval
 * Link: http://Calendar.Nezval.NET
 * E-mail: martin@nezval.net
 * TTTTT 
 */

include 'calendar.php';
?>


    
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
