<?php require(APPROOT . 'views/inc/header.php'); ?>

<div class="bg-dark cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <?php require(APPROOT . 'views/inc/nav.php'); ?>
    
    <main role="main" class="app-main text-right text-dark">
        <div class="row">
            <div class="col col-5 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <?php flash('not_register_user') ?>

                        <h5>عضویت در سامانه</h5>
                        <form action="<?php echo URLROOT; ?>users/register"
                            method="post">
                            <div class="form-group">
                                <label for="name"><sup class="text-danger">*</sup> نام:</label>
                                <input type="text" name="name" maxlength="255"
                                    class="form-control <?php echo ((empty($data['name_error'])) ? ((empty($data['name'])) ? '' : 'is-valid') : 'is-invalid'); ?>" 
                                    value="<?php echo $data['name']; ?>">
                                <div class="invalid-feedback d-block"><?php echo $data['name_error']; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="email"><sup class="text-danger">*</sup> ایمیل:</label>
                                <input type="text" name="email" maxlength="255"
                                    class="form-control <?php echo ((empty($data['email_error'])) ? ((empty($data['email'])) ? '' : 'is-valid') : 'is-invalid'); ?>" 
                                    value="<?php echo $data['email']; ?>">
                                <div class="invalid-feedback d-block"><?php echo $data['email_error']; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="password"><sup class="text-danger">*</sup> رمز عبور:</label>
                                <input type="password" name="password" maxlength="255"
                                    class="form-control <?php echo ((empty($data['password_error'])) ? ((empty($data['password'])) ? '' : 'is-valid') : 'is-invalid'); ?>" 
                                    value="">
                                <div class="invalid-feedback d-block"><?php echo $data['password_error']; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password"><sup class="text-danger">*</sup> تکرار رمز عبور:</label>
                                <input type="password" name="confirm_password" maxlength="255"
                                    class="form-control <?php echo ((empty($data['confirm_password_error'])) ? ((empty($data['confirm_password'])) ? '' : 'is-valid') : 'is-invalid'); ?>" 
                                    value="">
                                <div class="invalid-feedback d-block"><?php echo $data['confirm_password_error']; ?></div>
                            </div>
                            <footer class="text-center">
                                <button type="submit" class="btn btn-success ml-2">ثبت عضویت</button>
                                <button type="button" class="btn btn-dark" onclick="clear_form()">فرم خام</button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php require(APPROOT . 'views/inc/footer.php'); ?>