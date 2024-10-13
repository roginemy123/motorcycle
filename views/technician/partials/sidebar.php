<?php 
    $activePage = isset($_GET['page']) ? $_GET['page'] : '';
    $onPage = "text-danger bg-light";
?>

<div class="col-lg-2 h-100vh bg-danger py-3 px-0 sidebar">
    <ul class="nav flex-column">
        <li class="nav-item mb-4 px-3">
            <h4 class="text-light">Company Name <span class="d-block sub-title">Technician</span></h4>
        </li>
        <li class="nav-item ">
            <a href="?auth=3&page=home" class="text-decoration-none py-2 d-block px-3 <?= $activePage == 'home' ? $onPage : 'text-light' ?>"><i class="fa fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
            <a href="?auth=3&page=logout" class="text-light text-decoration-none py-2 d-block px-3"><i class="fa fa-sign-out"></i> Logout</a>
        </li>
    </ul>
</div>