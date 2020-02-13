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
            <a class="nav-link" href="index.php?controller=Schedule&method=index">Schedule</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=BuyTicket&method?index">Buy a Ticket</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=Login&method=index">Log in</a>
        </li>
        </ul>
    </div>
</nav>

<main class="login-form mt-5" data-aos="fade-in">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header">Register an account</div>
                        <div class="card-body">
                            <?php if (isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <b>Error:</b>
                                    <p><?php echo $error; ?></p>
                                </div>
                            <?php } ?>
<<<<<<< HEAD
                            <form action="index.php?controller=register&metod=index" onsubmit="return validateForm(isPassOk)" method="POST">
=======
                            <form action="index.php?controller=Register&method=index" onsubmit="return validateForm(isPassOk)" method="POST">
>>>>>>> ad07c60e3a322647682401c87d6bfea4aae08345
                                <div class="form-group row">
                                    <label for="accountName" class="col-md-4 col-form-label text-md-right">Username:*</label>
                                    <div class="col-md-6">
                                        <input type="text" id="accountName" class="form-control" name="accountName" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name:*</label>
                                    <div class="col-md-6">
                                        <input type="text" id="name" class="form-control" name="name" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lastname" class="col-md-4 col-form-label text-md-right">Lastname:*</label>
                                    <div class="col-md-6">
                                        <input type="lastname" id="email" class="form-control" name="lastname" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email:*</label>
                                    <div class="col-md-6">
                                        <input type="email" id="email" class="form-control" name="email" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phoneNumber" class="col-md-4 col-form-label text-md-right">Phone Number:</label>
                                    <div class="col-md-6">
                                        <input type="tel" id="phoneNumber" class="form-control" name="phoneNumber">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password:*</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password" required onkeyup="isPassOk()">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="conPassword" class="col-md-4 col-form-label text-md-right">Confirm Password:*</label>
                                    <div class="col-md-6">
                                        <input type="password" id="conPassword" class="form-control" name="conPassword" required onkeyup="isPassOk()">
                                        <div class="invalid-feedback">Passwords do not match</div>
                                        <small class="text-muted">Whitespaces will not count in the password.</small><br>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                                <div class="form-group row">
                                    <p class="col-md-12 col-form-label text-md-left">Have an account? <a href="index.php?controller=Login&method=index">Log in</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><br><br>
    </main>
    <script src="asts/javaScript/registerPasswordValidation.js"></script>
