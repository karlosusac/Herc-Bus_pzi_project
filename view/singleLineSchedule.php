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
          <a class="dropdown-item" href="index.php?controller=ChangePassword&method=index">Change password</a>
          <?php if($account->getAdmin() == 1){ ?>
            <a class="dropdown-item" href="index.php?controller=AddAdminAccount&method=index">New admin account</a>
          <?php } ?>          
          <a class="dropdown-item" href="index.php?controller=Frontpage&method=logout">Log out</a>
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

<div class="container">
  <div class="card text-center mt-4 shadow-sm" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="400">
    <div class="card-header bg-dark text-white">
        <?php print($autobusLine->getStart(). " - ". $autobusLine->getStop());?>
    </div>
    <div class="card-body">
      <?php if(!empty($autobusLine->activeDrives)) {?>
        <h5 class="card-text">List of all autobus drives:</h5>

        <br>

        <p class="card-title">Direction: <?php print($autobusLine->getStart(). " - ". $autobusLine->getStop());?></p>
        <?php foreach ($autobusLine->getScheduleForward() as $sf){ ?>
          <p class="btn <?php Helpers::displayCorrectBtn($sf->start_time, $sf->stop_time); ?> disabled"><?php print($sf->start_time). " - ". ($sf->stop_time);?></p>
        <?php } ?>
          <br>

        <p class="card-title">Direction: <?php print($autobusLine->getStop(). " - ". $autobusLine->getStart());?></p>
        <?php foreach ($autobusLine->getScheduleBackward() as $sb){ ?>
          <p class="btn <?php Helpers::displayCorrectBtn($sb->start_time, $sb->stop_time); ?> disabled"><?php print($sb->start_time). " - ". ($sb->stop_time);?></p>
        <?php } ?>

        <br><br>

        <h5 class="card-title">Stops:</h5>
        <?php foreach ($autobusLine->GetAllLineStops() as $stop){?>
          <p class="btn btn-primary disabled"><?php print($stop->name);?></p>
        <?php } ?>

        <?php for($counter = 0; $counter < count($autobusLine->activeDrives); $counter++){ ?>

          <?php if($autobusLine->activeDrives[$counter]["direction"] == 1){ ?>
            <div class="card-footer bg-white text-muted">
            <p class="text-muted float-left"><?php print($autobusLine->activeDrives[$counter]["startTime"]); ?></p><p class="text-muted float-right"><?php print($autobusLine->activeDrives[$counter]["stopTime"]); ?></p><br>
            <script src="asts/javaScript/progressBar.js"></script>
            <div class="progress">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="" aria-valuemin="" aria-valuemax=""></div>
                <script type="text/javascript">stopTime.push('<?php print(Helpers::getDateNow($autobusLine->activeDrives[$counter]["stopTime"]));?>');</script>
                <script type="text/javascript">startTime.push('<?php print(Helpers::getDateNow($autobusLine->activeDrives[$counter]["startTime"]));?>');</script>
              </div>
            </div>

          <?php } else { ?>
            <div class="card-footer bg-white text-muted">
            <p class="text-muted float-left"><?php print($autobusLine->activeDrives[$counter]["stopTime"]); ?></p><p class="text-muted float-right"><?php print($autobusLine->activeDrives[$counter]["startTime"]); ?></p><br>
            <div class="progress progress justify-content-end">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="" aria-valuemin="" aria-valuemax=""></div>
                <script type="text/javascript">stopTime.push('<?php print(Helpers::getDateNow($autobusLine->activeDrives[$counter]["stopTime"]));?>');</script>
                <script type="text/javascript">startTime.push('<?php print(Helpers::getDateNow($autobusLine->activeDrives[$counter]["startTime"]));?>');</script>
              </div>
            </div>
          <?php } ?>

        <?php } ?>

      <?php } elseif(($autobusLine->nextDrive) != false) { ?>
              
        <p class="card-text">List of all autobus drives:</p>
        <?php foreach ($autobusLine->getScheduleForward() as $sf){ ?>
          <p class="btn <?php Helpers::displayCorrectBtnForTheNextDrive($sf->start_time, $_GET["autobusLine"]); ?> disabled"><?php print($sf->start_time). " - ". ($sf->stop_time);?></p>
        <?php } ?>
          <br>
        <?php foreach ($autobusLine->getScheduleBackward() as $sb){ ?>
          <p class="btn <?php Helpers::displayCorrectBtnForTheNextDrive($sb->start_time, $_GET["autobusLine"]); ?> disabled"><?php print($sb->start_time). " - ". ($sb->stop_time);?></p>
        <?php } ?>
        <br><br>
            
        <div class="card-footer bg-white text-muted">
          <p class="countdown text-muted"></p>
        </div>
        <script type="text/javascript">var countdown='<?php print($autobusLine->nextDrive);?>';</script>
        <script src="asts/javaScript/countdownTimer.js"></script>

      <?php } else {?>
        <h6 class="text-muted"><p class="countdown">Done for today.</p></h6>
      <?php } ?>
    </div>
  </div>

  <div class="float-right my-3" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="400">
    <a href="index.php?controller=Schedule&method=index"><button class="btn btn-outline-danger">Go back</button></a>
  </div>
  
</div>



