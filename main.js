let stopCount = 1;

function addStop() {
    if (stopCount == 5)
        return;
    let bStr = stopCount.toString();
    stopCount++;
    let str = stopCount.toString();
    document.getElementById("stop".concat(str)).style.display = "block";
    document.getElementsByName("delStop".concat(bStr)).item(0).style.display = "none";
}

function delStop() {
    let str = stopCount.toString();
    document.getElementById("stop".concat(str)).style.display = "none";
    stopCount--;
    str = stopCount.toString();
    document.getElementsByName("delStop".concat(str)).item(0).style.display = "inline-block";
}

function postStops() {
    document.getElementById("totalStops").value = stopCount;
}