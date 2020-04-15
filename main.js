/**
 * Variable describing number of currently active stops.
 * @type {number}
 */
let stopCount = 1;

/** Increases number of active stops. Changes visibility of buttons.
 */
function addStop() {
    if (stopCount === 5)
        return;
    let bStr = stopCount.toString();
    stopCount++;
    let str = stopCount.toString();
    let but = "stopPlace".concat(str);
    document.getElementById(but).required = true;
    document.getElementById("stop".concat(str)).style.display = "block";
    document.getElementsByName("delStop".concat(bStr)).item(0).style.display = "none";
}

/** Decreases number of active stops. Changes visibility of buttons.
 * Clears input field with currently deleted stop.
 */
function delStop() {
    let str = stopCount.toString();
    document.getElementById("stop".concat(str)).style.display = "none";
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
}

function postAttraction() {
    if (document.getElementById("attractionsLimit").value === "") {
        document.getElementById("attractionsLimit").value = "5"
    }
    if (document.getElementById("attractionsRating").value === "") {
        document.getElementById("attractionsRating").value = "3.0"
    }
}