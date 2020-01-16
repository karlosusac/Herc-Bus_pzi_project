<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <a class="navbar-brand ml-3" href="index.php?controller=Frontpage&method=index">Herc-Bus</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Frontpage&method=index">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Schedule&method=index">Schedule</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=BuyTicket&method?index">Buy a Ticket</a>
      </li>
      <?php if(isset($_SESSION["id"])){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php print($accountName); ?> </a>
        
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Profile</a>
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="index.php?controller=Schedule&method=logout">Log out</a>
        </div>
      </li>
      <?php } else { ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Login&method=index">Log in</a>
      </li>
      <?php }; ?>
    </ul>
  </div>
</nav>

<script>
        var stopsSelectField = [],
        counter = 0,
        stopsCoutner = 0,
        length = 0,
        anotherArray = [];

        //---------------

        var schedules = [],
            scheduleCounter = 0;
</script>

<?php foreach ($stops as $stop) { ?>
    <script>
      //Spremam sve stanice i za 'key' value spremam njegov index u niz
      stopsSelectField['<?php print($stop->getName()) ?>'] = counter;
      counter++;
    </script>
<?php } ?>

<?php foreach ($autobusLine->getAllLineStops() as $s) { ?>
    <script>
      //Spremam u niz sve stanice iz baze koje po postavljene za ovaj autobusLine
      anotherArray.push("<?php print($s->name) ?>");
      length++;
    </script>
<?php } ?>

<?php foreach ($autobusLine->getScheduleForward() as $schf) { ?>
    <script>
      var schedule = {
        startTime: "<?php print($schf->start_time); ?>",
        stopTime: "<?php print($schf->stop_time); ?>",
        numOfSeats: "<?php print($schf->number_of_seats); ?>",
        direction: "<?php print($schf->direction); ?>"
      }

      schedules.push(schedule);
    </script>
<?php } ?>

<?php foreach ($autobusLine->getScheduleBackward() as $schb) { ?>
    <script>
      var schedule = {
        startTime: "<?php print($schb->start_time); ?>",
        stopTime: "<?php print($schb->stop_time); ?>",
        numOfSeats: "<?php print($schb->number_of_seats); ?>",
        direction: "<?php print($schb->direction); ?>"
      }

      schedules.push(schedule);
    </script>
<?php } ?>

<script>
  
</script>



<div class="container mt-4" data-aos="fade-in">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white text-center">
            Create a new Autobus Line
        </div>

        <?php if(isset($_GET["error"])) { ?>
          <div class="alert alert-danger text-center">
            <strong>Error:</strong>
            <p><?php print($_GET["error"]); ?></p>
          </div>
        <?php } ?>

        <form method="POST" action="index.php?controller=EditAutobusLine&method=index">
        <input type="hidden" name="autobusLineId" value='<?php print($autobusLineId) ?>'>
            <div class="card-body">
                <div class="text-center col-12" style="text-align: center;">
                    <h5 class="card-title">Autobus Line:</h5><br>
                    <p>Start: <input type="text" class="form-control text-center" name="autobusLineStart" value="<?php print($autobusLine->getStart()) ?>" required></p>
                    <p>Stop: <input type="text" class="form-control text-center" name="autobusLineStop" value="<?php print($autobusLine->getStop()) ?>" required></p>
                </div>

                <hr class="col-10 my-4">
              
                <div class="text-center col-12" id="stopContainer" style="text-align: center;">
                    <h5 class="card-title">Stops:</h5><br>

                    <script>
                        for(var stopsCoutner; stopsCoutner < length; stopsCoutner++){

                        var container = document.getElementById('stopContainer');
                        var div = document.createElement('div');

                        var template = `<div class="mt-2">
                          <h5 class="text-center">Stop`+ (stopsCoutner + 1) +`</h5><br>
                          <label>Name:</label>
                          <select id="stopsSelect` + stopsCoutner + `" name="editAutobusLineStops[`+ stopsCoutner +`]" class="form-control text-center d-flex justify-content-center" required> 
                          <?php foreach($stops as $stop){ ?>
                            <option value="<?php print($stop->getId()); ?>"><?php print($stop->getName()); ?></option>
                          <?php } ?>                                  
                          </select>`

                          div.innerHTML = template;
                          container.appendChild(div);
                          }
                          stopsCoutner++
                      </script>                        
                </div>
                
                <div class="row d-flex justify-content-end mt-3">
                  <div class="btn btn-outline-success mr-2" id="addNewStop" class="addNewStop" onclick='scrollToTheBottom()'>
                      <a>Add a new stop</a>
                  </div>

                  <div class="btn btn-outline-danger" id="delteLastElement" class="delteLastElement">
                      <a>Delete the last stop</a>
                  </div>
                </div>

                <hr class="col-10 my-4">

                <div class="text-center col-12" id="scheduleContainer" style="text-align: center;">
                    <h5 class="card-title">Schedules:</h5><br>
                    
                    <script>
                      

                      for (var scheduleCounter; scheduleCounter < schedules.length; scheduleCounter++){
                        var scheduleContainer = document.getElementById('scheduleContainer');
                        var div = document.createElement('div');

                        var template = `
                          <div class="text-center">
                            <h5 class="text-center">Schedule ` + (scheduleCounter + 1) + `</h5><br>
                            <label>Start Time:</label>
                            <input type="time" name="editAutobusLineSchedules[` + scheduleCounter + `][startTime]" class="scheduleStartTime form-control text-center d-flex justify-content-center" required>
                                      
                            <label>Stop Time:</label>
                            <input type="time" name="editAutobusLineSchedules[` + scheduleCounter + `][stopTime]" class="scheduleStopTime form-control text-center d-flex justify-content-center" required>
                                      
                            <label>Number of seats in a autobus:</label>
                            <input type="number" min="1" value="45" name="editAutobusLineSchedules[` + scheduleCounter + `][numberOfSeats]" class="scheduleNumOfSeats form-control text-center d-flex justify-content-center" required>
                                      
                            <label>Direction:</label>
                            <select name="editAutobusLineSchedules[` + scheduleCounter + `][direction]" class="scheduleDirection form-control text-center d-flex justify-content-center" required>
                              <option value="0">From <?php print($autobusLine->getStop())?> to <?php print($autobusLine->getStart())?></option>
                              <option value="1">From <?php print($autobusLine->getStart())?> to <?php print($autobusLine->getStop())?></option>
                            </select>

                            <hr class="col-6">
                          </div>`;

                      
                      div.innerHTML = template;
                      scheduleContainer.appendChild(div);
                      }    
                    </script>    
                </div>

                <div class="row d-flex justify-content-end mt-3">
                <div class="btn btn-outline-success mr-2" id="addNewSchedule" class="addNewSchedule" onclick='scrollToTheBottom()'>
                    <a>Add a new schedule</a>
                </div>

                <div class="btn btn-outline-danger" id="delteLastElementSchedule">
                    <a>Delete the last schedule</a>
                </div>
            </div>
          </div><br><br>

            </div>

            <div class="card-footer row bg-dark d-flex justify-content-center">
                <button type="submit" class="btn btn-success col-md-3 mr-2">
                    Edit
                </button>

                <a class="btn btn-danger col-md-3" href="index.php?controller=EditAutobusLine&method=deleteAutobusLine&autobusLineId=<?php print(json_decode($autobusLineId)->id);?>">Delete an autobus line</a>
            </div>
        </form>
    </div>
</div>
<br><br>

<!-- JAVASCRIPT ZA STOPS, neke stvari je potrebno ptrebaciti u zaseban js file a druge je potrebno ostaviti -->
<script>
//Js za button mora biti ovdije radi php-a
container.removeChild(container.lastChild);

document.getElementById('addNewStop').onclick = function () {
    var template = `
        <div class="mt-2">
          <h5 class="text-center">Stop` + (stopsCoutner + 1) + `</h5><br>
          <label>Name:</label>
          <select id="stopsSelect` + stopsCoutner + `" name="editAutobusLineStops[` + stopsCoutner + `]" class="form-control text-center d-flex justify-content-center" required> 
            <option value="0" disabled selected>Choose a stop</option>
            <?php foreach($stops as $stop){ ?>
              <option value="<?php print($stop->getId()); ?>" ><?php print($stop->getName()); ?></option> 
            <?php } ?>
          </select>
        </div>
        `

    var container = document.getElementById('stopContainer');
    var div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div);

    stopsCoutner++;
}

document.getElementById('delteLastElement').onclick = function () {
    if(stopsCoutner > 2){
        let container = document.getElementById('stopContainer');
        container.removeChild(container.lastChild);
      
        stopsCoutner--;
    }
}

document.getElementById('addNewSchedule').onclick = function () {
    var template = `
        <div class="text-center" data-aos="fade-up" data-aos-duration="600">
          <h5 class="text-center">Schedule ` + (scheduleCounter + 1) + `</h5><br>
          <label>Start Time:</label>
          <input type="time" name="editAutobusLineSchedules[` + scheduleCounter + `][startTime]" class="scheduleStartTime form-control text-center d-flex justify-content-center" required>
                                      
          <label>Stop Time:</label>
          <input type="time" name="editAutobusLineSchedules[` + scheduleCounter + `][stopTime]" class="scheduleStopTime form-control text-center d-flex justify-content-center" required>
                                      
          <label>Number of seats in a autobus:</label>
          <input type="number" min="1" value="45" name="editAutobusLineSchedules[` + scheduleCounter + `][numberOfSeats]" class="scheduleNumOfSeats form-control text-center d-flex justify-content-center" required>
                                      
          <label>Direction:</label>
          <select name="editAutobusLineSchedules[` + scheduleCounter + `][direction]" class="scheduleDirection form-control text-center d-flex justify-content-center" required>
            <option value="0">From <?php print($autobusLine->getStop())?> to <?php print($autobusLine->getStart())?></option>
            <option value="1" selected>From <?php print($autobusLine->getStart())?> to <?php print($autobusLine->getStop())?></option>
          </select>

          <hr class="col-6">
        </div>`;

    var scheduleContainer = document.getElementById('scheduleContainer');
    var div = document.createElement('div');
    div.innerHTML = template;
    scheduleContainer.appendChild(div);

    scheduleCounter++;
}

document.getElementById('delteLastElementSchedule').onclick = function () {
    if(scheduleCounter > 1){
      var scheduleContainer = document.getElementById('scheduleContainer');
      scheduleContainer.removeChild(scheduleContainer.lastChild);
    
        scheduleCounter--;
    }
}

scheduleContainer.removeChild(scheduleContainer.lastChild);

//Magični kod koji veže sve,
//Kod izvlačenja podataka iz baza, onim 'option' poljima koji imaju vrijednost u bazi pridružuje tu vrijednosti
for(var stopsCoutner = 0; stopsCoutner < length; stopsCoutner++){
  var stopName = anotherArray[stopsCoutner],
      index = stopsSelectField[stopName];
  
  document.getElementById("stopsSelect" + stopsCoutner).getElementsByTagName("option")[index].setAttribute('selected', true);
}

var arrayIterator = 0;
for(var objIterator in schedules){
  document.getElementsByClassName("scheduleStartTime")[arrayIterator].value = schedules[objIterator].startTime;
  document.getElementsByClassName("scheduleStopTime")[arrayIterator].value = schedules[objIterator].stopTime;
  document.getElementsByClassName("scheduleNumOfSeats")[arrayIterator].value = schedules[objIterator].numOfSeats;
  document.getElementsByClassName("scheduleDirection")[arrayIterator].value = schedules[objIterator].direction;
  arrayIterator++;
}
</script>
