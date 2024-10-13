<?php 
    require __DIR__ . '../../../functions/Technician.php';

    if(!isUserActive() || clean($_SESSION['USER_TYPE']) != 3){
        alertDefault([
            '?page=sign-in',
            'middle',
            'warning',
            'Please login first, proceeding to login....',
            '3000'
        ]);
    }

    $appointments = getAppointmentByTech($_SESSION['USER_ID']);
?>

<div class="container-fluid">
    <div class="row">

        <?php require __DIR__ . '/partials/sidebar.php' ?>

        <div class="col-lg-10 p-4">
            
            <div class="row">

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <h5>Assigned Appointments</h5>
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
                                <th class="text-start">Action</th>
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
                                                <td>
                                                    <?php appointmentStatusBtn($appointment['status'], $appointment['id']) ?>

                                                     <!-- FINISH JOB -->
                                                <div class="modal" id="finish-<?= $appointment['id'] ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5>Appointment Finished</h5>
                                                                </div>

                                                                <form method="post" class="modal-body text-center">
                                                                    <input type="hidden" name="appoint_id" value="<?= clean($appointment['id']) ?>">
                                                                
                                                                    <h4>Are you sure?</h4>
                                                                    <p>Is this appointment " <span class="fw-bold"><?= clean($appointment['ref_num']) ?></span> " done?</p>

                                                                    <button type="submit" name="update" class="btn btn-danger">Confirm</button>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    

                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </td>

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

    </div>
</div>

<?php 
    $postRequest = postRequest('update');
    if($postRequest){
        setAppointmentFinish();
    }
?>