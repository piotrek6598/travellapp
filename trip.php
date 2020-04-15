<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travelapp</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>

<body class="tripBody">

<?php
$startPlace = $_POST['startPlace'];
$stop1 = $_POST['stopPlace1'];
$stop2 = $_POST['stopPlace2'];
$stop3 = $_POST['stopPlace3'];
$stop4 = $_POST['stopPlace4'];
$stop5 = $_POST['stopPlace5'];
$stops = $_POST['stops'];

$stopArr = array(0 => $startPlace, 1 => $stop1, 2 => $stop2, 3 => $stop3, 4 => $stop4, 5 => $stop5);

$command = "python3 ./bestRoute/main.py \"". $stopArr[0] . "\" " . $stops;
for ($i = 1; $i <= $stops; $i++) {
    $command = $command . " \"" . $stopArr[$i]. "\"";
}


exec($command, $output, $ret);

if ($ret == 1) {
    echo "ERROR";
    exit(0);
}

echo "<header>";
echo "Our suggested trip is: <br>";
echo "</header>";

for ($i = 3; $i <= $stops + 4; $i++) {
    echo "<div class='tripStep'>";
    echo ($i - 2).". " . $output[$i]. "<br>";
    echo "</div>";
}

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
