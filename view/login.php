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
            <a class="nav-link" href="#">Schedule</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Buy a Ticket</a>
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
                        <div class="card-header">Log in</div>
                        <div class="card-body">
                            <?php if (isset($error)){ ?>
                            <div class="alert alert-danger">
                                <strong>Error:</strong>
                                <p><?php print($error); ?></p>
                            </div>
                            <?php } ?>
                            <form action="index.php?controller=Login&method=index" method="POST">
                                <div class="form-group row">
                                    <label for="accountName" class="col-md-4 col-form-label text-md-right">Username</label>
                                    <div class="col-md-6">
                                        <input type="text" id="accountName" class="form-control" name="accountName" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password" required>
                                    </div>
                                </div>

                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Log in
                                    </button>
                                </div>

                                <div class="form-group row">
                                    <p class="col-md-12 col-form-label text-md-left">Don't have an account? <a href="index.php?controller=Register&method=index">Register</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
