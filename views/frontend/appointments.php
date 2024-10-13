<?php 
    require __DIR__ . '../../../partials/header.php';
    require __DIR__ . '../../../partials/navbar.php';

    if(!isUserActive()){
        alertDefault([
            '?page=sign-in',
            'middle',
            'warning',
            'Please login first, proceeding to login....',
            '3000'
        ]);
    }
?>

<div class="container nh_con py-5">

    <div class="card">

        <div class="card-header">
            <h5>All Apointments</h5>
        </div>

        <div class="card-body">
            <table id="appointment-table">
                <thead>
                    <th>Ref. #</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Shop</th>
                    <th>Technician</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <?php 
                        if(isUserActive()){
                            $appointments = getUserAppointments();
                            if($appointments->num_rows > 0){
                                foreach($appointments as $appointment){
                                    $shop_name = clean(getShopById($appointment['shop_id'])->name);
                                    ?>

                                <tr>
                                    <td><?= clean($appointment['ref_num']) ?></td>
                                    <td><?= clean(date('F d,Y', strtotime($appointment['date']))) ?></td>
                                    <td><?= clean(date('h:i:s A', strtotime($appointment['time']))) ?></td>
                                    <td><?= $shop_name ?></td>
                                    <td><span class="badge bg-primary"><?= $appointment['tech_id'] != NULL ? clean(getTechnicianById($appointment['tech_id'])->name) : 'Not Set' ?></span></td>
                                    <td><?= appointmentStatus($appointment['status']) ?></td>
                                </tr>

                                    <?php
                                }

                            }
                        }
                    ?>

                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        new DataTable('#appointment-table');
    })
</script>