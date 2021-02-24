<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Lets Spin</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script> -->

        <!-- Latest compiled and minified JavaScript -->
    </head>
    <body style="height: 100vh;">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-6 h-100 align-items-center">
                    <form method="post" class="d-flex flex-column" action="<?php echo site_url('login'); ?>">
                        <label>Username: <input type="text" name="username" placehoder="Your Email Address"></label><br/>
                        <label>Password: <input type="password" name="passswor" placehoder="Your Password"></label><br/>
                        <?php if (isset($error_message)) { ?>
                            <?php echo $error_message . "<br/>"; ?>
                        <?php } ?>
                        <input type="submit" class="btn btn-primary w-50" value="login">
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
