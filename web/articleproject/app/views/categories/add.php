<?php require(APPROOT . 'views/inc/header.php'); ?>

<div class="bg-dark cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <?php require(APPROOT . 'views/inc/nav.php'); ?>
    
    <main role="main" class="app-main text-right text-dark">
        <div class="row">
            <div class="col col-5 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <?php flash('message_of_category') ?>

                        <h5>ثبت دسته بندی</h5>
                        <form action="<?php echo URLROOT; ?>categories/add" method="post">
                            <div class="form-group">
                                <label for="name"><sup class="text-danger">*</sup> عنوان دسته بندی:</label>
                                <input type="text" name="name" maxlength="255"
                                    class="form-control <?php echo ((empty($data['name_error'])) ? ((empty($data['name'])) ? '' : 'is-valid') : 'is-invalid'); ?>" 
                                    value="<?php echo $data['name']; ?>">
                                <div class="invalid-feedback d-block"><?php echo $data['name_error']; ?></div>
                            </div>
                            <footer class="text-center">
                                <button type="submit" class="btn btn-success ml-2">ثبت</button>
                                <button type="button" class="btn btn-dark" onclick="clear_form()">فرم خام</button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php require(APPROOT . 'views/inc/footer.php'); ?>