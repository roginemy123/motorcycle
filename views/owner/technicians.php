<?php 
   require __DIR__ . '../../../functions/Owner.php';

    if(!isUserActive() || clean($_SESSION['USER_TYPE']) != 2){
        alertDefault([
            '?page=sign-in',
            'middle',
            'warning',
            'Please login first, proceeding to login....',
            '3000'
        ]);
    }

    $technicians = getTechnicianByShopOwner();
    $shops = getShopByOwner(); 
    $techs = getRegisteredTechnician(); 
?>

<div class="container-fluid">
    <div class="row">

        <?php require __DIR__ . '/partials/sidebar.php' ?>

        <div class="col-lg-10 p-4">

            <div class="card">
                <div class="card-header d-flex gap-2 align-items-center bg-transparent">
                    <h5><i class="fa fa-technician"></i> Technician(<?= $technicians->num_rows ?>)</h5>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#add"><i
                            class="fa fa-plus"></i></button>
                </div>

                <div class="card-body">

                    <table id="table">
                        <thead>
                            <th>Name</th>
                            <th>Shop</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php 

                            if($technicians->num_rows > 0){
                                foreach($technicians as $technician){
                                    ?>
                            <tr>
                                <td><?= clean($technician['TECH_NAME']) ?></td>
                                <td><?= clean($technician['SHOP_NAME']) ?></td>
                                <td><?= clean($technician['created']) ?></td>
                                <td><?= clean($technician['updated']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete-<?= clean($technician['id']) ?>">Delete</button>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#update-<?= clean($technician['id']) ?>">Update</button>

                                

                                        <!-- DELETE -->
                            <div class="modal" id="delete-<?= clean($technician['id']) ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Remove Technician</h5>
                                        </div>

                                        <form method="post" class="modal-body text-center">
                                            <input type="hidden" name="id" value="<?= clean($technician['id']) ?>">
                                            <input type="hidden" name="shop_id" value="<?= clean($technician['shop_id']) ?>">
                                           
                                            <h4>Are you sure?</h4>
                                            <p>Do you really want to remove " <span class="fw-bold"><?= clean($technician['name']) ?></span> "?</p>

                                            <button type="submit" name="delete" class="btn btn-danger">Remove</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            

                                        </form>

                                    </div>
                                </div>
                            </div>
                                        <!-- UPDATE -->
                            <div class="modal" id="update-<?= clean($technician['id']) ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Update technician</h5>
                                        </div>

                                        <form method="post" class="modal-body">
                                            <input type="hidden" name="id" value="<?= $technician['id'] ?>">
                                            
                                            <label for="shop">Technician</label>
                                            <select name="tech_id" class="my-2 js-searchBox form-select d-none" required>
                                                <option value="" disabled selected>Select Technician</option>
                                                <?php
                                                
                                                if($techs->num_rows > 0){
                                                    foreach($techs as $tech){
                                                        if($tech['id'] == $technician['tech_id']){
                                                            ?>
                                                            <option selected value="<?= $tech['id'] ?>"><?= $tech['name'] ?></option>
                                                        <?php 
                                                        }else{
                                                            ?>
                                                            <option value="<?= $tech['id'] ?>"><?= $tech['name'] ?></option>
                                                        <?php 
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            

                                            <label for="shop">Shop</label>
                                            <select name="shop_id" class="form-select my-2">
                                                <option value="" disabled selected>Select Shop</option>
                                                <?php
                                                
                                                if($shops->num_rows > 0){
                                                    foreach($shops as $shop){
                                                       if($shop['id'] == $technician['shop_id']){
                                                        ?>
                                                        <option selected value="<?= $shop['id'] ?>"><?= $shop['name'] ?></option>
                                                        <?php 
                                                       }else{
                                                        ?>
                                                        <option value="<?= $shop['id'] ?>"><?= $shop['name'] ?></option>
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
                <h5>Add technician</h5>
            </div>

            <form method="post" class="modal-body">

                <label for="shop">Technician</label>
                <select name="tech_id" class="my-2 js-searchBox form-select d-none" required>
                    <option value="" disabled selected>Select Technician</option>
                    <?php
                    
                    if($techs->num_rows > 0){
                        foreach($techs as $tech){
                            ?>
                    <option value="<?= $tech['id'] ?>"><?= $tech['name'] ?></option>
                    <?php 
                        }
                    }
                    ?>
                </select>
                

                <label for="shop">Shop</label>
                <select name="shop_id" class="form-select my-2">
                    <option value="" disabled selected>Select Shop</option>
                    <?php
                    if($shops->num_rows > 0){
                        foreach($shops as $shop){
                            ?>
                    <option value="<?= $shop['id'] ?>"><?= $shop['name'] ?></option>
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
        addTechnician();
    }

    $postRequestUpdate = postRequest('update');
    if($postRequestUpdate){
        updateTechnician();
    }

    $postRequestDelete = postRequest('delete');
    if($postRequestDelete){
        removeTechnician();
    }
?>