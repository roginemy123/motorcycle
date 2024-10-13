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

    require __DIR__ . '../../../functions/Admin.php';

    $appointments = getAllAppointments();
    

?>

<div class="container-fluid">
    <div class="row">

        <?php require __DIR__ . '/partials/sidebar.php' ?>

        <div class="col-lg-10 p-4">
            
              <div class="card">
                <div class="card-header d-flex gap-2 align-items-center bg-transparent">
                    <h5><i class="fa fa-clock"></i> Appointments(<?= $appointments->num_rows ?>)</h5>
                </div>

                <div class="card-body">

                    <table id="table">
                        <thead>
                            <th class="text-start">Ref. #</th>
                            <th class="text-start">Name</th>
                            <th class="text-start">Owner</th>
                            <th class="text-start">Date</th>
                            <th class="text-start">Time</th>
                            <th class="text-start">Status</th>
                        </thead>
                        <tbody>
                            <?php 

                            if($appointments->num_rows > 0){
                                foreach($appointments as $appointment){
                                ?>
                                        <tr>
                                            <td class="text-start"><?= clean($appointment['ref_num']) ?></td>
                                            <td class="text-start"><?= clean($appointment['fname']) . ' ' . clean($appointment['lname']) ?></td>
                                            <td class="text-start"><?= getShopById(clean($appointment['shop_id']))->name ?></td>
                                            <td class="text-start"><?= clean(date("M d,Y", strtotime($appointment['date']))) ?></td>
                                            <td class="text-start"><?= clean(date("h:i:s A", strtotime($appointment['time']))) ?></td>
                                            <td class="text-start"><?= appointmentStatus(clean($appointment['status'])) ?></td>
                                        </tr>
                                <?php   
                                }
                            }
                            
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>
</div>