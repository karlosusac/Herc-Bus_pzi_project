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
        <a class="nav-link dropdown-toggle" href="index.php?controller=Profile&method=index" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php print($account->getAccountName()); ?> </a>
        
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="index.php?controller=Profile&method=index">Profile</a>
          <a class="dropdown-item" href="index.php?controller=Settings&method=index">Settings</a>
          <a class="dropdown-item" href="index.php?controller=Schedule&method=logout">Log out</a>
        </div>
      </li>
      <?php } ?>
    </ul>
  </div>
</nav>
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header d-flex justify-content-center bg-dark">
    <h1 class="text-light" type="name" name="chngUserName" >Welcome to your profile <?php print($account->getAccountName()); ?>!</h1>
    </div>
    <div class="card-body">
      <?php if(isset($_GET["error"])){ ?>
        <div class="alert alert-danger text-center">
          <strong>Error:</strong>
          <p><?php print($_GET["error"]); ?></p>
        </div>
      <?php } else if(isset($_GET["success"])){ ?>
        <div class="alert alert-success text-center">
           <strong>Success:</strong>
          <p><?php print($_GET["success"]); ?></p>
        </div>

      <?php } ?>
<div class="card-body">
  <h1 class="form-control">Name: <?php print($account->getName()); ?></h1>
  <h1 class="form-control">Last name: <?php print($account->getlastname()); ?></h1>
  <h1 class="form-control">E-mail address: <?php print($account->getEmail()); ?></h1>
  <h1 class="form-control">Phone Number: <?php print($account->getPhoneNumber()); ?></h1>
  <div class="float-right my-3">
    <a href="index.php?controller=Settings&method=index"><button class="btn btn-outline-primary">Change</button></a>
  </div>
</div>


          
      
    </div>
  </div>
</div>


<script src="asts/javaScript/registerPasswordValidation.js">





