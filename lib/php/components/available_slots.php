<?php
if ((isset($_SESSION['vehicle_type']) && $_SESSION['vehicle_type'] == 'Motorcycle') || isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Guard') {
    ?>
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Motorcycle</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ri-motorbike-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="motorcycle_slot_text"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php
if ((isset($_SESSION['vehicle_type']) && $_SESSION['vehicle_type'] == 'Tricycle') || isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Guard') {
    ?>
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card revenue-card">
            <div class="card-body">
                <h5 class="card-title">Tricycle</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-minecart-loaded"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="tricycle_slot_text"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php
if ((isset($_SESSION['vehicle_type']) && $_SESSION['vehicle_type'] == 'Car') || isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Guard') {
    ?>
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card customers-card">
            <div class="card-body">
                <h5 class="card-title">Car</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class='bx bxs-car'></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="car_slot_text"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
