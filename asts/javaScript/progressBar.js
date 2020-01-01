var start = new Date(startTime),
    end = new Date(stopTime);

var countdownUpdate = setInterval(function() {

    var startDate = start.getTime();
    var endDate = end.getTime();
    var now = new Date().getTime();

    // Get the total possible timestamp value
    var total = endDate - startDate;

    // Get the current value
    var current = now - startDate;

    // Get the percentage
    var progress = ((current / total) * 100) + '%';

    document.getElementsByClassName("progress-bar")[0].style.width = progress;

    if (progress === "100%") {
        clearInterval(countdownUpdate);
        document.getElementsByClassName("countdown")[0].innerHTML = "Autobus has started, refresh the page for an update.";
    }
    
}, 500);
