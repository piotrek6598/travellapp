<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attractions list</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="attractionsBody">
<?php

include 'utils.php';

/**
 * Variables representing place where attractions are searched, limit
 * attractions and minimum rating of attraction.
 */
$place = $_POST['attractionsPlace'];
$limit = $_POST['attractionsLimit'];
$rating = $_POST['attractionsRating'];

/**
 * Variables representing parameters for stay searching.
 */
$staySearching = $_POST['staySearching'];
$adults = $_POST['adultAttNum'];
$bestHotel = $_POST['optionBestHotel'];
$budget = $_POST['stayBudget'];
$checkIn = $_POST['checkInDate'];
$checkOut = $_POST['checkOutDate'];

$date1 = date_create($checkIn);
$date2 = date_create($checkOut);
$diff = date_diff($date1, $date2);
$stayNights = $diff->days;

$command = "python3 ./AttractionSearcher/main.py \"" . $place . "\" " . $rating . " " . $limit;

exec($command, $output, $ret);

/**
 * Printing information about error, if occurred.
 */
if ($ret == 1) {
    echo "<div class='errorBox'>";
    echo "<p class='errorMessage'>";
    echo "Sorry <br> We didn't find any attractions matching given criteria";
    echo "</p>";
    echo "</div>";
    exit;
}

$weatherCommand = getWeatherCommand($place);
exec($weatherCommand, $weatherOutput, $weatherRet);

echo "<header>";
echo "List of recommended attractions in " . $place;
echo "</header>";

echo "<div class='mszWarning'>";
echo "<i class='fa fa-exclamation-circle warningIcon' style='font-size: 60px; color: red'></i>";
echo "<span class='warningText'>My warning</span>";
echo "</div>";

$maxi = 4 * $limit;
if (count($output, COUNT_NORMAL) <= $maxi) {
    $maxi = count($output, COUNT_NORMAL) - 1;
}

for ($i = 1; $i <= $maxi; $i += 4) {
    echo "<div class='attractionBox'>";
    echo "<div class='attractionName'>";
    echo $output[$i] . "<br>";
    echo "</div>";
    echo "<div class='attractionDesc'>";
    echo $output[$i + 1] . "<br>" . $output[$i + 3];
    echo "</div>";
    if ($output[$i + 2] != "") {
        echo "<div class='attractionPhoto'>";
        echo "<img src='" . $output[$i + 2] . "' alt=''>";
        echo "</div>";
    }
    if ($weatherRet == 0 && $i == 1) {
        echo "<div class='widgetBox positionInAttractionSearch scale15'>";
        printWeatherContent($weatherOutput, $place);
        echo "</div>";
    }
    echo "</div>";
}

/**
 * Performing stay search if it's requested.
 */
if ($staySearching == "true") {

    $staySearchCommand = "python3 ./accomodation.py ";
    if ($bestHotel == "true") {
        $staySearchCommand = $staySearchCommand . "4";
    } else {
        $staySearchCommand = $staySearchCommand . "2";
    }
    $staySearchCommand = $staySearchCommand . " \"" . $checkIn . "\" \"" . $checkOut . "\" " . floor($budget / $stayNights) . " \"" .
        $place . "\" " . $adults;

    exec($staySearchCommand, $stayOutput, $stayRet);

    if ($stayRet == 0) {
        $bookingLink = $stayOutput[0];
        $results = $stayOutput[1];
    }

    if ($stayRet != 0 || $results == 0) {
        echo "<div class='stayPlaceNotFound'>";
        echo "Sorry, we didn't find any stay place matching your criteria <br>";
        echo "</div>";
        exit;
    }

    echo "<header>";
    echo "List of suggest stay places in " . $place;
    echo "</header>";

    for ($i = 2, $j = 0; $j < $results; $j++, $i += 5) {
        echo "<div class='stayPlaceBox'>";
        echo "<div class='stayPlaceName'>";
        echo $stayOutput[$i] . "<br>";
        echo "</div>";
        if ($stayOutput[$i + 4] != "/") {
            echo "<div class='stayPlaceRating'>";
            echo "Rating: " . $stayOutput[$i + 4] . "<br>";
            echo "</div>";
        }
        echo "<div class='stayPlacePrice'>";
        echo "Price: " . $stayOutput[$i + 3] . " per day<br>";
        echo "</div>";
        echo "<div class='stayPlacePhoto'>";
        echo "<img src='" . $stayOutput[$i + 2] . "' alt=''>";
        echo "</div>";
        echo "</div>";
    }

    echo "<button type='button' class='bookButton'>";
    echo "<a href='" . $bookingLink . "' target='_blank'>";
    echo "Book your stay";
    echo "</a></button>";
}

?>

</body>
</html>