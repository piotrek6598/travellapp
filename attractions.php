<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attractions list</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>

<body class="attractionsBody">
<?php
/**
 * Variables representing place where attractions are searched, limit
 * attractions and minimum rating of attraction.
 */
$place = $_POST['attractionsPlace'];
$limit = $_POST['attractionsLimit'];
$rating = $_POST['attractionsRating'];

$staySearching = $_POST['staySearching'];
$adults = $_POST['adultAttNum'];
$bestHotel = $_POST['optionBestHotel'];
$budget = $_POST['stayBudget'];
$checkIn = $_POST['checkInDate'];
$checkOut = $_POST['checkOutDate'];

$command = "python3 ./AttractionSearcher/main.py \"" . $place . "\" " . $rating . " " . $limit;
$staySearchCommand = "python3 ./accomodation.py ";
if ($bestHotel == "true") {
    $staySearchCommand = $staySearchCommand . "4";
} else {
    $staySearchCommand = $staySearchCommand . "2";
}
$staySearchCommand = $staySearchCommand . " \"" . $checkIn . "\" \"" . $checkOut . "\" " . $budget . " \"" .
    $place . "\" " . $adults;

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

echo "<header>";
echo "List of recommended attractions in " . $place;
echo "</header>";

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
    echo "</div>";
}

if ($staySearching == "true") {

    exec($staySearchCommand, $stayOutput, $stayRet);

    $bookingLink = $stayOutput[0];
    $results = $stayOutput[1];

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
}

?>

</body>
</html>