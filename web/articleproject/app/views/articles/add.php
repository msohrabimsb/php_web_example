<?php require(APPROOT . 'views/inc/header.php'); ?>

<div class="bg-dark cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <?php require(APPROOT . 'views/inc/nav.php'); ?>
    
    <main role="main" class="app-main text-right text-dark">
        <div class="row">
            <div class="col col-5 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <?php flash('message_of_article') ?>

                        <h5>ثبت مقاله</h5>
                        <form action="<?php echo URLROOT; ?>articles/add" method="post">
                            <div class="form-group">
                                <label for="category_id"><sup class="text-danger">*</sup> دسته بندی:</label>
                                <select name="category_id" value="<?php echo $data['category_id']; ?>" 
                                    class="form-control <?php echo ((empty($data['category_id_error'])) ? ((empty($data['category_id'])) ? '' : 'is-valid') : 'is-invalid'); ?>">
                                    <?php
                                        foreach ($data['categories'] as $category)
                                        {
                                            echo '<option value="' . $category->id . '"' . ((!empty($data['category_id']) && $data['category_id'] == $category->id) ? ' selected' : '') . '>' . $category->name . '</option>';
                                        }
                                    ?>
                                </select>
                                <div class="invalid-feedback d-block"><?php echo $data['category_id_error']; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="title"><sup class="text-danger">*</sup> عنوان مقاله:</label>
                                <input type="text" name="title" maxlength="255"
                                    class="form-control <?php echo ((empty($data['title_error'])) ? ((empty($data['title'])) ? '' : 'is-valid') : 'is-invalid'); ?>" 
                                    value="<?php echo $data['title']; ?>">
                                <div class="invalid-feedback d-block"><?php echo $data['title_error']; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="content"><sup class="text-danger">*</sup> متن مقاله:</label>
                                <textarea name="content" class="form-control <?php echo ((empty($data['content_error'])) ? ((empty($data['content'])) ? '' : 'is-valid') : 'is-invalid'); ?>" 
                                cols="30" rows="10"><?php echo $data['content']; ?></textarea>
                                <div class="invalid-feedback d-block"><?php echo $data['content_error']; ?></div>
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