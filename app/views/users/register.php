<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Create An Account</h2>
                <p>Please fill out this form to register with us</p>
                <form action="<?php echo URLROOT; ?>/users/register" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name: <sup>*</sup></label>
                        <input type="text" name="name" class="form-control form-control-lg <?php echo
                        (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo
                        (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>

                    <select id="selectTypeofStudy" class="form-control" name="type_of_study">
                        <option selected>Program of Study</option>
                        <option value="Master">Master</option>
                        <option value="Licenta">Licenta</option>
                    </select>

                    <select class="form-control" name="year">
                        <option selected>Year</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>

                    <div class="form-group">
                        <label for="text">Faculty: <sup>*</sup></label>
                        <input type="faculty" name="faculty" class="form-control form-control-lg <?php echo
                        (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="">
                        <span class="invalid-feedback"><?php echo $data['faculty_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="text">Phone: <sup>*</sup></label>
                        <input type="phone" name="phone" class="form-control form-control-lg <?php echo
                        (!empty($data['phone_err'])) ? 'is-invalid' : ''; ?>" value="">
                        <span class="invalid-feedback"><?php echo $data['phone_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo
                        (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                        <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo
                        (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="file">Select Image: <sup>*</sup></label>
                        <input type="file" name="image" class="form-control form-control-lg">
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Register" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
