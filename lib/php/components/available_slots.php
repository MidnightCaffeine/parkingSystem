<?php
if (isset($_SESSION['vehicle_type']) && $_SESSION['vehicle_type'] == 'Motorcyle' || isset($_SESSION['user_type'])) {
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
                        <h6>145</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php
if (isset($_SESSION['vehicle_type']) && $_SESSION['vehicle_type'] == 'Tricycle' || isset($_SESSION['user_type'])) {
    ?>
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card revenue-card">
            <div class="card-body">
                <h5 class="card-title">Tricycle</span></h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-minecart-loaded"></i>
                    </div>
                    <div class="ps-3">
                        <h6>12</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php
if (isset($_SESSION['vehicle_type']) && $_SESSION['vehicle_type'] == 'Car' || isset($_SESSION['user_type'])) {
    ?>
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card customers-card">
            <div class="card-body">
                <h5 class="card-title">Car</span></h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class='bx bxs-car'></i>
                    </div>
                    <div class="ps-3">
                        <h6>64</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
