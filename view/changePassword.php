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
        <a class="nav-link dropdown-toggle" href="index.php?controller=ChangePassword&method=index" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php print($account->getAccountName()); ?></a>
        
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="index.php?controller=Profile&method=index">Profile</a>
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


<div class="container mt-5">
  <div class="card shadow" data-aos="fade-down" data-aos-easing="ease-in-out" data-aos-duration="500">
    <div class="card-header mb-3 d-flex justify-content-center bg-dark">
      <h3 class="text-light">Change Password</h3>
    </div>
    

    <div class="card-body">
      <form action="index.php?controller=ChangePassword&method=changeAccountPassword" method="POST" onsubmit="return validateForm(isPassOk)">
          <label class="d-flex justify-content-center text-muted">Enter new password: </label>
          <input class="form-control" type="password" name="password" required onkeyup="isPassOk()">

          <label class="d-flex justify-content-center text-muted">Confirm new password: </label>
          <input class="form-control" type="password" name="conPassword" required onkeyup="isPassOk()">
          
          <label class="d-flex justify-content-center text-muted">Enter your previous password: </label>
          <input class="form-control" type="password" name="oldPassword" required>
        
          <div class="container">
            <div class="float-right my-3">
              <a href="index.php?controller=Profile&method=index"><button type="submit" class="btn btn-outline-success">Change</button>
            </div>          
        </div>
      </form>
    <div>
    </div>
  </div>
</div>

<script src="asts/javaScript/registerPasswordValidation.js"></script>




