
<div class="container py-5">

    <div class="h-100vh d-flex align-items-center justify-content-center ">

        <form method="post" class="card login_card border-0 shadow p-4">
            <div class="card-header bg-transparent border-0 pb-0">
                <h2>Sign In</h2>
                <p>Please login your account here</p>
            </div>

            <div class="card-body py-0">
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control my-2" >
                    <label for="">Password</label>
                    <div class="position-relative " >
                        <input type="password" name="password" class="form-control my-2">
                    </div>

                    <p>Don't have an account? <a href="?page=sign-up">Sign Up</a></p>

            </div>

            <div class="card-footer bg-transparent pt-0 border-0 d-flex justify-content-between">
                <a href="?page=forgot-password">Forgot Password?</a>
                <button type="submit" name="sign_in" class="btn btn-danger px-5">Sign In</button>
            </div>

        </form>

    </div>

</div>
<?php 
    $postRequest = postRequest('sign_in');
    if($postRequest){
        loginAccount();
    }
?>