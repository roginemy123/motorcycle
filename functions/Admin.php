<?php 

function isShopExist($name){
    $conn = conn();

    $stmt = $conn->prepare("SELECT * FROM shops WHERE name = ?");
    $stmt->bind_param('s', $name);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return true;
        }
    }
}

function createShop(){
    $conn = conn();
    $name = clean($_POST['name']);
    $street = clean($_POST['street']);
    $city = clean($_POST['city']);
    $owner_id = clean($_POST['owner_id']);

    $stmt = $conn->prepare("INSERT INTO shops(name, street, city, owner_id) VALUES(?,?,?,?)");
    $stmt->bind_param("sssi", $name, $street, $city, $owner_id);

    if(empty($name) || empty($street) || empty($city) || empty($owner_id)){
        alertDefault([
            '',
            'top-end',
            'warning',
            'All fields are required',
            '3000'
        ]);
    }else if(isShopExist($name)){
        alertDefault([
            '',
            'top-end',
            'error',
            'Shop Already exist',
            '3000'
        ]);
    }else{

        if($stmt->execute()){
            alertDefault([
                '?auth=1&page=shops',
                'middle',
                'success',
                'Shop created successfuly',
                '2500'
            ]);
        }

    }

}

function updateShop(){
    $conn = conn();
    $name = clean($_POST['name']);
    $street = clean($_POST['street']);
    $city = clean($_POST['city']);
    $owner_id = clean($_POST['owner_id']);
    $shop_id = clean($_POST['shop_id']);

    $stmt = $conn->prepare("UPDATE shops SET name= ?, street = ?, city = ?, owner_id = ? WHERE id = ?");
    $stmt->bind_param("sssii", $name, $street, $city, $owner_id, $shop_id);

    if(empty($name) || empty($street) || empty($city) || empty($owner_id)){
        alertDefault([
            '',
            'top-end',
            'warning',
            'All fields are required',
            '3000'
        ]);
    }else{

        if($stmt->execute()){
            alertDefault([
                '?auth=1&page=shops',
                'middle',
                'success',
                'Shop updated successfuly',
                '2500'
            ]);
        }

    }

}

function deleteShop(){
    $conn = conn();
    $shop_id = clean($_POST['shop_id']);

    $stmt = $conn->prepare("DELETE FROM shops WHERE id = ?");
    $stmt->bind_param("i", $shop_id);

        if($stmt->execute()){
            alertDefault([
                '?auth=1&page=shops',
                'middle',
                'success',
                'Shop removed successfuly',
                '2500'
            ]);
        }

}
