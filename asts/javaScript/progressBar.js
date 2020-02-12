var startTime = [],
    stopTime = [];

    console.log(document.getElementsByClassName("progress-bar")[1]);

var countdownUpdate = setInterval(function() {

    for(var counter = 0; counter < startTime.length; counter++){
        var start = new Date(startTime[counter]),
            end = new Date(stopTime[counter]);

        var startDate = start.getTime();
        var endDate = end.getTime();
        var now = new Date().getTime();

        // Get the total possible timestamp value
        var total = endDate - startDate;

        // Get the current value
        var current = now - startDate;

        // Get the percentage
        var progress = ((current / total) * 100) + '%';

        document.getElementsByClassName("progress-bar")[counter].style.width = progress;

        if (progress === "100%") {
            clearInterval(countdownUpdate);
            document.getElementsByClassName("countdown")[counter].innerHTML = "Autobus has started, refresh the page for an update.";
        }
    }
}, 500);
