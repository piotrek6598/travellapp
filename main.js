/**
 * Variable describing number of currently active stops.
 * @type {number}
 */
let stopCount = 1;

let maxStops = 5;

let searchForNightStay = false;

let adults = 2;

let minAdults = 1;
let maxAdults = 9;

let rooms = 1;

let minRooms = 1;
let maxRooms = 5;

let fastestWay = true;

/** Increases number of active stops. Changes visibility of buttons.
 */
function addStop() {
    if (stopCount === maxStops)
        return;
    let bStr = stopCount.toString();
    stopCount++;
    let str = stopCount.toString();
    let but = "stopPlace".concat(str);
    document.getElementById(but).required = true;
    if (searchForNightStay) {
        document.getElementById("stop".concat(str, "Nights")).required = true;
    }
    document.getElementById("stop".concat(str)).style.display = "block";
    document.getElementsByName("delStop".concat(bStr)).item(0).style.display = "none";
    if (stopCount === maxStops) {
        document.getElementsByName("moreStops").item(0).style.display = "none";
        document.getElementById("addStopLabel").style.display = "none";
    }
}

/** Decreases number of active stops. Changes visibility of buttons.
 * Clears input field with currently deleted stop.
 */
function delStop() {
    let str = stopCount.toString();
    if (stopCount === maxStops) {
        document.getElementsByName("moreStops").item(0).style.display = "initial";
        document.getElementById("addStopLabel").style.display = "initial";
    }
    document.getElementById("stop".concat(str)).style.display = "none";
    if (searchForNightStay) {
        document.getElementById("stop".concat(str, "Nights")).removeAttribute("required");
        document.getElementById("stop".concat(str, "Nights")).value = "";
    }
    document.getElementById("stopPlace".concat(str)).removeAttribute("required");
    document.getElementById("stopPlace".concat(str)).value = "";
    stopCount--;
    str = stopCount.toString();
    document.getElementsByName("delStop".concat(str)).item(0).style.display = "inline-block";
}

/** Sets hidden field to number of active stops. Keeps first @p stopCount stops'
 * input fields as required.
 */
function postStops() {
    if (stopCount === 1) {
        document.getElementById("stopPlace2").removeAttribute("required");
    }
    document.getElementById("totalStops").value = stopCount;
    document.getElementById("adultsNum").value = adults;
    document.getElementById("roomsNum").value = rooms;
}

function postAttraction() {
    if (document.getElementById("attractionsLimit").value === "") {
        document.getElementById("attractionsLimit").value = "5"
    }
    if (document.getElementById("attractionsRating").value === "") {
        document.getElementById("attractionsRating").value = "3.0"
    }
}

function changeStaySearchingVisibility() {
    if (searchForNightStay) {
        document.getElementById("deptDate").style.display = "initial";
        document.getElementById("deptDate").required = true;
        document.getElementById("deptDate").value = "";
        document.getElementById("searchOptions").style.display = "inherit";
        document.getElementById("adults").style.display = "initial";
        document.getElementById("rooms").style.display = "initial";
        let numButtons = document.getElementsByClassName("numButton");
        for (let i = 0; i < numButtons.length; i++) {
            numButtons[i].style.display = "initial";
        }
        for (let i = 1; i <= maxStops; i++) {
            let str = i.toString();
            document.getElementById("stop".concat(str, "Nights")).style.display = "initial";
            if (i <= stopCount) {
                document.getElementById("stop".concat(str, "Nights")).required = true;
            }
        }
    } else {
        document.getElementById("deptDate").style.display = "none";
        document.getElementById("deptDate").removeAttribute("required");
        document.getElementById("searchOptions").style.display = "none";
        document.getElementById("adults").style.display = "none";
        document.getElementById("rooms").style.display = "none";
        let numButtons = document.getElementsByClassName("numButton");
        for (let i = 0; i < numButtons.length; i++) {
            numButtons[i].style.display = "none";
        }
        for (let i = 1; i <= maxStops; i++) {
            let str = i.toString();
            document.getElementById("stop".concat(str, "Nights")).style.display = "none";
            document.getElementById("stop".concat(str, "Nights")).value = "";
            document.getElementById("stop".concat(str, "Nights")).removeAttribute("required");
        }
        adults = 2;
        rooms = 1;
        fastestWay = false;
        let optionButtons = document.getElementsByClassName("optionTabButton");
        for (let i = 0; i < optionButtons.length; i++)
            optionButtons[i].className = optionButtons[i].className.replace(" active", "");
        document.getElementById("fastestOption").className += " active";
        setAdults();
        setRooms();
    }
}

function changeSearchNightOption(val) {
    searchForNightStay = val;
    let searchButtons = document.getElementsByClassName("searchTabButton");
    for (let i = 0; i < searchButtons.length; i++)
        searchButtons[i].className = searchButtons[i].className.replace(" active", "");
    event.currentTarget.className += " active";
    changeStaySearchingVisibility();
}

function setAdults() {
    let ad = document.getElementById("adults");
    ad.innerText = adults.toString().concat(" adult");
    if (adults > 1)
        ad.innerText += "s";
}

function setRooms() {
    let room = document.getElementById("rooms");
    room.innerText = rooms.toString().concat(" room");
    if (rooms > 1)
        room.innerText += "s";
}

function changeSearchOption(fastest) {
    fastestWay = fastest;
    let optionButtons = document.getElementsByClassName("optionTabButton");
    for (let i = 0; i < optionButtons.length; i++)
        optionButtons[i].className = optionButtons[i].className.replace(" active", "");
    event.currentTarget.className += " active";
}

function initMainPage() {
    searchForNightStay = false;
    document.getElementById("routeSearchButton").className += " active";
    document.getElementById("fastestOption").className += " active";
    setAdults();
    setRooms();
    changeStaySearchingVisibility();
}

function changeRoomsNum(change) {
    if (rooms + change >= minRooms && rooms + change <= maxRooms)
        rooms += change;
    setRooms();
}

function changeAdultsNum(change) {
    if (adults + change >= minAdults && adults + change <= maxAdults)
        adults += change;
    setAdults();
}

initMainPage();