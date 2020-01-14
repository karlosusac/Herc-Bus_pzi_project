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
        BolaHajdeVise = []
</script>

<?php foreach ($stops as $stop) { ?>
    <script>
        stopsSelectField['<?php print($stop->getName()) ?>'] = counter;
        BolaHajdeVise[counter] = {name:"<?php print($stop->getName()) ?>", id:"<?php print($stop->getId()) ?>" }
        counter++;
    </script>
<?php } ?>


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

        <form method="POST" action="index.php?controller=Test&method=index">
            <div class="card-body">
                <div class="text-center col-12" style="text-align: center;">
                    <h5 class="card-title">Autobus Line:</h5><br>
                    <p>Start: <input type="text" class="form-control text-center" name="autobusLineStart" value="<?php print($autobusLine->getStart()) ?>" required></p>
                    <p>Stop: <input type="text" class="form-control text-center" name="autobusLineStop" value="<?php print($autobusLine->getStop()) ?>" required></p>
                </div>

                <hr class="col-10 my-4">

              
                <div class="text-center col-12" id="stopContainer" style="text-align: center;">
                    <h5 class="card-title">Stops:</h5><br>
                    <?php foreach($autobusLine->getAllLineStops() as $als){ ?>
                        <script>
                            var stopName = "<?php print($als->name); ?>";
                        </script>

                        <div class="mt-2">
                            <h5 class="text-center">Stop <?php print($stopsCounter + 1) ?></h5><br>
                            <label>Name:</label>
                            <select id="stopsSelect<?php print($stopsCounter) ?>" name="editAutobusLineStops[<?php print($stopsCounter) ?>]" class="form-control text-center d-flex justify-content-center" required> 
                                <?php foreach($stops as $stop){ ?>
                                    <option value="<?php print($stop->getId()); ?>" ><?php print($stop->getName()); ?></option>   
                                    <script>
                                        var Blabla = "<?php print($stop->getName()); ?>";
                                        if(stopName == Blabla){
                                            var index = stopsSelectField[stopName];
                                            console.log(index + " value is " + stopName);
                                            document.getElementById("stopsSelect<?php print($stopsCounter) ?>").selectedIndex = index;
                                        }
                                    </script>
                                <?php } ?>
                            </select>
                        </div>
                        <?php $stopsCounter++; ?>
                    <?php }  ?>
                </div>
                
                <div class="btn btn-outline-success my-2 d-flex justify-content-center" id="addNewStop" class="addNewStop" onclick='scrollToTheBottom()'>
                    <a>Add a new stop</a>
                </div>

            </div>

            <div class="card-footer bg-dark">
                <button type="submit" class="btn btn-outline-light col-12">
                    Edit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
//Js za button mora biti ovdije radi php-a
let i = <?php print(intval($stopsCounter) + 1) ?>;

document.getElementById('addNewStop').onclick = function () {
    let template = `
        <div class="mt-2">
          <h5 class="text-center">Stop` + i + `</h5><br>
          <label>Name:</label>
          <select id="stopsSelect` + i + `" name="editAutobusLineStops[` + i + `]" class="form-control text-center d-flex justify-content-center" required> 
            <?php foreach($stops as $stop){ ?>
              <option value="<?php print($stop->getId()); ?>" ><?php print($stop->getName()); ?></option> 
            <?php } ?>
          </select>
        </div>
        `

    let container = document.getElementById('stopContainer');
    let div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div);

    i++;
}

document.getElementById('delteLastElement').onclick = function () {
    if(i > 1){
        let container = document.getElementById('stopContainer');
        container.removeChild(container.lastChild);
    
        i--;
    }
}
</script>