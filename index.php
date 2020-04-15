<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travelapp</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<body>

<div id="tripPlan">
    <header>
        Plan your trip
    </header>
    <form action="trip.php" method="post" id="tripForm">
        <label></label>
        <input type="text" name="startPlace" id="departurePlace"
               placeholder="Start place"/>
        <br>
        <input type="text" name="stopPlace1" class="stop1" placeholder="Stop 1"/>
        <br>
        <div id="stop2">
            <label></label>
            <input type="text" name="stopPlace2" placeholder="Stop 2"/>
            <input type="button" name="delStop2" value="X" onclick="delStop()"
                   class="delStopButton" style="width: 50px"/>
            <br>
        </div>
        <div id="stop3">
            <label></label>
            <input type="text" name="stopPlace3" placeholder="Stop 3"/>
            <input type="button" name="delStop3" value="X" onclick="delStop()"
                   class="delStopButton" style="width: 50px"/>
            <br>
        </div>
        <div id="stop4">
            <label></label>
            <input type="text" name="stopPlace4" placeholder="Stop 4"/>
            <input type="button" name="delStop4" value="X" onclick="delStop()"
                   class="delStopButton" style="width: 50px"/>
            <br>
        </div>
        <div id="stop5">
            <label class="stop5"></label>
            <input type="text" name="stopPlace5" class="stop5"
                   placeholder="Stop 5"/>
            <input type="button" name="delStop5" value="X" class="delStopButton"
                   onclick="delStop()" style="width: 50px"/>
            <br>
        </div>

        <input type="button" name="moreStops" value="+"
               onclick="addStop()" style="border-radius: 50%; width: 50px"/>
        <span id="addStopLabel" onclick="addStop()"><a
                href="#">Add more stops</a></span>
        <input type="hidden" name="stops" id="totalStops" value=""/>
        <input type="submit" name="planTrip" onclick="postStops()" value="Plan your trip"/>
    </form>
</div>

</body>
<script src="main.js"></script>
</html>