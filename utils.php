<?php


function chooseWeatherImg($weather) {
    if ($weather == "Clear")
        return "&#9728";
    elseif ($weather == "Clouds")
        return "&#127781";
    elseif ($weather == "Rain")
        return "&#127783";
    elseif ($weather == "Fog")
        return "&#127745";
    else
        return "";
}

function getWeatherCommand($place) {
    return "python3 ./Weather/weather.py \"" . $place . "\"";
}

function printWeatherContent($weatherOutput, $place) {
    echo "<div class='widgetImg'>";
    echo chooseWeatherImg($weatherOutput[0]);
    echo "</div>";
    echo "<div class='widgetPlace'>";
    echo $place;
    echo "</div>";
    echo "<div class='widgetRow'>";
    echo $weatherOutput[2] . "&#8451";
    echo "</div>";
    echo "<div class='widgetRow'>";
    echo "&#10138 " . $weatherOutput[3] . " m/s";
    echo "</div>";
}


