 <!DOCTYPE html>

 <html>

 <head>
     <title>Puutarhaliike Neilikka</title>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="styles.css" type="text/css">
     <script src="script.js"></script>
 </head>

 <body>
     <div class="header"> Puutarhaliike Neilikka</div>
     <div class="background">
         <div class="topnav" id="myTopnav">
             <a href=index.html>Etusivu</a>
             <div class="dropdown">
                 <button class="dropbtn">Tuotteet
                     <i class="fa fa-caret-down"></i>
                 </button>
                 <div class="dropdown-content">
                     <a href="sisäkasvit.html" target="_self">Sisäkasvit</a>
                     <a href="ulkokasvit.html" target="_self">Ulkokasvit</a>
                     <a href="tyokalut.html" target="_self">Työkalut</a>
                     <a href="kasvienhoito.html" target="_self">Kasvien hoito</a>
                 </div>
             </div>
             <a href="myymalat.html" target="_self">Mymäälät</a>
             <a href="tietoa.html" target="_self">Tietoa meistä</a>
             <a href="otayht.html" target="_self">Ota yhteyttä</a>
             <a href="register.php" target="_self" class="active">Kirjautuminen</a>
             <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
         </div>

         <?php

            $link = mysqli_connect("127.0.0.1", "root", "", "neilikka");
            if (!$link) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            // echo "Success: A proper connection to MySQL was made! ";
            // echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL . "<br>";



            // Include config file
            // require_once "otayht.php";

            // Define variables and initialize with empty values
            $username = $password = $confirm_password = $email = "";
            $username_err = $password_err = $confirm_password_err = $email_err = "";

            // Processing form data when form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // Validate username
                if (empty(trim($_POST["email"]))) {
                    $email_err = "Please enter a valid email address.";
                } else {
                    // Prepare a select statement
                    $sql = "SELECT id FROM users WHERE email = ?";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "s", $param_email);

                        // Set parameters
                        $param_email = trim($_POST["email"]);

                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            /* store result */
                            mysqli_stmt_store_result($stmt);

                            if (mysqli_stmt_num_rows($stmt) == 1) {
                                $email_err = "This email address is already taken.";
                            } else {
                                $email = trim($_POST["email"]);
                            }
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                    // Validate username
                    if (empty(trim($_POST["username"]))) {
                        $username_err = "Please enter a username.";
                    } else {
                        // Prepare a select statement
                        $sql = "SELECT id FROM users WHERE username = ?";

                        if ($stmt = mysqli_prepare($link, $sql)) {
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "s", $param_username);

                            // Set parameters
                            $param_username = trim($_POST["username"]);

                            // Attempt to execute the prepared statement
                            if (mysqli_stmt_execute($stmt)) {
                                /* store result */
                                mysqli_stmt_store_result($stmt);

                                if (mysqli_stmt_num_rows($stmt) == 1) {
                                    $username_err = "This username is already taken.";
                                } else {
                                    $username = trim($_POST["username"]);
                                }
                            } else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }

                            // Close statement
                            mysqli_stmt_close($stmt);
                        }
                    }

                    // Validate password
                    if (empty(trim($_POST["password"]))) {
                        $password_err = "Please enter a password.";
                    } elseif (strlen(trim($_POST["password"])) < 6) {
                        $password_err = "Password must have atleast 6 characters.";
                    } else {
                        $password = trim($_POST["password"]);
                    }

                    // Validate confirm password
                    if (empty(trim($_POST["confirm_password"]))) {
                        $confirm_password_err = "Please confirm password.";
                    } else {
                        $confirm_password = trim($_POST["confirm_password"]);
                        if (empty($password_err) && ($password != $confirm_password)) {
                            $confirm_password_err = "Password did not match.";
                        }
                    }

                    // Check input errors before inserting in database
                    if (empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

                        // Prepare an insert statement
                        $sql = "INSERT INTO users (email, username, password ) VALUES (?, ?, ?)";




                        if ($stmt = mysqli_prepare($link, $sql)) {
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_username, $param_password);

                            // Set parameters
                            $param_email = $email;
                            $param_username = $username;
                            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                            // Attempt to execute the prepared statement
                            if (mysqli_stmt_execute($stmt)) {
                                // Redirect to login page
                                header("location: login.php");
                            } else {
                                echo "Something went wrong. Please try again later.";
                            }

                            // Close statement
                            mysqli_stmt_close($stmt);
                        }
                    }

                    // Close connection
                    mysqli_close($link);
                }
            }
            ?>





         <!--login and reg form-->

         <fieldset>
             <h1>Register now</h1>
             <p>Please fill this form to create an account.</p>
             <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                 <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                     <label>Email</label>
                     <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                     <span class="help-block"><?php echo $email_err; ?></span>
                 </div>
                 <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                     <label>Username</label>
                     <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                     <span class="help-block"><?php echo $username_err; ?></span>
                 </div>
                 <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                     <label>Password</label>
                     <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                     <span class="help-block"><?php echo $password_err; ?></span>
                 </div>
                 <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                     <label>Confirm Password</label>
                     <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                     <span class="help-block"><?php echo $confirm_password_err; ?></span>
                 </div>
                 <div class="form-group">
                     <input type="submit" class="btn btn-primary" value="Submit">
                     <input type="reset" class="btn btn-default" value="Reset">
                 </div>
                 <p>Already have an account? <a href="login.php">Login here</a>.</p>
             </form>
         </fieldset>


         <footer>
             @Puutarhaliike Neilikka Finland Oy 2020
         </footer>

 </body>



 </html>