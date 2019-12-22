<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Log in</title>
</head>

<body>
    <main class="login-form mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Prijavite se</div>
                        <div class="card-body">
                            <?php if (isset($error)) { ?>
                            <div class="alert alert-danger">
                                <b>Nastala je pogreška:</b>
                                <p><?php print($error); ?></p>
                            </div>
                            <?php } ?>
                            <form action="index.php?controller=Login&method=index" method="POST">
                                <div class="form-group row">
                                    <label for="loginAccountName" class="col-md-4 col-form-label text-md-right">Username</label>
                                    <div class="col-md-6">
                                        <input type="text" id="loginAccountName" class="form-control" name="loginAccountName" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="loginPassword" class="col-md-4 col-form-label text-md-right">Lozinka</label>
                                    <div class="col-md-6">
                                        <input type="password" id="loginPassword" class="form-control" name="loginPassword" required>
                                    </div>
                                </div>

                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Log in
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>