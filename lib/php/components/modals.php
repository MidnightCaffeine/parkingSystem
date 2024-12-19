<div class="modal fade" id="user_form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="user" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title">User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <?php
                if ($_SESSION['user_type'] == 'Administrator') {
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="edit_info">
                        <label class="form-check-label" for="edit_info">
                            Edit Information
                        </label>
                    </div>
                    <?php
                }
                ?>


                <div id="view_info" class="mt-2">
                    <h5>Name: <span id="name"></span> </h5>
                    <h5>Year and Section: <span id="year_section"></span> </h5>
                    <h5>Department: <span id="dept"></span> </h5>
                    <h5>Vehicle Type: <span id="vehicle"></span> </h5>
                    <h5>Plate Number: <span id="plate_num"></span> </h5>
                    <h5>Body Number: <span id="body_num"></span> </h5>
                </div>
                <div id="edit_form">
                    <form id="registration_form" action="" method="post">
                        <p id="message"></p>
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        placeholder="Firstname">
                                    <label for="firstname">Firstname</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="Lastname">
                                    <label for="lastname">Lastname</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="middlename" name="middlename"
                                placeholder="Middlename">
                            <label for="middlename">Middlename</label>
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
                        <input type="text" class="form-control" id="user_id" name="user_id" hidden>
                        <div class="col-md-12 text-center block">
                            <button type="submit" name="edit_info" id="edit_info" class="btn btn-primary w-100">Save
                                Changes</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="motorcycle_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="user" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title">Edit Motorcycle Slots</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="edit_form">
                    <form id="motorcycle_form" action="" method="post">
                        <p id="message"></p>
                        <h3 id="description"></h3>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="motorcycle_slot" name="motorcycle_slot"
                                placeholder="Motorcycle Slot">
                            <label for="motorcycle_slot">Motorcycle Slot</label>
                        </div>
                        <input type="text" class="form-control" id="motorcycle_slot_id" name="motorcycle_slot_id"
                            hidden>
                        <div class="col-md-12 text-center block">
                            <button type="submit" name="edit_info" id="edit_info" class="btn btn-primary w-100">Save
                                Changes</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="tricycle_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="user" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title">Edit Tricycle Slots</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="edit_form">
                    <form id="tricycle_form" action="" method="post">
                        <p id="message"></p>
                        <h3 id="tricycle_description"></h3>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="tricycle_slot" name="tricycle_slot"
                                placeholder="tricycle Slot">
                            <label for="tricycle_slot">Tricycle Slot</label>
                        </div>
                        <input type="text" class="form-control" id="tricycle_slot_id" name="tricycle_slot_id" hidden>
                        <div class="col-md-12 text-center block">
                            <button type="submit" name="edit_info" id="edit_info" class="btn btn-primary w-100">Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="car_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="user" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title">Edit Car Slots</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="edit_form">
                    <form id="car_form" action="" method="post">
                        <p id="message"></p>
                        <h3 id="car_description"></h3>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="car_slot" name="car_slot"
                                placeholder="car Slot">
                            <label for="car_slot">Car Slot</label>
                        </div>
                        <input type="text" class="form-control" id="car_slot_id" name="car_slot_id" hidden>
                        <div class="col-md-12 text-center block">
                            <button type="submit" name="edit_info" id="edit_info" class="btn btn-primary w-100">Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_vehicle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="user" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title">Add Vehicle</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="add_vehicle_div">
                    <form id="add_vehicle_form" action="" method="post">
                        <p id="message"></p>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="add_vehicle_type" name="add_vehicle_type">
                                <option value="1">Car</option>
                                <option value="2">Tricycle</option>
                                <option value="3">Motor</option>
                            </select>
                            <label for="add_vehicle_type">Vehicle Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="add_mv_file" name="add_mv_file" placeholder="password" required>
                            <label for="add_mv_file">MV File / Plate Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="add_body_number" name="add_body_number"
                                placeholder="password" required>
                            <label for="add_body_number">Body Number</label>
                        </div>
                        <div class="col-md-12 text-center block">
                            <button type="submit" name="add_vehicle_btn" id="add_vehicle_btn"
                                class="btn btn-primary w-100">Add Vehicle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="forgot_password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="forgot_passwordLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="forgot_passwordLabel">Forgot Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="forgot_pass" action="lib/php/database_handler/forgot_password.php" method="post">
                    <p id="message"></p>
                    <p id="sending"></p>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="forget_email" name="forget_email"
                            placeholder="Registered Email">
                        <label for="forget_email">Registered Email</label>
                    </div>
                    <div class="col-md-12 text-center block">
                        <button type="submit" name="send_otp" id="send_otp" class="btn btn-primary w-100">Send One
                            Time Pin</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="verify" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="verifyLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="verifyLabel">Forgot Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="card p-4 shadow-lg">
                        <h4 class="text-center mb-4">Enter OTP</h4>
                        <form id="otpForm">
                            <div class="d-flex justify-content-center mb-3">
                                <input type="text" id="otp1" class="form-control otp-input" maxlength="1" required>
                                <input type="text" id="otp2" class="form-control otp-input" maxlength="1" required>
                                <input type="text" id="otp3" class="form-control otp-input" maxlength="1" required>
                                <input type="text" id="otp4" class="form-control otp-input" maxlength="1" required>
                                <input type="text" id="otp5" class="form-control otp-input" maxlength="1" required>
                                <input type="text" id="otp6" class="form-control otp-input" maxlength="1" required>
                            </div>
                            <button type="submit" name="otp_verify" id="otp_verify" class="btn btn-primary w-100">Verify
                                OTP</button>
                        </form>
                        <p class="text-center mt-3">Didn't receive the code? <a href="#">Resend</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="password_change" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="password_changeLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="password_changeLabel">Forgot Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="change_pass">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="change_password" name="change_password"
                            placeholder="new password">
                        <label for="change_password">New Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="confirm_change" name="confirm_change"
                            placeholder="password">
                        <label for="confirm_change">Confirm Password</label>
                    </div>
                    <button type="submit" name="change" id="change" class="btn btn-primary w-100">Change
                        Password</button>
                </form>
            </div>

        </div>
    </div>
</div>