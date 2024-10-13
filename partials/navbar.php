<?php 
    $activePage = isset($_GET['page']) ? $_GET['page'] : '';
    $onPage = 'active';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top">
        <div class="container">
        <a href="?page=home" class="text-decoration-none text-light"><h2 class="navbar-brand fw-bold">Company Name</h2></a>

            <button type="button" class="navbar-toggler border-0"><i class="navbar-toggler-icon"></i></button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto gap-3">
                    <li class="nav-item"><a href="?page=home" class="nav-link <?= $activePage == 'home' ? $onPage : '' ?>">Home</a></li>
                    <li class="nav-item"><a href="?page=about-us" class="nav-link <?= $activePage == 'about-us' ? $onPage : '' ?>">About Us</a></li>
                    <li class="nav-item"><a href="?page=services" class="nav-link <?= $activePage == 'services' ? $onPage : '' ?>">Services</a></li>
                    <li class="nav-item"><a href="?contact-us" class="nav-link <?= $activePage == 'contact-us' ? $onPage : '' ?>">Contact Us</a></li>
                    <li class="nav-item dropdown">
                        <a href="javascript:void(0);" class="nav-link <?= $activePage == 'contact-us' ? $onPage : '' ?> dropdown-toggle position-relative" data-bs-toggle="dropdown"><i class="fa fa-user"></i> <span class="navbar-notification"> <?= isUserActive() ? userNotification()->num_rows : '0' ?> </span></a>
                        <ul class="dropdown-menu dropdown-menu-end text-center <?= isUserActive() ? 'pt-0' : 'py-0' ?>">
                            <li class="dropdown-item bg-danger text-light">
                                <h5><?= isUserActive() ? clean(ucfirst(sessionData()->name)) : 'Name' ?></h5>
                                <p><i class="fa fa-calendar-day"></i> <?= isUserActive() ? clean(sessionData()->created) : '0000-00-00' ?></p>
                            </li>
                            <?php 
                                if(isUserActive()):
                            ?>
                            <li class="dropdown-item">
                                <a href="?page=my-appointments" class="text-dark text-decoration-none"><i class="fa fa-clock"></i> Appointments</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <a href="?page=logout" class="text-dark text-decoration-none"><i class="fa fa-sign-out"></i> Logout</a>
                            </li>
                            <?php else: ?>
                            <li class="dropdown-item">
                                <a href="?page=sign-in" class="text-dark text-decoration-none"><i class="fa fa-sign-in"></i> Sign In</a>
                            </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>