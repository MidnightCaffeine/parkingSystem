<?php
require_once 'lib/php/database_handler/connection.php';
session_start();
$_SESSION['page'] = 'Login';
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once 'assets/components/head.php';
    ?>
    <script type="text/javascript" src="lib/js/authentication.js"></script>
</head>

<body>
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4"> <a href="index.html"
                                    class="logo d-flex align-items-center w-auto"> <img src="assets/img/logo.png"
                                        alt=""> <span class="d-none d-lg-block">Parking System</span> </a></div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>
                                    <form class="row g-3 needs-validation" id="login_form" novalidate>
                                        <p class="login-message"></p>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="email" class="form-control" id="email"
                                                    required>
                                                <div class="invalid-feedback">Please enter your email.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label> <input
                                                type="password" name="password" class="form-control" id="password"
                                                required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>
                                        <!-- <div class="col-12">
                                            <div class="form-check"> <input class="form-check-input" type="checkbox"
                                                    name="remember" value="true" id="rememberMe"> <label
                                                    class="form-check-label" for="rememberMe">Remember me</label></div>
                                        </div> -->
                                        <div class="col-12"> <button id="login_button" class="btn btn-primary w-100"
                                                type="submit">Login</button></div>
                                        <div class="col-12">
                                            <p class="small mb-0">
                                                <a data-target="#forgot_password" data-bs-toggle="modal"
                                                    href="#forgot_password">Forgot
                                                    password?</a>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">
                                                Don't have account?
                                                <a data-target="#register_form" data-bs-toggle="modal"
                                                    href="#register_form">Create an account</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php
    include_once 'assets/components/main_scripts.php';
    ?>


    <div class="modal fade" id="register_form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="register_formLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="register_formLabel">Sign-Up</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registration_form" action="lib/php/authentication/register.php" method="post">
                        <p id="message"></p>
                        <div class="row g-2">
                            <p class="form-message"></p>
                            <div class="col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="register_firstname"
                                        name="register_firstname" placeholder="Firstname">
                                    <label for="register_firstname">Firstname</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="register_lastname"
                                        name="register_lastname" placeholder="Lastname">
                                    <label for="register_lastname">Lastname</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="register_middlename" name="register_middlename"
                                placeholder="Middlename">
                            <label for="register_middlename">Middlename</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="register_email" name="register_email"
                                autocomplete="false" placeholder="name@example.com">
                            <label for="register_email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="department" name="department">
                                <option value="1">BSIT</option>
                                <option value="2">Education</option>
                                <option value="3">Engineering</option>
                                <option value="4">Law</option>
                            </select>
                            <label for="department">Department</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="year_group" name="year_group">
                                <option value="1">Freshman (1st year)</option>
                                <option value="2">Sophomore (2nd year)</option>
                                <option value="3">Junior (3rd year)</option>
                                <option value="4">Senior (4th year)</option>
                            </select>
                            <label for="year_group">Year Group</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="section" name="section">
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">C</option>
                                <option value="4">D</option>
                                <option value="5">E</option>
                                <option value="6">F</option>
                                <option value="7">G</option>
                                <option value="8">H</option>
                                <option value="9">I</option>
                            </select>
                            <label for="section">Section</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="mv_file" name="mv_file" placeholder="password">
                            <label for="mv_file">MV File / Plate Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="body_number" name="body_number"
                                placeholder="password">
                            <label for="body_number">Body Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="vehicle_type" name="vehicle_type">
                                <option value="1">Car</option>
                                <option value="2">Tricycle</option>
                                <option value="3">Motor</option>
                            </select>
                            <label for="vehicle_type">Vehicle Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="register_password" name="register_password"
                                placeholder="password">
                            <label for="register_password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="password">
                            <label for="confirm_password">Confirm Password</label>
                        </div>
                        <div class="col-md-12 text-center block">
                            <button type="submit" name="signUp" id="signUp"
                                class="btn btn-primary w-100">Sign-Up</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


</body>

</html>