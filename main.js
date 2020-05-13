/**
 * Variable describing number of currently active stops.
 * @type {number}
 */
let stopCount = 1;

/**
 * Constant describing maximum number of active stops.
 * @type {number}
 */
const maxStops = 5;

/**
 * Variable describing if searching for overnight stay is on.
 * @type {boolean}
 */
let searchForNightStay = false;

/**
 * Variable describing number of adults used in stay searching.
 * Value represents current user's choice. Default value is 2.
 * @type {number}
 */
let adults = 2;
let attrFormAdults = 2;

/**
 * Constant describing minimum number of adults used in stay searching.
 * @type {number}
 */
const minAdults = 1;
/**
 * Constant describing maximum number of adults used in stay searching.
 * @type {number}
 */
const maxAdults = 9;

/**
 * Flag indicating if search priority is 'fastest way'.
 * @type {boolean}
 */
let fastestWay = true;

/**
 * Flag indicating if search for stay is performed with attractions searching.
 * @type {boolean}
 */
let attractionsWithStaySearch = false;

let bestHotel = true;

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
    //document.getElementById("childrenNum").value = children;
    document.getElementById("fastestWay").value = fastestWay;
    document.getElementById("staySearch").value = searchForNightStay;
}

/**
 * Replaces empty fields with default values before submitting form.
 */
function postAttraction() {
    if (document.getElementById("attractionsLimit").value === "") {
        document.getElementById("attractionsLimit").value = "5"
    }
    if (document.getElementById("attractionsRating").value === "") {
        document.getElementById("attractionsRating").value = "3.0"
    }
    document.getElementById("adultAttrNum").value = attrFormAdults;
    document.getElementById("optionBestHotel").value = bestHotel;
    document.getElementById("staySearching").value = attractionsWithStaySearch;
}

/**
 * Change 'tabs' in searcher section. Displays form associated with chosen tab.
 * Clears values except stops.
 */
function changeStaySearchingVisibility() {
    if (searchForNightStay) {
        document.getElementById("deptDate").style.display = "initial";
        document.getElementById("deptDate").required = true;
        document.getElementById("deptDate").value = "";
        document.getElementById("searchOptions").style.display = "none"; //na inherit
        document.getElementById("adults").style.display = "inline-block";
        //document.getElementById("children").style.display = "inline-block";
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
        //document.getElementById("children").style.display = "none";
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
        //children = 0;
        fastestWay = true;
        let optionButtons = document.getElementsByClassName("optionTabButton");
        for (let i = 0; i < optionButtons.length; i++)
            optionButtons[i].className = optionButtons[i].className.replace(" active", "");
        document.getElementById("fastestOption").className += " active";
        setAdults();
        //setChildren();
    }
}

function changeAttractionsSearchingVisibility() {
    if (attractionsWithStaySearch) {
        let dateInputs = document.getElementsByClassName("dateInput");
        let dateInputLabels = document.getElementsByClassName("dateInputLabel");
        for (let i = 0; i < dateInputs.length; i++) {
            dateInputs[i].style.display = "initial";
            dateInputs[i].required = true;
            dateInputs[i].value = "";
        }
        document.getElementById("checkOutDate").min = getLocalDate();
        for (let i = 0; i < dateInputLabels.length; i++)
            dateInputLabels[i].style.display = "initial";
        document.getElementById("stayBudget").style.display = "block";
        document.getElementById("stayBudget").value = "";
        document.getElementById("adultsAttr").style.display = "inline-block";
        document.getElementById("searchHotelOptions").style.display = "inherit";
        let numButtons = document.getElementsByClassName("numButtonAttr");
        for (let i = 0; i < numButtons.length; i++)
            numButtons[i].style.display = "initial";
        setAttrFormAdults();
    } else {
        let dateInputs = document.getElementsByClassName("dateInput");
        let dateInputLabels = document.getElementsByClassName("dateInputLabel");
        for (let i = 0; i < dateInputs.length; i++) {
            dateInputs[i].style.display = "none";
            dateInputs[i].removeAttribute("required");
        }
        for (let i = 0; i < dateInputLabels.length; i++)
            dateInputLabels[i].style.display = "none";
        document.getElementById("stayBudget").style.display = "none";
        document.getElementById("adultsAttr").style.display = "none";
        document.getElementById("searchHotelOptions").style.display = "none";
        let numButtons = document.getElementsByClassName("numButtonAttr");
        for (let i = 0; i < numButtons.length; i++)
            numButtons[i].style.display = "none";
        attrFormAdults = 2;
    }
}

/**
 * Handles click event on tab in searcher section.
 * @param val - new value for @ref searchForNightStay, allowed are true and false.
 */
function changeSearchNightOption(val) {
    searchForNightStay = val;
    let searchButtons = document.getElementsByClassName("searchTabButton");
    for (let i = 0; i < searchButtons.length; i++)
        searchButtons[i].className = searchButtons[i].className.replace(" active", "");
    event.currentTarget.className += " active";
    changeStaySearchingVisibility();
}

function changeAttractionSearch(val) {
    attractionsWithStaySearch = val;
    let attractionSearchButtons = document.getElementsByClassName("attractionTabButton");
    for (let i = 0; i < attractionSearchButtons.length; i++)
        attractionSearchButtons[i].className = attractionSearchButtons[i].className.replace(" active", "");
    event.currentTarget.className += " active";
    changeAttractionsSearchingVisibility();
}

/**
 * Displays information to user about currently selected number of adults.
 */
function setAdults() {
    let ad = document.getElementById("adults");
    ad.innerText = adults.toString().concat(" adult");
    if (adults > 1)
        ad.innerText += "s";
}

function setAttrFormAdults() {
    let ad = document.getElementById("adultsAttr");
    ad.innerText = attrFormAdults.toString().concat(" adult");
    if (attrFormAdults > 1)
        ad.innerText += "s";
}

/**
 * Handles click event on tab (representing search option) in overnight stay search mode.
 * @param fastest - new value for @ref fastestWay, allowed are true and false.
 */
function changeSearchOption(fastest) {
    fastestWay = fastest;
    let optionButtons = document.getElementsByClassName("optionTabButton");
    for (let i = 0; i < optionButtons.length; i++)
        optionButtons[i].className = optionButtons[i].className.replace(" active", "");
    event.currentTarget.className += " active";
}

function changeHotelSearchOption (best) {
    bestHotel = best;
    let optionButtons = document.getElementsByClassName("optionHotelTabButton");
    for (let i = 0; i < optionButtons.length; i++)
        optionButtons[i].className = optionButtons[i].className.replace(" active", "");
    event.currentTarget.className += " active";
    console.log(bestHotel);
}

/**
 * Inits start page.
 */
function initMainPage() {
    searchForNightStay = false;
    attractionsWithStaySearch = false;
    document.getElementById("routeSearchButton").className += " active";
    document.getElementById("fastestOption").className += " active";
    document.getElementById("onlyAttractionButton").className += " active";
    document.getElementById("bestHotelOption").className += " active";
    let localDate = getLocalDate();
    document.getElementById("deptDate").min = localDate;
    document.getElementById("checkInDate").min = localDate;
    document.getElementById("checkOutDate").min = localDate;
    setAdults();
    //setChildren();
    changeStaySearchingVisibility();
    changeAttractionsSearchingVisibility();
    console.log(bestHotel);
}

function getLocalDate() {
    let tzoffset = (new Date()).getTimezoneOffset() * 60000;
    return (new Date(Date.now() - tzoffset)).toISOString().split("T")[0];
}

function changeAdultsInAtrrForm(change) {
    if (attrFormAdults + change >= minAdults && attrFormAdults + change <= maxAdults)
        attrFormAdults += change;
    setAttrFormAdults();
}

/**
 * Handles click event on button changing adults number.
 * Do nothing if new value would be small than @ref minAdults or greater than #ref maxAdults.
 * @param change - change of @ref adults variable, allowed are 1 and -1.
 */
function changeAdultsNum(change) {
    if (adults + change >= minAdults && adults + change <= maxAdults)
        adults += change;
    setAdults();
}

function setCheckOutMinDay() {
    console.log("OK");
    console.log(document.getElementById("checkInDate").value);
    let d = new Date(document.getElementById("checkInDate").value);
    d.setDate(d.getDate() + 1);
    document.getElementById("checkOutDate").min = d.toISOString().split("T")[0];
}

function resetMinDates() {
    document.getElementById("checkInDate").min = getLocalDate();
    document.getElementById("checkOutDate").min = getLocalDate();
    console.log(getLocalDate());
    console.log(document.getElementById("checkInDate").min);
    console.log(document.getElementById("checkOutDate").min);
}

initMainPage();
document.getElementById("checkInDate").addEventListener("input", setCheckOutMinDay);
document.getElementById("resetAttrArgs").addEventListener("click", resetMinDates);