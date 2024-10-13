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

<form method="POST" enctype="multipart/form-data" class="row appointment_form g-3">

    <div class="col-lg-12">
        <h2>SET AN APPOINTMENT</h2>
        <p>Please read the fields carefully.</p>
    </div>

    <div class="col-lg-12">
        <p><span>*</span> Name</p>
        <div class="row g-3">
        <div class="col-lg-6">
            <input type="text" name="fname" class="form-control" required>
            <label for="fname">First Name</label>
        </div>

        <div class="col-lg-6">
            <input type="text" name="lname" class="form-control" required>
            <label for="lname">Last Name</label>
        </div>
        </div>
    </div>

    <div class="col-lg-12">
        <p><span>*</span> Date of Birth</p>
        <input type="date" name="birthdate" class="form-control" max="<?= date('Y-m-d') ?>" required> 
    </div>

    <div class="col-lg-6">
        <p><span>*</span> Gender</p>

        <div class="row">
            <div class="col-lg-2">
                <input type="radio" name="gender" class="form-check-input" value="Male" checked>
                <label for="gender">Male</label>
            </div>

            <div class="col-lg-2">
                <input type="radio" name="gender" class="form-check-input" value="Female">
                <label for="gender">Female</label>
            </div>
        </div>

    </div>

    <div class="col-lg-6">
        <p><span>*</span> Phone Number</p>
        <input type="tel" name="phone_number" class="form-control" pattern="[0-9]{11}" required>
    </div>

    <div class="col-lg-12">
        <p><span>*</span> Address</p>

        <div class="row g-3">
            <div class="col-12">
                <input type="text" name="street" class="form-control" required>
                <label for="street">Street</label>
            </div>

            <div class="col-12">
                <input type="text" name="city" class="form-control" required>
                <label for="city">City</label>
            </div>
        </div>

    </div>

    <div class="col-lg-12">
        <p><span>*</span> What to repair?</p>
       <textarea name="to_repair" class="form-control" row="20" cols="20" placeholder="List all what we need to repair" required></textarea>
    </div>

    <div class="col-lg-12">
        <p><span>*</span> Select shop that is near to you</p>
        
        <div class="row g-3">
            
            <?php 
                $shops = getShops();
                if($shops->num_rows > 0){
                    foreach($shops as $shop){
                        ?>
                        <div class="col-lg-3 ">
                           <div class="card position-relative p-3">
                                <div class="card-body ">
                                    <input type="radio" name="shop_id" class="position-absolute top-0 start-0 form-check-input m-2" value="<?= $shop['id'] ?>">
                                    <h3><?= $shop['name'] ?></h3>
                                    <p><i class="fa fa-location-dot"></i> : <?= ucfirst($shop['street']) . ', ' . ucfirst($shop['city']) ?></p>
                                </div>
                           </div>
                        </div>
                        <?php 
                    }
                }
            ?>
           

        </div>
    </div>

    <div class="col-lg-12">
        <p><span>*</span> Date & Time</p>

        <div class="row g-3">
            <div class="col-6">
                <input type="date" name="date" min="<?= date('Y-m-d') ?>" class="form-control" required>
                <label for="date">Date</label>
            </div>

            <div class="col-6">
                <input type="time" name="time" class="form-control" required>
                <label for="time">Time</label>
            </div>
        </div>

    </div>

    <div class="col-lg-9">
        <input type="checkbox" name="agreement" class="form-check-input" required>
        By agreeing to this I agree to Terms and Privacy Policy.
    </div>

    <div class="col-lg-3">
        <button type="submit" name="submit" class="btn btn-danger w-100">Submit</button>
    </div>


</form>

</div>

<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['submit'])){
            setAppointment();
        }

    }
?>