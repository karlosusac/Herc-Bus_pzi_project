<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
        <a class="nav-link" href="index.php?controller=Schedule&method?index">Schedule</a>
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

<br><hr class="col-10"><br>

<div class="container">
  <div class="card text-center shadow-sm">
    <div class="card-header bg-dark text-white">
      Herc-Bus Ticket
    </div>
    <?php if(isset($_GET["error"])) { ?>
      <div class="alert alert-danger">
        <strong>Error:</strong>
        <p><?php print($_GET["error"]); ?></p>
      </div>
    <?php } ?>

    <?php if(isset($_GET["success"])) { ?>
      <div class="alert alert-success">
        <strong>Success:</strong>
        <p><?php print($_GET["success"]); ?></p>
      </div>
    <?php } ?>
    <?php if(isset($_POST["date"])){ ?>
      <div class="card-body" data-aos="fade-in">
        <h5 class="card-title">Processing</h5><br>
        <div class="spinner-border mx-5 my-5" role="status"></div>
      </div>
      
    <?php } elseif(isset($_GET["schedule"]) && (isset($_GET["destination"])) && (isset($_GET["departure"]) && (isset($_GET["autobusLine"])))){ ?>

      <div class="card-body" data-aos="fade-in">
        <h5 class="card-title">For when do you want this ticket researved:</h5><br>
        <form action="index.php?controller=BuyTicket&method=index&autobusLine=<?php print($ticket->getAutobusLineId()); ?>&destination=<?php print($ticket->getDestination()) ?>&departure=<?php print($ticket->getDeparture()); ?>&schedule=<?php print($ticket->getScheduleId()); ?>" method="POST">
        <input type="date" name="date" class="form-control" style="text-align: center;" required>
        <small class="text-muted">You can only buy the ticket for 2 months in advance!</small><br>
        <br><h5 class="card-title">Ticket price:</h5>
        <h5 class="card-title"><?php print($ticket->getPrice()); ?> KM</h5>
          <div class="card-footer bg-white mt-3">
            <a href="index.php?controller=BuyTicket&method=index" class="btn btn-outline-danger mr-3">Decline</a>  
            <button type="submit" class="btn btn-outline-primary">Reserve</button>
          </div>
        </form>
      </div>

    <?php } elseif(isset($_GET["departure"]) && (isset($_GET["destination"])) && (isset($_GET["autobusLine"]))){ ?>

      <div class="card-body" data-aos="fade-in">
        <h5 class="card-title">Select time:</h5><br>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <?php foreach ($schedule as $s){ ?>
            <a class="text-black hover-white btn btn-outline-primary mx-3" name="schedule" href="index.php?controller=BuyTicket&method=index&autobusLine=<?php print($_GET["autobusLine"]); ?>&destination=<?php print($_GET["destination"]) ?>&departure=<?php print($_GET["departure"]); ?>&schedule=<?php print($s->ID); ?>"> <?php print($s->start_time. " - ". $s->stop_time); ?></a>
          <?php } ?>
        </div>
      </div>
        
    <?php } elseif(isset($_GET["destination"]) && (isset($_GET["autobusLine"]))){ ?>

      <div class="card-body" data-aos="fade-in">
        <h5 class="card-title">Select departure place:</h5><br>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <?php foreach ($stops as $stop){ ?>
            <a class="text-black hover-white btn btn-outline-primary mx-3" name="departure" href="index.php?controller=BuyTicket&method=index&autobusLine=<?php print($_GET["autobusLine"]); ?>&destination=<?php print($_GET["destination"]) ?>&departure=<?php print($stop->id); ?>"> <?php print($stop->name); ?></a>
          <?php } ?>
        </div>
      </div>

    <?php } elseif(isset($_GET["autobusLine"])){ ?>

      <div class="card-body" data-aos="fade-in">
        <h5 class="card-title">Select destination:</h5><br>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <?php foreach ($stops as $stop){ ?>
            <a class="text-black hover-white btn btn-outline-primary mx-3" name="destination" href="index.php?controller=BuyTicket&method=index&autobusLine=<?php print($_GET["autobusLine"]); ?>&destination=<?php print($stop->id); ?>"> <?php print($stop->name); ?></a>
          <?php } ?>
        </div>
      </div>

    <?php } else { ?>

      <div class="card-body" data-aos="fade-in">
        <h5 class="card-title">Select an autobus line:</h5><br>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <?php foreach ($autobusLine as $al){ ?>
            <a class="text-black hover-white btn btn-outline-primary mx-3" name="autobusLine" href="index.php?controller=BuyTicket&method=index&autobusLine=<?php print($al->getId()); ?>"> <?php print($al->getStart(). " - ". $al->getStop()) ?></a>
          <?php } ?>
        </div>
      </div>

    <?php }?>
</div>