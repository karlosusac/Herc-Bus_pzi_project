<nav  class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
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
        <a class="nav-link dropdown-toggle" href="index.php?controller=Settings&method=index" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php print($account->getAccountName()); ?> </a>
        
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="index.php?controller=Profile&method=index">Profile</a>
          <a class="dropdown-item" href="index.php?controller=Settings&method=index">Settings</a>
          <a class="dropdown-item" href="index.php?controller=ChangePassword&method=index">Change password</a>
          <?php if($account->getAdmin() == 1){ ?>
            <a class="dropdown-item" href="index.php?controller=AddAdminAccount&method=index">New admin account</a>
          <?php } ?>          
          <a class="dropdown-item" href="index.php?controller=Schedule&method=logout">Log out</a>
        </div>
      </li>
      <?php } ?>
    </ul>
  </div>
</nav>

<div class="container">
    <?php foreach($tickets as $ticket){ ?>
        <div class="card shadow my-3" data-aos="fade-down" data-aos-delay="600">
            <div class="card-header d-flex justify-content-center">
                <?php print($ticket->start. " - ".  $ticket->stop); ?>
            </div>

            <?php
                $destination = StopsLine::getStopInfo($ticket->destination);
                $departure = StopsLine::getStopInfo($ticket->departure);
            ?>

            <div class="card-body">
                <p class="form-control">Bought by: <?php print($ticket->accountName); ?></p>
                <p class="form-control">Departure: <?php print($departure->name); ?></p>
                <p class="form-control">Destination: <?php print($destination->name); ?></p>
                <p class="form-control">Start time: <?php print($ticket->startTime); ?></p>
                <p class="form-control">Stop time: <?php print($ticket->stopTime); ?></p>
                <p class="form-control">Bought on: <?php print($ticket->purchased); ?></p>
                <p class="form-control">Valid until: <?php print($ticket->validDate); ?></p>

            </div>
        </div>
    <?php } ?>
</div>