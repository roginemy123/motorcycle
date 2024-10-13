<?php 
    require __DIR__ . '../../../functions/Owner.php';

    if(!isUserActive() || clean($_SESSION['USER_TYPE']) != 2){
        alertDefault([
            '?page=sign-in',
            'middle',
            'warning',
            'Please login first, proceeding to login....',
            '3000'
        ]);
    }



    $appointments = getAppointmentsByShopOwner();
    

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
                            <th class="text-start">Technician</th>
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
                                <td class="text-start">
                                    <?= clean($appointment['fname']) . ' ' . clean($appointment['lname']) ?></td>
                                <td class="text-start"><?= getShopById(clean($appointment['shop_id']))->name ?></td>
                                <td class="text-start"><?= clean(date("M d,Y", strtotime($appointment['date']))) ?></td>
                                <td class="text-start"><?= clean(date("h:i:s A", strtotime($appointment['time']))) ?>
                                </td>
                                <td>
                                    <?= $appointment['tech_id'] != NULL ? getTechnicianById($appointment['tech_id'])->name : 'Not Set' ?>
                                </td>
                                <td class="text-start"><?= appointmentStatus(clean($appointment['status'])) ?></td>
                                <td class="dropdown">
                                    <button type="button" class="btn btn-danger dropdown-toggle"
                                        data-bs-toggle="dropdown">Update Status</button>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-item">
                                            <a href="javascript:void(0);" class="text-dark text-decoration-none"
                                                data-bs-toggle="modal"
                                                data-bs-target="#decline-<?= clean($appointment['id']) ?>"><i
                                                    class="fa fa-xmark text-danger"></i> Decline</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="javascript:void(0);" class="text-dark text-decoration-none"
                                                data-bs-toggle="modal"
                                                data-bs-target="#appoint-<?= clean($appointment['id']) ?>"><i
                                                    class="fa fa-arrow-rotate-right"></i> Appoint To</a>
                                        </li>
                                    </ul>

                                    <!-- APPOINT TO TECHNICIAN -->
                                    <div class="modal" id="appoint-<?= clean($appointment['id']) ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>Appoint to Technician</h5>
                                            </div>

                                            <form method="post" class="modal-body">
                                                <input type="hidden" name="appoint_id" value="<?= clean($appointment['APPOINT_ID']) ?>">

                                                <label for="technician">Technician</label>
                                                <select name="tech_id" class="form-select my-2" required>
                                                    <option value="" disabled selected>Select Technician</option>
                                                    <?php
                                                   $technicians = getTechnicianByShopOwner(); 
                                                    if($technicians->num_rows > 0){
                                                        foreach($technicians as $technician){
                                                            ?>
                                                                <option value="<?= $technician['id'] ?>"><?= $technician['name'] ?></option>
                                                            <?php 
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                                <button type="submit" name="appoint"
                                                    class="btn btn-danger">Confirm</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>

                                            </form>

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

<?php 
    $postRequest = postRequest('appoint');
    if($postRequest){
        appointTechnician();
    }
?>