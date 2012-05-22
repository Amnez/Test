<?php
/*
 * Calendar - PHP třída pro vytvoření HTML kalendáře
 * Copyright (c) 2011 Martin Nezval 
 * E-mail: martin@nezval.net
 * 
 * Ukázka sestavení kalendáře
 * 
$c2 = new Calendar('2011-11-09 00:00:00'); # Datum v DATETIME formátu.
$c2->typ = 'month'; # Nastavení typu kalendáře (month, agenda).
#$c2->day_name = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'); # Definování názvů dnů v kalendáři.
$c2->link_navi = 'http://domena/index.php?'; # Základní link pro navigaci mezi kalendáři. V třídě se doplní $_GET['month'] a $_GET['day'].

$c2->linkDay('2011-11-10 00:00:00', 'Link'); # Link pro konkrétní den.
$c2->noteDay('Datum ke kterému se vloží poznámka v DATETIME tvaru', 'FFAD46 - barva pozadí poznámky', 'Link poznámky', 'Text poznámky.'); # Vložení poznámky ke konkrétnímu datumu.
echo $c2->getCalendar(); # Vrací kalendář,
 */

class Calendar {
        
    var $year;
    var $month;
    var $day;
    var $link_navi;    
    var $day_name;
    var $link_day;    
    var $note_text;
    var $note_background;
    var $note_datetime;
    var $note_link;
    var $typ;

    // --- CONSTRUCTOR ---
    
    function calendar($datetime) {
        
        // Ošetření vtupujícího datumu        
        $year = substr($datetime, 0, 4);
        $month = substr($datetime, 5, 2);
        $day = substr($datetime, 8, 2);                
        if(@!checkDate($month, $day, $year)) {
            
            $this->year = date('Y');
            $this->month = date('m');        
            $this->day = date('d');
            
        } else {
            
            $this->year = $year;            
            $this->month = $month;        
            $this->day = $day;
            
        }
        
        // Default názvů dnů v týdnu        
        $this->day_name = array('Po', 'Út', 'St', 'Čt', 'Pá', 'So', 'Ne');
        
        // Ošetření vstupů note        
        $this->noteDay('', '', '', '');
        
        // Default typ kalendáře
        $this->typ = 'month';        
        
    }
    
    // --- VSTUPY ---
    
    // linkDay($datetime, $link)
    // Metoda, která k příslušným dnům odkazy.
    
    function linkDay($datetime, $link) {
        
        $date = substr($datetime, 0, 10); // Odřízne z DATETIME formátu čas
        $this->link_day[$date] = $link;
        
    }
    
    // noteDay($datetime, $background, $link, $text)
    // Metoda, která vloží do políčka dne poznámku
    
    function noteDay($datetime, $background, $link, $text) {
                
        $this->note_text[] = $text;
        $this->note_background[] = $background;
        $this->note_link[] = $link;
        $this->note_datetime[] = $datetime;
        
    }
    
    // --- VÝSTUPY ---
    
    // --- getCalendar() ---
    // Vrací HTML kalendář.
    
    function getCalendar() {
        
        switch ($this->typ) {
            case 'month': return $this->_calendarMonth();
            case 'agenda': return $this->_calendarAgenda();
        }
        
    }
    
    // --- _calendarMonth() ---
    // Vrací měsíční kalendář
    
    function _calendarMonth() {
        
        // Počet dnů v měsíci
        $count_days = Date("t", MkTime(0, 0, 0, $this->month, 1, $this->year));

        // Ke každému dni přiřadí jeho číslo v týdnu (1 = pondělí, ...)
        for($i = 1; $i <= $count_days; $i++) {
            
            $date[$i] = Date("w", MkTime(0, 0, 0, $this->month, $i, $this->year));
            if($date[$i] == 0) {
                
                $date[$i] = 7;
                
            }
            
        }
        // Číslo prvního dne v měsíci (1 = pondělí, ...)
        $first = $date[1];
        
        $out = '<table border="0" cellspacing="0" cellpadding="0">';
        
            // Navigace po měsících
        
            $out .= '<tr class="calendar_tr_navi">';                
                $out .= '<td colspan="7">';                            
                    $out .= '<span class="calendar_navi_l">';
                        if($this->month - 1 == 0) {

                            $out .= '<a href="' . $this->link_navi . 'month=12&amp;year=' . ($this->year - 1) . '">&lt;&lt;</a>';                        

                        } else {

                            $out .= '<a href="' . $this->link_navi . 'month=' . $this->_preZero($this->month - 1) . '&amp;year=' . $this->year . '">&lt;&lt;</a>';

                        }
                    $out .= '</span>';
                    $out .= '<span class="calendar_navi_c">';
                        $out .= ' ' . $this->month . " / " . $this->year . ' ';
                    $out .= '</span>';
                    $out .= '<span class="calendar_navi_r">';
                        if($this->month + 1 == 13) {

                            $out .= '<a href="' . $this->link_navi . 'month=01&amp;year=' . ($this->year + 1) . '">&gt;&gt;</a>';

                        } else {

                            $out .= '<a href="' . $this->link_navi . 'month=' . $this->_preZero($this->month + 1) . '&amp;year=' . $this->year . '">&gt;&gt;</a>';

                        }
                    $out .= '</span>';
                $out .= '</td>';
            $out .= '</tr>';
            
            // Řádek názvů dnů
            
            $out .= '<tr class="calendar_tr_day">';                
                foreach ($this->day_name as $key => $value) {
                    
                    $out .= '<td>';
                        $out .= $value;
                    $out .= '</td>';
                    
                }
            $out .= '</tr>';
            
            // Výpis dnů
            
            $day = 0;
            for($x = 0; $x <= 5; $x++) {
                
                $out .= '<tr>';                    
                    for($i = 1; $i <= 7; $i++) {
                        
                        $day = $x * 7 + $i - $first + 1; // Na základě obou cyklů postupně počítá den
                        $day_ymd = $this->year . '-' . $this->month . '-' . $this->_preZero($day); // Vypisovaný den ve formátu Y-m-d
                        
                        // Nastavení identifikátoru aktuální TD
                        if(date('Y-m-d') == $day_ymd) {

                            $out .= '<td class="calendar_td_aktual">';                        

                        } else {
                            
                            $out .= '<td>';                        
                            
                        }
                                                
                        // Obsah TD
                        
                        // Den
                        if($date[$day] == $i) {
                            
                            // Vložení odkazu pro den
                            if($this->link_day[$day_ymd] != '') {
                                
                                $out .= '<a href="' . $this->link_day[$day_ymd] . '">';
                                
                            }
                            
                            // Aktuální den vypíše tučně
                            if(date('Y-m-d') == $day_ymd) {
                                
                                $out .= '<b>' . $day . '</b>';
                                
                            } else {                            
                                
                                $out .= $day;                                
                                
                            }
                            
                            if($this->link_day[$day_ymd] != '') {
                                
                                $out .= '</a>';
                                
                            }
                                
                        } else {
                            
                            $out .= '&nbsp;';	
                                
                        }
                        
                        // Note                                                
                        asort($this->note_datetime);
                        foreach ($this->note_datetime as $key => $value) {

                            if(strpos($this->note_datetime[$key], $day_ymd) !== FALSE) {                            
                                
                                $out .= '<div class="calendar_note" style="background-color: #' . $this->note_background[$key] . ';">';
                                    if($this->note_link[$key] != '') {
                                        
                                        $out .= '<a href="' . $this->note_link[$key] . '">';
                                        
                                    }
                                    $out .= htmlspecialchars($this->note_text[$key]);
                                    if($this->note_link[$key] != '') {
                                        
                                        $out .= '</a>';
                                        
                                    }
                                $out .= '</div>';
                                
                            }
                            
                        }
                        
                        $out .= '</td>';                        
                        
                    }
                $out .= '</tr>';
                
                // Pokud neexistuje následující datum, ukončí cyklus
                if(!checkDate($this->month, $day + 1, $this->year)) {
                    
                    break;
                    
                }
                    
            }
        
        $out .= '</table>';        
        
        return $out;                
        
    }
    
    // --- _calendarAgenda() ---
    // Vrací seřazené poznámky v časové posloupnosti
    
    function _calendarAgenda() {
        
        $out = '<table border="0" cellspacing="0" cellpadding="0">';
                
        $day_ymd = date('Y-m-d');        
        asort($this->note_datetime);
        $previous_date = '';
        foreach ($this->note_datetime as $key => $value) {
            
            if($value != '') {
            
                if(strpos($this->note_datetime[$key], $day_ymd) !== FALSE) {
                    
                    $out .= '<tr class="calendar_tr_aktual">';
                    
                } else {
                
                    $out .= '<tr>';                
                
                }
                    
                    // Sloupec datumu                    
                
                    $out .= '<td class="calendar_td_day">';
                        if($previous_date != substr($value, 0, 10)) {
                            
                            $out .= '<span class="calendar_date">' . htmlspecialchars($this->_niceDate($value)) . '</span>';
                            
                        }
                    $out .= '</td>';
                    $previous_date = substr($value, 0, 10);
                    
                    // Sloupec NOTE
                    
                    $out .= '<td>';
                        $out .= '<div class="calendar_note" style="background-color: #' . $this->note_background[$key] . ';">';
                            $out .= '<span class="calendar_time">' . htmlspecialchars($this->_niceTime($value)) . '</span>';
                            if($this->note_link[$key] != '') {

                                $out .= '<a href="' . $this->note_link[$key] . '">';

                            }
                            $out .= htmlspecialchars($this->note_text[$key]);
                            if($this->note_link[$key] != '') {

                                $out .= '</a>';

                            }
                        $out .= '</div>';
                    $out .= '</td>';
                $out .= '</tr>';
                
            }
            
        }
        
        $out .= '</table>';
        
        return $out;
        
    }
    
    // --- OBSLUHA ---
    
    // --- _preZero($int) ---
    // Pokud je vstupem jednociferné číslo a nemá předřazenou nulu, tak ji doplní
    
    function _preZero($int) {
        
        if(
            ($int < 10)
            AND
            (substr($int, 1, 1) === FALSE)
        ) {

            return '0' . $int;

        } else {
            
            return $int;
            
        }
        
    }
    
    // --- _niceDate($datetime)
    // Vstupuje DATETIME a vrací "pěkné" datum.
    
    function _niceDate($datetime) {
        
         // Datum do samostatných polí
        $date_time = explode(' ', $datetime);
        $date = $date_time[0];
        $date = explode('-', $date);        

        // Odstranění nepotřebných nul u dnů a měsíců        
        if(
            ($date[2] < 10)        
            AND
            (substr($date[2], 1, 1) !== FALSE)
        ) {

            $date[2] = str_replace('0', '', $date[2]);

        }
        if(
            ($date[1] < 10)        
            AND
            (substr($date[1], 1, 1) !== FALSE)
        ) {

            $date[1] = str_replace('0', '', $date[1]);

        }

        // Složení data a času podle nastavení $type
        return $date[2] . '.' . $date[1] . '.' . $date[0];
        
    }
    
    // --- _niceTime($datetime)
    // Vstupuje DATETIME a vrací "pěkný" čas.
    
    function _niceTime($datetime) {
        
        // Datum a čas do samostatných polí
        $date_time = explode(' ', $datetime);        
        $time = $date_time[1];
        $time = explode(':', $time);

        // Odstranění nepotřebných nul u hodin
        if(
            ($time[0] < 10)
            AND
            ($time[0] != 0)
            AND
            (substr($time[0], 1, 1) !== FALSE)
        ) {

            $time[0] = str_replace('0', '', $time[0]);

        }        

        // Složení data a času podle nastavení $type
        return $time[0] . ':' . $time[1];
        
    }
            
}
?>
