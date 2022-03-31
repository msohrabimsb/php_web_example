<?php require(APPROOT . 'views/inc/header.php'); ?>

<div class="bg-dark cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <?php require(APPROOT . 'views/inc/nav.php'); ?>
    
    <main role="main" class="app-main text-right text-dark">
        <div class="row">
            <div class="col col-5 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <?php flash('success_register_user') ?>
                        <?php flash('not_valid_login') ?>
                        <?php flash('success_logout') ?>

                        <h5>ورود به سامانه</h5>
                        <form action="<?php echo URLROOT; ?>users/login"
                            method="post">
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
                            <footer class="text-center">
                                <button type="submit" class="btn btn-success ml-2">ورود</button>
                                <button type="button" class="btn btn-dark" onclick="clear_form()">فرم خام</button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php require(APPROOT . 'views/inc/footer.php'); ?>