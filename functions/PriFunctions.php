<?php 

function alertDefault($data){
    $data = json_encode($data);
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            let data = <?= $data ?>

            if (data[0] == '') {
                Swal.fire({
                    position: data[1],
                    icon: data[2],
                    title: data[3],
                    showConfirmButton: false,
                    timer: data[4]
                });
            }else{
                Swal.fire({
                    position: data[1],
                    icon: data[2],
                    title: data[3],
                    showConfirmButton: false,
                    timer: data[4]
                }).then(() => {
                    window.location.href = data[0]
                });
            }

        })
    </script>
    <?php 
}

function clean($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function postRequest($request){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST[$request])){
            return true;
        }
    }
}

function activateSession($data) {
    $_SESSION['USER_ID'] = clean($data['id']);
    $_SESSION['USER_NAME'] = clean($data['name']);
    $_SESSION['USERNAME'] = clean($data['username']);
    $_SESSION['EMAIL_ID'] = clean($data['email']);
    $_SESSION['AUTHENTICATED'] = true;
    $_SESSION['SESSION_ID'] = clean($data['session_id']);
    $_SESSION['USER_TYPE'] = clean($data['type']);
}

function isUserActive(){
    if(isset($_SESSION['USER_ID'])){
        $conn = conn();
        $user_id = clean($_SESSION['USER_ID']);
        $session_id = clean($_SESSION['SESSION_ID']);

        $stmt = $conn->prepare("SELECT id,session_id FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                if($session_id === $row['session_id']){
                    return true;
                }

            }else{
                return false;
            }

        }else{
            return false;
        }

    }else{
        return false;
    }
}

function generateSessionId($id){
    $conn = conn();
    $user_id = clean($id);
    $session_id = uniqid(rand(.1, 999999999));
    $stmt = $conn->prepare("UPDATE users SET session_id = ? WHERE id = ?");
    $stmt->bind_param("si", $session_id, $user_id);
    if($stmt->execute()){
        return true;
    }
}

function sessionData(){
    $conn = conn();
    $user_id = clean($_SESSION['USER_ID']);
    $stmt = $conn->prepare("SELECT name, email, DATE(created_at) as created, DATE(updated_at) as updated FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if($stmt->execute()){
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_object();
            return $row;
        }

    }
}

function getShopById($id){
    $conn = conn();

    $stmt = $conn->prepare("SELECT * FROM shops WHERE id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_object();
            return $row;
        }
    }

}

function appointmentStatus($status){
    if($status == 1){
        return '<span class="badge bg-warning">Pending</span>';
    }else if($status == 2){
        return '<span class="badge bg-primary">Appointed</span>';
    }else if($status == 3){
        return '<span class="badge bg-success">Finished</span>';
    }
}

function getAllAppointments(){
    $conn = conn();
    $stmt = $conn->prepare("SELECT *, DATE(created_at) as created, DATE(updated_at) as updated FROM appointments");
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }
}

function getAllShops(){
    $conn = conn();
    $stmt = $conn->prepare("SELECT *, DATE(created_at) as created, DATE(updated_at) as updated FROM shops");
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }
}

function getAllOwners(){
    $conn = conn();
    $type = 2;
    $stmt = $conn->prepare("SELECT * FROM users WHERE type = ?");
    $stmt->bind_param("i", $type);
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }
}

function getAppointmentByShop($id){
    $conn = conn();
    $shop_id = clean($id);
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE shop_id = ?");
    $stmt->bind_param("i", $shop_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }
}

function getAppointmentByTech($id){
    $conn = conn();
    $tech_id = clean($id);
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE tech_id = ?");
    $stmt->bind_param("i", $tech_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }
}

function getOwnerById($id){
    $conn = conn();
    $user_id = clean($id);
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_object();

            return $row;
        }
       
    }
}

function appointmentStatusBtn($status, $id){
    $conn = conn();
    $appoint_id = clean($id);
    $appoint_stat = clean($status);

    if($appoint_stat == 2){
        ?>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#finish-<?= $appoint_id ?>">Finish</button>
        <?php 
    }else if($appoint_stat == 1){
        ?>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#appoint-<?= $appoint_id ?>">Appoint</button>
        <?php 
    }
    
}

function getAppointmentsByShopOwner(){
    $conn = conn();
    $owner_id = clean($_SESSION['USER_ID']);
    
    $stmt = $conn->prepare("SELECT *, a.status, a.tech_id, a.id as APPOINT_ID FROM appointments a INNER JOIN shops s ON a.id = s.id INNER JOIN users u ON s.owner_id = u.id WHERE s.owner_id = ?");
    $stmt->bind_param("i", $owner_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }
}

function getTechnicianByShopOwner(){
    $conn = conn();
    $owner_id = clean($_SESSION['USER_ID']);
    
    $stmt = $conn->prepare("SELECT *,t.id, s.name as SHOP_NAME, u.name as TECH_NAME,DATE(t.created_at) as created,DATE(t.updated_at) as updated FROM technicians t INNER JOIN shops s ON t.shop_id = s.id INNER JOIN users u ON t.tech_id = u.id WHERE s.owner_id = ?");
    $stmt->bind_param("i", $owner_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }
}

function getShopByOwner(){
    $conn = conn();
    $owner_id = clean($_SESSION["USER_ID"]);

    $stmt = $conn->prepare("SELECT * FROM shops WHERE owner_id = ?");
    $stmt->bind_param("i", $owner_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }
}

function getTechnicianById($id){
    $conn = conn();
    $tech_id = clean($id);

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $tech_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_object();
            return $row;
        }
       
    }
}

function getRegisteredTechnician(){
    $conn = conn();
    $type = 3;
    $stmt = $conn->prepare("SELECT id,name FROM users WHERE type = ?");
    $stmt->bind_param("i", $type);
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }
}

function userNotification(){
    $conn = conn();
    $user_id = clean($_SESSION['USER_ID']);
    $today = date('Y-m-d');

    $stmt = $conn->prepare("SELECT * FROM appointments WHERE user_id = ? AND DATE(updated_at) = ?");
    $stmt->bind_param("is", $user_id, $today);
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }

}

function logout(){
    session_destroy();
    alertDefault([
        '?page=home',
        'middle',
        'success',
        'Account signed out successfully',
        '1500'
    ]);
}