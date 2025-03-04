<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your trip</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>

<body class="tripBody">

<?php

include 'utils.php';

function getMonthDays($year, $month)
{
    if ($month == 1 || $month == 3 || $month == 5 || $month == 7
        || $month == 8 || $month == 10 || $month == 12) {
        return 31;
    }
    if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
        return 30;
    }
    if ($year % 4 == 0) {
        if ($year % 100 == 0) {
            if ($year % 400 == 0) {
                return 29;
            } else {
                return 28;
            }
        } else {
            return 29;
        }
    } else {
        return 28;
    }
}

function addDayToDate($date, $day)
{
    $date['day'] += $day;
    while (getMonthDays($date['year'], $date['month']) < $date['day']) {
        $date['day'] -= getMonthDays($date['year'], $date['month']);
        $date['month']++;
        if ($date['month'] > 12) {
            $date['month'] -= 12;
            $date['year']++;
        }
    }
    return$date;
}

function convertDateToString($date) {
    $val = strval($date['year'])."-";
    if ($date['month'] < 10)
        $val = $val . "0";
    $val = $val . strval($date['month'])."-";
    if ($date['day'] < 10)
        $val = $val . "0";
    $val = $val . strval($date['day']);
    return $val;
}

/**
 * Variable representing number of stops.
 */
$stops = $_POST['stops'];

$adults = $_POST['adultsNum'];
$dept_date = date_parse($_POST['deptDate']);
$fastest_way = $_POST['fastestWay'];
$staySearch = $_POST['staySearch'];

/**
 * Array containing stops.
 */
$stopArr = array(0 => $_POST['startPlace'], 1 => $_POST['stopPlace1'],
    2 => $_POST['stopPlace2'], 3 => $_POST['stopPlace3'], 4 => $_POST['stopPlace4'],
    5 => $_POST['stopPlace5']);

$staysArr = array(0 => 0, 1 => $_POST['stop1Nights'], 2 => $_POST['stop2Nights'],
    3 => $_POST['stop3Nights'], 4 => $_POST['stop4Nights'], 5 => $_POST['stop5Nights']);


for ($i = 1; $i <= $stops; $i++) {
    $checkin[$i] = $dept_date;
    $dept_date = addDayToDate($dept_date, $staysArr[$i]);
    $checkout[$i] = $dept_date;
}

/**
 * Creating command for searching best trip.
 */
$command = "python3 ./bestRoute/main.py \"" . $stopArr[0] . "\" " . $stops;
for ($i = 1; $i <= $stops; $i++) {
    $command = $command . " \"" . $stopArr[$i] . "\"";
}


exec($command, $output, $ret);

/**
 * Printing information about error, if occurred.
 */
if ($ret == 1) {
    echo "<div class='errorBox'>";
    echo "<p class='errorMessage'>";
    echo "Sorry <br> We didn't find one of selected places or it's impossible to travel by car";
    echo "</p>";
    echo "</div>";
    exit;
}

echo "<header>";
echo "Our suggested trip is: <br>";
echo "</header>";

/**
 * Printing founded route with photo and small information about place.
 */
for ($i = 3; $i <= $stops + 4; $i++) {
    $command = "python3 ./AttractionSearcher/main.py \"" . $output[$i] . "\" 4 2";
    $weatherCommand = getWeatherCommand($output[$i]);
    exec ($command, $attrOutput, $ret);
    exec($weatherCommand, $weatherOutput, $weatherRet);
    echo "<div class='tripStep'>";
    echo "<div class='cityName'>";
    echo ($i - 2) . ". " . $output[$i] . "<br>";
    echo "</div>";
    if ($ret == 0) {
        if ($i != $stops + 4) {
            echo "<div class='cityDesc'>";
            echo $attrOutput[1];
            if (count($attrOutput) > 5) {
                echo "<br>" . $attrOutput[5];
            }
            echo "</div>";
        }
        if ($attrOutput[3] != "") {
            echo "<div class='cityPhoto'>";
            echo "<img src='" . $attrOutput[3] . "'>";
            echo "</div>";
        }
    }
    if ($weatherRet == 0) {
        echo "<div class='widgetBox positionInTripBox'>";
        printWeatherContent($weatherOutput, $output[$i]);
        echo "</div>";
    }
    unset($attrOutput);
    unset($weatherOutput);
    echo "</div>";
}

/**
 * Printing trip summary.
 */
echo "<div class='tripSummary'>";
echo $output[0] . " ";
echo "<span class='minutesSummary'>";
echo $output[1] . " ";
echo "</span>";
echo $output[2];
echo "</div>";

?>

</body>
</html>
