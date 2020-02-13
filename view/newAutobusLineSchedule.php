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
        <a class="nav-link dropdown-toggle" href="index.php?controller=Frontpage&method=index" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php print($accountName); ?> </a>
        
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="index.php?controller=Profile&method=index">Profile</a>
          <a class="dropdown-item" href="index.php?controller=Settings&method=index">Settings</a>
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

<?php  ?>



<div class="container mt-4" data-aos="fade-in">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white text-center">
            Add a schedule/s for newly created autobus line
        </div>
        
        <form method="POST" method="index.php?controller=NewSingleLineSchedule&method=index">
          <input type="hidden" name="autobusLine" value='<?php print($array) ?>'>
          <div class="card-body">
            <h5 class="card-title text-center">Schedules:</h5>
            <small class="d-flex justify-content-center">Enter the schedules</small><br>

            <div id="scheduleContainer"> 
                <div class="text-center">
                    <h5 class="text-center">Schedule 1</h5><br>
                    
                    <label>Start Time:</label>
                    <input type="time" name="listOfSchedules[0][startTime]" class="form-control text-center d-flex justify-content-center" required>
                    
                    <label>Stop Time:</label>
                    <input type="time" name="listOfSchedules[0][stopTime]" class="form-control text-center d-flex justify-content-center" required>
                    
                    <label>Number of seats in a autobus:</label>
                    <input type="number" min="1" value="45" name="listOfSchedules[0][numberOfSeats]" class="form-control text-center d-flex justify-content-center" required>
                    
                    <label>Direction:</label>
                    <select id="scheduleInput" name="listOfSchedules[0][direction]" class="form-control text-center d-flex justify-content-center" required>
                      <option value="0">From <?php print($autobusLine->getStop())?> to <?php print($autobusLine->getStart())?></option>
                      <option value="1" selected>From <?php print($autobusLine->getStart())?> to <?php print($autobusLine->getStop())?></option>
                    </select>

                    <hr class="col-6">
                </div>

            </div>

            <div class="row float-right">
                <div class="btn btn-outline-success mr-2" id="addNewSchedule" class="addNewSchedule" onclick='scrollToTheBottom()'>
                    <a>Add a new schedule</a>
                </div>

                <div class="btn btn-outline-danger" id="delteLastElement" class="delteLastElement">
                    <a>Delete the last schedule</a>
                </div>
            </div>
          </div><br><br>
          
          <div class="card-footer bg-dark">
            <button type="submit" class="btn btn-outline-light col-12">
              Create an autobus line
            </button>
          </div>
        </form>
    </div>
</div>
<br><br id=bottom>



<script>
//Js za button mora biti ovdije radi php-a
let i = 1;

document.getElementById('addNewSchedule').onclick = function () {
    let template = `
        <div class="text-center" data-aos="fade-up" data-aos-duration="600">
          <h5 class="text-center">Schedule ` + (i + 1) + `</h5><br>
          <label>Start Time:</label>
          <input type="time" name="listOfSchedules[` + (i + 1) + `][startTime]" class="form-control text-center d-flex justify-content-center" required>
                    
          <label>Stop Time:</label>
          <input type="time" name="listOfSchedules[` + (i + 1) + `][stopTime]" class="form-control text-center d-flex justify-content-center" required>
                    
          <label>Number of seats in a autobus:</label>
          <input type="number" min="1" value="45" name="listOfSchedules[` + (i + 1) + `][numberOfSeats]" class="form-control text-center d-flex justify-content-center" required>
                    
          <label>Direction:</label>
          <select name="listOfSchedules[` + (i + 1) + `][direction]" class="form-control text-center d-flex justify-content-center" required>
            <option value="0">From <?php print($autobusLine->getStop())?> to <?php print($autobusLine->getStart())?></option>
            <option value="1" selected>From <?php print($autobusLine->getStart())?> to <?php print($autobusLine->getStop())?></option>
          </select>

          <hr class="col-6">
        </div>`;

    let container = document.getElementById('scheduleContainer');
    let div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div);

    i++;

    let elmnt = document.getElementById("bottom");
    elmnt.scrollIntoView();
}

document.getElementById('delteLastElement').onclick = function () {
    if(i >= 1){
        let container = document.getElementById('scheduleContainer');
        container.removeChild(container.lastChild);
    
        i--;
    }
}
</script>