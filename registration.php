<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <?php
    require('db.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $username) || $username == "") {
            echo "<div class='form'>
            <h3>Only letters and white space allowed and name cannot be empty.</h3><br/>
            <p class='link'>Click here to <a href='registration.php'>Register Again</a></p>
            </div>";
            return;
        }

        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $sql = "select * from users where (email='$email');";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($email == isset($row['email'])) {
                echo "<div class='form'>
                <h3>Email Already Exists.</h3><br/>
                <p class='link'>Click here to <a href='registration.php'>Register Again</a></p>
                </div>";
            }
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            echo "<div class='form'>
            <h3>Invalid Email.</h3><br/>
            <p class='link'>Click here to <a href='registration.php'>Register Again</a></p>
            </div>";
            return;
        }

        $pnumber = stripslashes($_REQUEST['pnumber']);
        $pnumber = mysqli_real_escape_string($con, $pnumber);

        $mobileregex = "/^[6-9][0-9]{9}$/";
        if (preg_match($mobileregex, $pnumber) != 1) {
            echo "<div class='form'>
            <h3>Ivalid phone number.</h3><br/>
            <p class='link'>Click here to <a href='registration.php'>Register Again</a></p>
            </div>";
            return;
        }

        $create_datetime = date("Y-m-d H:i:s");
        $query    = "INSERT into `users` (username, pnumber, email, create_datetime)
                     VALUES ('$username', '$pnumber', '$email', '$create_datetime')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    } else {
    ?>
        <!-- <form class="form" action="" method="post">
            <h1 class="login-title">Registration</h1>
            <input type="text" class="login-input" name="username" placeholder="Full Name" />
            <input type="text" class="login-input" name="email" placeholder="Email Adress">
            <input type="text" class="login-input" name="pnumber" placeholder="Phone Number">
            <input type="submit" name="submit" value="Register" class="login-button">
            <p class="link">Already have an account? <a href="login.php">Login here</a></p>
        </form> -->
        <section style="margin-top: 5%;" class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="./assets/draw2.webp" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form action="" method="post">
                            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                                <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                                <button type="button" class="btn btn-primary btn-floating mx-1">
                                    <i class="fa fa-facebook-f"></i>
                                </button>

                                <button type="button" class="btn btn-primary btn-floating mx-1">
                                    <i class="fa fa-twitter"></i>
                                </button>

                                <button type="button" class="btn btn-primary btn-floating mx-1">
                                    <i class="fa fa-linkedin"></i>
                                </button>
                            </div>

                            <div class="divider d-flex align-items-center my-4">
                                <p class="text-center fw-bold mx-3 mb-0">Or</p>
                            </div>

                            <!-- Full Name input -->
                            <div class="form-outline mb-4">
                                <input name="username" type="text" id="form3Example3" class="form-control form-control-lg" placeholder="Full Name" />

                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input name="email" type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address" />

                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <input name="pnumber" type="text" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" />
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Checkbox -->
                                <div class="form-check mb-0">
                                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                                    <label class="form-check-label" for="form2Example3">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
                                <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="login.php" class="link-danger">Login Here</a></p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
                <!-- Copyright -->
                <div class="text-white mb-3 mb-md-0">
                    Copyright © 2023. All rights reserved.
                </div>
                <!-- Copyright -->

                <!-- Right -->
                <div>
                    <a style="text-decoration: none;" href="#!" class="text-white me-4">
                        <i class="fa fa-facebook-f"></i>
                    </a>
                    <a style="text-decoration: none;" href="#!" class="text-white me-4">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a style="text-decoration: none;" href="#!" class="text-white me-4">
                        <i class="fa fa-google"></i>
                    </a>
                    <a style="text-decoration: none;" href="#!" class="text-white">
                        <i class="fa fa-linkedin-in"></i>
                    </a>
                </div>
                <!-- Right -->
            </div>
        </section>
    <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>