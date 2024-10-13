<?php 
   require __DIR__ . '../../../functions/Admin.php';

    if(!isUserActive() || clean($_SESSION['USER_TYPE']) != 1){
        alertDefault([
            '?page=sign-in',
            'middle',
            'warning',
            'Please login first, proceeding to login....',
            '3000'
        ]);
    }

    $shops = getAllShops();
?>

<div class="container-fluid">
    <div class="row">

        <?php require __DIR__ . '/partials/sidebar.php' ?>

        <div class="col-lg-10 p-4">

            <div class="card">
                <div class="card-header d-flex gap-2 align-items-center bg-transparent">
                    <h5><i class="fa fa-shop"></i> Shop(<?= $shops->num_rows ?>)</h5>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#add"><i
                            class="fa fa-plus"></i></button>
                </div>

                <div class="card-body">

                    <table id="table">
                        <thead>
                            <th>Name</th>
                            <th>Owner</th>
                            <th>Address</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 

                            if($shops->num_rows > 0){
                                foreach($shops as $shop){
                                    ?>
                            <tr>
                                <td><?= clean($shop['name']) ?></td>
                                <td><?= clean(getOwnerById($shop['owner_id'])->name) ?></td>
                                <td><?= clean($shop['street']) . ', ' . clean($shop['city']) ?></td>
                                <td><?= clean($shop['created']) ?></td>
                                <td><?= clean($shop['updated']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete-<?= clean($shop['id']) ?>">Delete</button>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#update-<?= clean($shop['id']) ?>">Update</button>

                                

                                        <!-- DELETE -->
                                        <div class="modal" id="delete-<?= clean($shop['id']) ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Remove Shop</h5>
                                        </div>

                                        <form method="post" class="modal-body text-center">
                                            <input type="hidden" name="shop_id" value="<?= clean($shop['id']) ?>">
                                           
                                            <h4>Are you sure?</h4>
                                            <p>Do you really want to remove " <span class="fw-bold"><?= clean($shop['name']) ?></span> " shop?</p>

                                            <button type="submit" name="delete" class="btn btn-danger">Remove</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            

                                        </form>

                                    </div>
                                </div>
                            </div>
                                        <!-- UPDATE -->
                            <div class="modal" id="update-<?= clean($shop['id']) ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Update Shop</h5>
                                        </div>

                                        <form method="post" class="modal-body">
                                            <input type="hidden" name="shop_id" value="<?= clean($shop['id']) ?>">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control my-2" value="<?= clean($shop['name']) ?>">

                                            <label for="street">Street</label>
                                            <input type="text" name="street" class="form-control my-2" value="<?= clean($shop['street']) ?>">

                                            <label for="city">City</label>
                                            <input type="text" name="city" class="form-control my-2" value="<?= clean($shop['city']) ?>">

                                            <label for="owner">Owner</label>
                                            <select name="owner_id" class="form-select my-2">
                                                <option value="" disabled selected>Select Owner</option>
                                                <?php
                                                   $owners = getAllOwners(); 
                                                    if($owners->num_rows > 0){
                                                        foreach($owners as $owner){
                                                            if($shop['owner_id'] == $owner['id']){
                                                                ?>
                                                                  <option selected value="<?= $owner['id'] ?>"><?= $owner['name'] ?></option>
                                                                <?php 
                                                            }else{
                                                                ?>
                                                                   <option value="<?= $owner['id'] ?>"><?= $owner['name'] ?></option>
                                                                <?php 
                                                            }
                                                        
                                                        }
                                                    }
                                                    ?>
                                            </select>

                                            <button type="submit" name="update" class="btn btn-danger">Update</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                        </form>

                                    </div>
                                </div>
                            </div>
                                </td>
                            </tr>


                            <?php 
                                }
                            }
                            
                            ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>
</div>

<div class="modal" id="add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Add Shop</h5>
            </div>

            <form method="post" class="modal-body">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control my-2">

                <label for="street">Street</label>
                <input type="text" name="street" class="form-control my-2">

                <label for="city">City</label>
                <input type="text" name="city" class="form-control my-2">

                <label for="owner">Owner</label>
                <select name="owner_id" class="form-select my-2">
                    <option value="" disabled selected>Select Owner</option>
                    <?php
                    $owners = getAllOwners(); 
                    if($owners->num_rows > 0){
                        foreach($owners as $owner){
                            ?>
                    <option value="<?= $owner['id'] ?>"><?= $owner['name'] ?></option>
                    <?php 
                        }
                    }
                    ?>
                </select>

                <button type="submit" name="add" class="btn btn-danger">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

            </form>

        </div>
    </div>
</div>

<?php 
    $postRequest = postRequest('add');
    if($postRequest){
        createShop();
    }

    $postRequestUpdate = postRequest('update');
    if($postRequestUpdate){
        updateShop();
    }

    $postRequestDelete = postRequest('delete');
    if($postRequestDelete){
        deleteShop();
    }
?>