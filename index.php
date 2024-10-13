<?php 
    require __DIR__ . '/partials/head.php';

    $request = isset($_GET['page']) ? strtolower(clean($_GET['page'])) : 'home';
    $auth = isset($_GET['auth']) ? strtolower(clean($_GET['auth'])) : 'home';
    $viewPageUser = '/views/frontend/';

    if($request === 'logout'){
        logout();
    }else if($auth == 1){
        $viewPageAdmin = '/views/admin/';
        $page = $request . '.php';
        require __DIR__ . $viewPageAdmin . $page;

    }else if($auth == 2){
        $viewPage = '/views/owner/';
        $page = $request . '.php';
        require __DIR__ . $viewPage . $page;

    }else if($auth == 3){
        $viewPage = '/views/technician/';
        $page = $request . '.php';
        require __DIR__ . $viewPage . $page;

    }else if($request == 'home'){
        $page = $request . '.php';
        require __DIR__ . $viewPageUser . $page;
    } else if($request === 'set-an-appointment'){
        require __DIR__ . $viewPageUser . 'AppointmentForm.php';
    }else if($request === 'my-appointments'){
        require __DIR__ . $viewPageUser . 'appointments.php';
    }else if($request === 'sign-in'){
        require __DIR__ . '/login.php';
    }else if($request === 'sign-up'){
        require __DIR__ . '/register.php';
    }else{
        require __DIR__ . '/404.php';
    }

    if(!isset($auth)){
        require __DIR__ . '/partials/footer_top.php';
    }

   require __DIR__ . '/partials/footer_btm.php';
