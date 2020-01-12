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

<h3 class="text-center mt-4 mb-4" data-aos="fade-down">Daily Schedule</h3>
<?php if(isset($_SESSION["id"])){ ?>
  <small class="text-muted d-flex justify-content-center mb-2 text-center" data-aos="fade-in" data-aos-delay="900">You can press on a stop in an autobus line drop menu to buy a ticket to there</small>
<?php } ?>
<?php foreach ($autobusLine as $al){ ?>
  <div class="container">
    <div class="accordion shadow" id="accordion" data-aos="fade-up">
      <div class="card">
        <div class="card-header" id="headingeOne">
          <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php print($al->getId()); ?>" aria-expanded="true" aria-controls="collapseOne">
              <?php print($al->getStart(). " - ". $al->getStop());?>
            </button>
            <?php if(isset($admin) && ($admin == true)){ ?>
              <a href="index.php?controller=EditAutobusLine&method=index&autobusLineId=<?php print($al->getId()); ?>" class="btn btn-primary float-right">Edit</a>
              <a href="index.php?controller=SingleLineSchedule&method=index&autobusLine=<?php print($al->getId()); ?>" class="btn btn-primary mr-2 float-right">View</a>
            <?php } else { ?>
              <a href="index.php?controller=SingleLineSchedule&method=index&autobusLine=<?php print($al->getId()); ?>" class="btn btn-primary float-right">View</a>
            <?php } ?>
          </h5>
        </div>

        <div id="collapse<?php print($al->getId()); ?>" class="collapse" aria-labelledby="headingeOne" data-parent="#accordion">
          <div class="card-body">
            <div class="col-12 h-100 text-center text-lg-left my-auto">
                <ul class="list-inline mb-2">
                  <?php foreach ($al->getAllLineStops() as $stop){ ?>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                      <a href="http://localhost/Herc-Bus_project/index.php?controller=BuyTicket&method=index&autobusLine=<?php print($al->getId()); ?>&destination=<?php print($stop->id); ?>"><?php print($stop->name); ?></a>
                    </li>
                  <?php } ?>
                </ul>
            </div>
            
            <hr class="col-12">

            <table class="col-md-6 h-100 text-center text-lg-left my-auto">
                <caption style="caption-side: top;" >Direction: <?php print($al->getStart(). " - ". $al->getStop());?></caption>
                <tr>
                  <th>Departure Time</th>
                  <?php foreach ($al->getScheduleForward() as $sf){ ?>
                    <td><p><?php print($sf->start_time); ?></p></td>
                  <?php } ?>
                </tr>

                <tr>
                <th>Arrival Time</th>
                  <?php foreach ($al->getScheduleForward() as $sf){ ?>
                    <td><p><?php  print($sf->stop_time); ?></p></td>
                  <?php } ?>
                </tr>
            </table>

            <hr class="col-10">

            <table class="col-md-6 h-100 text-center text-lg-left my-auto">
                <caption style="caption-side: top;" >Direction: <?php print($al->getStop(). " - ". $al->getStart());?></caption>
                <tr>
                    <th>Departure Time</th>
                    <?php foreach ($al->getScheduleBackward() as $sb){ ?>
                      <td><p><?php print($sb->start_time); ?></p></td>
                    <?php } ?>
                </tr>

                <tr>
                    <th>Arrival Time</th>
                    <?php foreach ($al->getScheduleBackward() as $sb){ ?>
                      <td><p><?php  print($sb->stop_time); ?></p></td>
                    <?php } ?>
                </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>  
<?php } ?>

  <?php if(isset($admin) && ($admin == true)){ ?>
    <div class="container">
      <div class="float-right my-3" data-aos="fade-right" data-aos-duration="500" data-aos-delay="400" data-aos-anchor-placement="#accordion">
        <a href="index.php?controller=NewAutobusLine&method=index"><button class="btn btn-outline-success">Add new</button></a>
      </div>
    </div>
  <?php } ?>
