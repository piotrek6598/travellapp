<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your trip</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>

<body class="tripBody">

<?php
/**
 * Variable representing number of stops.
 */
$stops = $_POST['stops'];

/**
 * Array containing stops.
 */
$stopArr = array(0 => $_POST['startPlace'], 1 => $_POST['stopPlace1'],
    2 => $_POST['stopPlace2'], 3 => $_POST['stopPlace3'], 4 => $_POST['stopPlace4'],
    5 => $_POST['stopPlace5']);

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
    exec ($command, $attrOutput, $ret);
    echo "<div class='tripStep'>";
    echo "<div class='cityName'>";
    echo ($i - 2) . ". " . $output[$i]. "<br>";
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
        if ($attrOutput[3] != ""){
            echo "<div class='cityPhoto'>";
            echo "<img src='".$attrOutput[3]. "'>";
            echo "</div>";
        }
    }
    unset($attrOutput);
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
