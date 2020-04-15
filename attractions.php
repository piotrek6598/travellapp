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

$command = "python3 ./AttractionSearcherOld/main.py \"" . $place . "\" " . $rating . " " . $limit;

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
    echo $output[$i]. "<br>";
    echo "</div>";
    echo $output[$i + 1] . "<br>" . $output[$i + 3];
    echo "</div>";
}

?>

</body>
</html>