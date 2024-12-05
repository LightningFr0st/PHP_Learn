<?php


$holidays = file_get_contents('holidays.txt');

if (isset($_POST['delivery'])) {
    $date_str = $_POST['delivery'];
    $date_arr = date_parse($date_str);
    $correct = InputCheck();
    if ($correct){

        $what_day = check_time();
        if ($what_day) {
            $date_arr['day'] += 2;
        } else {
            $date_arr['day']++;
        }

        skipWeekend();

        $answer = correctDate($date_arr);
        $answer = date_parse($answer);
        echo '<h2>Nearest delivery date: '.$answer['day'].' '.getMonth($answer['month']).' '.$answer['year'].'</h2>';
    }
}

function correctDate($date): string
{
    return date('Y-m-d', mktime(0, 0, 0, $date['month'], $date['day'], $date['year']));
}

function getWeekday($date): int
{
    $ans = intval(date('w', strtotime($date)));
    return $ans;
}

function getMonth($month): string
{
    return date("F", mktime(0, 0, 0, $month, 10));
}

function skipWeekend(): void
{
    global $date_arr;
    while (checkForHolidays() || checkForWeekend()) {
        $date_arr['day']++;
    }
}

function checkForWeekend(): bool
{
    global $date_arr;
    $delivery_day = getWeekday(correctDate($date_arr));
    if ($delivery_day == 6 || $delivery_day == 0) {
        return true;
    } else {
        return false;
    }
}

function checkForHolidays(): bool
{
    global $date_arr;
    global $holidays;
    $cur = date_parse(correctDate($date_arr));
    $temp = strval($cur['month']) . '-' . $cur['day'];
    $res = strpos($holidays, $temp);
    if ($res !== false) {
        return true;
    } else {
        return false;
    }
}

function InputCheck(): bool
{
    global $date_arr;
    if(!($date_arr['month'] && $date_arr['day'] && $date_arr['year'])){
        echo '<h2>Insufficient data</h2>';
        return false;
    }
    if($date_arr['month'] > 12){
        echo '<h2>Invalid month number</h2>';
        return false;
    }
    $ratio = [31,28,31,30,31,30,31,31,30,31,30,31];
    $is_leap = leap_year($date_arr['year']);
    if($is_leap){
        $ratio[1]++;
    }
    if ($date_arr['day'] > $ratio[$date_arr['month'] - 1]){
        echo '<h2>Invalid number of days in month</h2>';
        return false;
    }
    return true;
}

function leap_year(int $year): bool
{
    return ($year % 4 == 0) && (($year % 100 != 0) || ($year % 100 == 0 && $year % 400 == 0));
}

function check_time(): bool
{
    $CrucialTime = "12:00";
    return time() >= strtotime($CrucialTime);
}