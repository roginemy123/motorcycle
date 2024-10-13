
<div class="container py-5">

    <div class="h-100vh d-flex align-items-center justify-content-center ">

        <form method="post" class="card login_card border-0 shadow p-4">
            <div class="card-header bg-transparent border-0 pb-0">
                <h2>Sign Up</h2>
                <p>Please read the input carefully before you submit.</p>
            </div>

            <div class="card-body py-0">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control my-2" >
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control my-2" >
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control my-2" >
                    <label for="">Password</label>
                    <div class="position-relative " >
                        <input type="password" name="password" class="form-control my-2">
                    </div>
                    <label for="">Confirm Password</label>
                    <div class="position-relative " >
                        <input type="password" name="confirm" class="form-control my-2">
                    </div>
            </div>

            <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
            <p>Already have an account? <a href="?page=sign-in">Sign In</a></p>
                <button type="submit" name="sign_up" class="btn btn-danger px-4">Register</button>
            </div>

        </form>

    </div>

</div>

<?php 
    $postRequest = postRequest('sign_up');
    if($postRequest){
        registerAccount();
    }
?>