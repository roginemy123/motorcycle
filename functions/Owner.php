<?php 

    function appointTechnician(){
        $conn = conn();
        $appoint_id = clean($_POST['appoint_id']);
        $tech_id = clean($_POST['tech_id']);
        $status = 2;

        $stmt = $conn->prepare("UPDATE appointments SET status = ?, tech_id = ? WHERE id = ? ");
        $stmt->bind_param("iii", $status, $tech_id, $appoint_id);

        if($stmt->execute()){
            alertDefault([
                '?auth=2&page=appointments',
                'middle',
                'success',
                'Technician appointed',
                '1500'
            ]);
        }

    }

    function addTechnician(){
        $conn = conn();
        $shop_id = clean($_POST['shop_id']);
        $tech_id = clean($_POST['tech_id']);
        $status = 2;

        $stmt = $conn->prepare("INSERT INTO technicians(tech_id, shop_id) VALUES(?,?)");
        $stmt->bind_param("ii", $tech_id, $shop_id);

        if(empty($shop_id) || empty($tech_id)){
            alertDefault([
                '',
                'top-end',
                'error',
                'All fields are required',
                '1500'
            ]);
        }else{
            if($stmt->execute()){
                alertDefault([
                    '?auth=2&page=technicians',
                    'middle',
                    'success',
                    'Technician successfully added',
                    '1500'
                ]);
            }
        }

    }

    function removeTechnician(){
        $conn = conn();
        $id = clean($_POST['id']);

        $remove = $conn->prepare("DELETE FROM technicians WHERE id = ?");
        $remove->bind_param("i", $id);

        if($remove->execute()){
            alertDefault([
                '?auth=2&page=technicians',
                'middle',
                'success',
                'Technician successfully removed',
                '1500'
            ]);
        }

    }

    function updateTechnician(){
        $conn = conn();
        $shop_id = clean($_POST['shop_id']);
        $tech_id = clean($_POST['tech_id']);
        $id = clean($_POST['id']);

        $stmt = $conn->prepare("UPDATE technicians SET tech_id = ?, shop_id = ? WHERE id = ?");
        $stmt->bind_param("iii", $tech_id, $shop_id, $id);

        if(empty($shop_id) || empty($tech_id)){
            alertDefault([
                '',
                'top-end',
                'error',
                'All fields are required',
                '1500'
            ]);
        }else{
            if($stmt->execute()){
                alertDefault([
                    '?auth=2&page=technicians',
                    'middle',
                    'success',
                    'Technician successfully updated',
                    '1500'
                ]);
            }
        }

    }