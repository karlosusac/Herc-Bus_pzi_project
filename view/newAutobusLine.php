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
        
        <form method="POST" method="index.php?controller=NewSingleLineSchedule&method=index">
          <div class="card-body">

            <div class="text-center col-12" style="text-align: center;">
                <h5 class="card-title">Autobus Line:</h5><br>
                <p>Start: <input type="text" class="form-control text-center" name="autobusLineStart" required></p>
                <p>Stop: <input type="text" class="form-control text-center" name="autobusLineStop" required></p>
            </div>

            <hr class="col-10">

            <h5 class="card-title text-center">Stops:</h5>
            <small class="d-flex justify-content-center">Enter the stops in order</small><br>

            <div id="stopContainer"> 
                <div class="text-center">
                    <h5 class="text-center">Stop 1</h5><br>
                    <label>Name:</label>
                    <select id="stopsSelect" name="listOfStops[0]" class="form-control text-center d-flex justify-content-center" required>
                      <option value="0" disabled selected>Choose a stop</option>
                      <?php foreach($stops as $stop){ ?>
                        <option value="<?php print($stop->getId()); ?>" ><?php print($stop->getName()); ?></option>
                      <?php } ?>
                    </select>

                    <hr class="col-6">
                </div>

                <div class="text-center">
                    <h5 class="text-center">Stop 2</h5><br>
                    <label>Name:</label>
                    <select id="stopsInput" name="listOfStops[1]" class="form-control text-center d-flex justify-content-center" required>
                      <option value="0" disabled selected>Choose a stop</option>
                      <?php foreach($stops as $stop){ ?>
                        <option value="<?php print($stop->getId()); ?>" ><?php print($stop->getName()); ?></option>
                      <?php } ?>
                    </select>

                    <hr class="col-6">
                </div>
            </div>

            <div class="row float-right">
                <div class="btn btn-outline-success mr-2" id="addNewStop" class="addNewStop" onclick='scrollToTheBottom()'>
                    <a>Add a new stop</a>
                </div>

                <div class="btn btn-outline-danger" id="delteLastElement" class="delteLastElement">
                    <a>Delete the last stop</a>
                </div>
            </div>
          </div><br><br>
          
          <div class="card-footer bg-dark">
            <button type="submit" class="btn btn-outline-light col-12">
              Add
            </button>
          </div>
        </form>
    </div>
</div>
<br><br id=bottom>



<script>
//Js za button mora biti ovdije radi php-a
let i = 2;

document.getElementById('addNewStop').onclick = function () {
    let template = `
        <div class="text-center" data-aos="fade-up" data-aos-duration="600">
            <h5 class="text-center">Stop` + (i + 1) + `</h5><br>
            <label>Name:</label>
            <select name="listOfStops[` + i + `]" class="form-control text-center d-flex justify-content-center" required>
            <option value="0" disabled selected>Choose a stop</option>
            <?php foreach($stops as $stop){ ?>
                <option value="<?php print($stop->getId()); ?>" ><?php print($stop->getName()); ?></option>
            <?php } ?>
            </select>

            <hr class="col-6">
        </div>`;

    let container = document.getElementById('stopContainer');
    let div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div);

    i++;

    let elmnt = document.getElementById("bottom");
    elmnt.scrollIntoView();
}

document.getElementById('delteLastElement').onclick = function () {
    if(i > 1){
        let container = document.getElementById('stopContainer');
        container.removeChild(container.lastChild);
    
        i--;
    }
}
</script>