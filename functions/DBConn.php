<?php 
    session_start();
    date_default_timezone_set('Asia/Manila');
    function conn(){
        $host = "localhost";
        $uname = "root";
        $password = "";
        $database = "motorcycle_repair_shop_db";

        $conn = new mysqli($host, $uname, $password, $database);

        if($conn->errno > 0){
            return "Connection error";
        }else{
            return $conn;
        }

    }
