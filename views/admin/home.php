<?php 

    if(!isUserActive() || clean($_SESSION['USER_TYPE']) != 1){
        alertDefault([
            '?page=sign-in',
            'middle',
            'warning',
            'Please login first, proceeding to login....',
            '3000'
        ]);
    }

?>

<div class="container-fluid">
    <div class="row">

        <?php require __DIR__ . '/partials/sidebar.php' ?>

        <div class="col-lg-10 p-4">
            
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 >Appointments</h3>
                            <h1><i class="fa fa-clock"></i> <span class="fw-lighter"></span> <?= getAllAppointments()->num_rows ?></h1>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 >Shops</h3>
                            <h1><i class="fa fa-shop"></i> <span class="fw-lighter"></span> <?= getAllShops()->num_rows ?></h1>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>