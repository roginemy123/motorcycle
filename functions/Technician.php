<?php 

    function setAppointmentFinish(){
        $conn = conn();
        $appoint_id = clean($_POST['appoint_id']);
        $tech_id = clean($_SESSION['USER_ID']);
        $status = 3;

        $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE tech_id = ? AND id = ? ");
        $stmt->bind_param("iii", $status, $tech_id, $appoint_id);

        if($stmt->execute()){
            alertDefault([
                '?auth=3&page=home',
                'middle',
                'success',
                'Appointment Finished',
                '1500'
            ]);
        }

    }