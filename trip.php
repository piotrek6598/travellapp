<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travelapp</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>

<body>

<?php
$startPlace = $_POST['startPlace'];
$stop1 = $_POST['stopPlace1'];
$stop2 = $_POST['stopPlace2'];
$stop3 = $_POST['stopPlace3'];
$stop4 = $_POST['stopPlace4'];
$stop5 = $_POST['stopPlace5'];
$stops = $_POST['stops'];

$command = "python3 ./bestRoute/main.py Warsaw ". "2 ". "Gdansk ". "Cracow";
$output = passthru($command);
echo "OK";
echo $output . "<br>";
?>

</body>
</html>
