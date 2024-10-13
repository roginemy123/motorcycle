<?php
require __DIR__ . '/DBConn.php';
require __DIR__ . '/PriFunctions.php';

// MODELS
function getShops()
{
    $conn   = conn();
    $status = 1;

    $stmt = $conn->prepare("SELECT * FROM shops WHERE status = ?");
    $stmt->bind_param("i", $status);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result;
    }
}

// VALIDATIONS

function isDateAndTimeExistAppointment($date, $time)
{
    $conn = conn();
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE date = ? AND time = ?");
    $stmt->bind_param("ss", $date, $time);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
    }
}

function isAppointmentUserExist($id, $date_today)
{
    $conn = conn();

    $stmt = $conn->prepare("SELECT * FROM appointments WHERE user_id = ? AND DATE(created_at) = ?");
    $stmt->bind_param("is", $id, $date_today);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
    }

}

function isAccountExist($username){
    $conn = conn();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return true;
        }
    }

}

// CONTROLLERS
function setAppointment()
{
    $conn         = conn();
    $user_id      = clean($_SESSION['USER_ID']);
    $date_today   = date("Y-m-d");
    $fname        = clean($_POST['fname']);
    $lname        = clean($_POST['lname']);
    $birthdate    = clean($_POST['birthdate']);
    $gender       = clean($_POST['gender']);
    $phone_number = clean($_POST['phone_number']);
    $street       = clean($_POST['street']);
    $city         = clean($_POST['city']);
    $to_repair    = clean($_POST['to_repair']);
    $shop_id      = clean($_POST['shop_id']);
    $date         = clean($_POST['date']);
    $time         = clean($_POST['time']);
    $ref_num      = uniqid(rand(99, 99999999));
 
    $stmt = $conn->prepare("INSERT INTO appointments(fname, lname, birthdate, gender, phone_number, street, city, to_repair, shop_id, date, time,user_id,ref_num) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssissis", $fname, $lname, $birthdate, $gender, $phone_number, $street, $city, $to_repair, $shop_id, $date, $time, $user_id,$ref_num);

    if (isAppointmentUserExist($user_id, $date_today)) {
        alertDefault([
            '?page=my-appointments',
            'middle',
            'error',
            'You already have an apointment today, please appoint again tomorrow',
            '3000',
        ]);
    } else if (isDateAndTimeExistAppointment($date, $time)) {
        alertDefault([
            '?page=set-an-appointment',
            'middle',
            'error',
            'Someone already appointed to the date and time you appoint',
            '3000',
        ]);
    } else {

        if ($stmt->execute()) {

            alertDefault([
                '?page=my-appointments',
                'middle',
                'success',
                'Appointment Set, please check your email we sent confirmation of your appointment',
                '3500',
            ]);
        }
    }

}

function registerAccount(){
    $conn = conn();
    $name = clean($_POST['name']);
    $username = clean($_POST['username']);
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);
    $confirm = clean($_POST['confirm']);

    if(empty($name) || empty($username) || empty($email) || empty($password) || empty($confirm)){
        alertDefault([
            '',
            'top-end',
            'error',
            'All fields required',
            '2500'
        ]);
    }else if(strlen($username) < 6){
        alertDefault([
            '',
            'top-end',
            'warning',
            'Username too short',
            '2500'
        ]);
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        alertDefault([
            '',
            'top-end',
            'warning',
            'Invalid email format',
            '3000'
        ]);
    }else if(strlen($password) < 8){
        alertDefault([
            '',
            'top-end',
            'warning',
            'Password too short',
            '2500'
        ]);
    }else if($password !== $confirm){
        alertDefault([
            '',
            'top-end',
            'warning',
            'Password don\'t match',
            '2500'
        ]);
    }else if(isAccountExist($username)){
        alertDefault([
            '',
            'top-end',
            'warning',
            'Account already exist',
            '2500'
        ]);
    }else{
        $hashed = password_hash($password, PASSWORD_DEFAULT); 
       $stmt = $conn->prepare("INSERT INTO users(name, username, email, password) VALUES(?,?,?,?)");
       $stmt->bind_param("ssss", $name, $username, $email, $hashed);
       if($stmt->execute()){
            alertDefault([
                '?page=sign-in',
                'middle',
                'success',
                'Registration success',
                '2500'
            ]);
       } 

    }

}

function loginAccount(){
    $conn = conn();
    $username = clean($_POST['username']);
    $password = clean($_POST['password']);

    if(empty($username) || empty($password)){
        alertDefault([
            '',
            'top-end',
            'error',
            'All fields required',
            '2500'
        ]);
    }else{
        $stmt = $conn->prepare("SELECT id,username, email, password, name, session_id, type FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                
                if(!password_verify($password, $row['password'])){
                    session_regenerate_id();
                    alertDefault([
                        '',
                        'top-end',
                        'error',
                        'Incorrect username or password',
                        '2500'
                    ]);
                }else{
                    if(generateSessionId($row['id'])){

                        $get_user_data = $conn->prepare("SELECT id,username, email, password, name, session_id, type FROM users WHERE id =?");
                        $get_user_data->bind_param("i", $row['id']);
                        if($get_user_data->execute()){
                            $result_get = $get_user_data->get_result();

                            if($result_get->num_rows > 0){
                                $user_data = $result_get->fetch_assoc();
                                activateSession($user_data);
                                $user_type = clean($row['type']);
                                $redirect = "?page=set-an-appointment";

                                if($user_type == 1){
                                    $redirect = "?auth=1&page=home";
                                }else if($user_type == 2){
                                    $redirect = "?auth=2&page=home";
                                }else if($user_type == 3){
                                    $redirect = "?auth=3&page=home";
                                }

                                alertDefault([
                                    $redirect,
                                    'middle',
                                    'success',
                                    'Account signed in, proceeding to appointment...',
                                    '3000'
                                ]); 
                            }

                        }
                    }
                }

            }else{
                session_regenerate_id();
                alertDefault([
                    '',
                    'top-end',
                    'error',
                    'Incorrect username or password',
                    '2500'
                ]);
            }

        }

    }

}

function getUserAppointments(){
    $conn = conn();
    $user_id = clean($_SESSION['USER_ID']);

    $stmt = $conn->prepare("SELECT * FROM appointments WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        return $result;
    }

}