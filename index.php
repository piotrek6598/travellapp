<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travelapp</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<body>

<!-- Column with trip finder. -->
<div id="tripPlan">
    <header>
        Plan your trip
    </header>
    <div id="searchTabs">
        <button class="searchTabButton" id="routeSearchButton" onclick="changeSearchNightOption(false)">Only find best route</button>
        <button class="searchTabButton" id="staySearchButton" onclick="changeSearchNightOption(true)">Search for overnight stay</button>
    </div>
    <div id="searchOptions">
        <div class="optionSearchMsg">Select search option: </div>
        <button class="optionTabButton" id="fastestOption" onclick="changeSearchOption(true)">Fastest way</button>
        <button class="optionTabButton" id="cheapestOption" onclick="changeSearchOption(false)">Cheapest stay</button>
    </div>
    <!-- Form enabling founding best trip. -->
    <form action="trip.php" method="post" id="tripForm" target="_blank">
        <label></label>
        <input type="text" name="startPlace" id="departurePlace"
               placeholder="Start place" required/>
        <input type="date" name="deptDate" id="deptDate" value="" required/>
        <input type="button" class="numButton" onclick="changeAdultsNum(-1)" value="-">
        <div id="adults"></div>
        <input type="button" class="numButton" onclick="changeAdultsNum(1)" value="+">
        <input type="button" class="numButton" onclick="changeRoomsNum(-1)" value="-">
        <div id="rooms"></div>
        <input type="button" class="numButton" onclick="changeRoomsNum(1)" value="+">
        <br>
        <input type="text" name="stopPlace1" class="stop1" placeholder="Stop 1" required/>
        <input type="number" min="0" name="stop1Nights" id="stop1Nights" placeholder="Stay (in days)" required/>
        <br>
        <div id="stop2">
            <label></label>
            <input type="text" name="stopPlace2" id="stopPlace2" placeholder="Stop 2" required/>
            <input type="number" min="0" name="stop2Nights" id="stop2Nights" placeholder="Stay (in days)">
            <input type="button" name="delStop2" value="X" onclick="delStop()"
                   class="delStopButton" style="width: 50px"/>
            <br>
        </div>
        <div id="stop3">
            <label></label>
            <input type="text" name="stopPlace3" id="stopPlace3" placeholder="Stop 3"/>
            <input type="number" min="0" name="stop3Nights" id="stop3Nights" placeholder="Stay (in days)">
            <input type="button" name="delStop3" value="X" onclick="delStop()"
                   class="delStopButton" style="width: 50px"/>
            <br>
        </div>
        <div id="stop4">
            <label></label>
            <input type="text" name="stopPlace4" id="stopPlace4" placeholder="Stop 4"/>
            <input type="number" min="0" name="stop4Nights" id="stop4Nights" placeholder="Stay (in days)">
            <input type="button" name="delStop4" value="X" onclick="delStop()"
                   class="delStopButton" style="width: 50px"/>
            <br>
        </div>
        <div id="stop5">
            <label class="stop5"></label>
            <input type="text" name="stopPlace5" class="stop5" id="stopPlace5" placeholder="Stop 5"/>
            <input type="number" min="0" name="stop5Nights" id="stop5Nights" placeholder="Stay (in days)">
            <input type="button" name="delStop5" value="X" class="delStopButton"
                   onclick="delStop()" style="width: 50px"/>
            <br>
        </div>

        <!-- Button adds more possible stops. -->
        <input type="button" name="moreStops" value="+"
               onclick="addStop()" style="border-radius: 50%; width: 50px"/>
        <span id="addStopLabel" onclick="addStop()"><a
                href="#">Add more stops (max. 5)</a></span>
        <input type="hidden" name="stops" id="totalStops" value=""/> <!--- Hidden field with number of active stops -->
        <input type="hidden" name="adultsNum" id="adultsNum" value=""/> <!-- Hidden field with number of adults -->
        <input type="hidden" name="roomsNum" id="roomsNum" value=""/> <!-- Hidden field with number of rooms -->
        <input type="hidden" name="fastestWay" id="fastestWay" value=""/> <br> <!-- Hidden flag with search option -->
        <input type="submit" name="planTrip" onclick="postStops()" value="Plan your trip"/>
        <input type="reset" name="resetArgs" value="Reset trip"/>
    </form>
</div>

<!-- Column with attractions finder. -->
<div id="attractionSearch">
    <header>
        Look for attractions
    </header>
    <form action="attractions.php" method="post" id="attractionsSearchForm" target="_blank">
        <label></label>
        <input type="text" name="attractionsPlace" placeholder="Place" required/>
        <br>
        <input type="number" name="attractionsLimit" id="attractionsLimit" placeholder="Attractions limit (e.g. 2)"/>
        <span>Default is 5</span>
        <br>
        <input type="number" name="attractionsRating" id="attractionsRating" placeholder="Minimum rating (e.g. 3.2)" step="0.1"/>
        <span>Default is 3.0</span>
        <br>
        <input type="submit" name="searchAttractions" value="Search attractions" onclick="postAttraction()">
        <input type="reset" name="restArgs" value="Clear" style="width: 150px"/>
    </form>
</div>

</body>
<script src="main.js"></script>
</html>