<?php require(APPROOT . 'views/inc/header.php'); ?>

<div class="bg-dark cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <?php require(APPROOT . 'views/inc/nav.php'); ?>
    
    <main role="main" class="app-main text-right text-white">
        <?php flash('message_of_category') ?>
        
        <div class="row bg-light p-2 text-dark">
            <div class="col col-10">
                <h5>مدیریت دسته بندی های من:</h5>
            </div>
            <div class="col col-2">
                <a class="btn btn-dark text-white" href="<?php echo URLROOT; ?>categories/add">افزودن دسته بندی</a>
            </div>
        </div>
        
        <table class="table table-hover bg-light text-center">
            <thead class="thead-dark">
                <tr>
                    <th>عنوان دسته بندی</th>
                    <th>تاریخ ایجاد</th>
                    <th>ویرایش</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['categories'] as $category) : ?>
                    <tr>
                        <td>
                            <?php echo $category->name ?>
                        </td>
                        <td><?php echo $category->created_at ?></td>
                        <td>
                            <a href="<?php echo URLROOT ?>categories/edit/<?php echo $category->id ?>" class="btn btn-info">
                                ویرایش
                            </a>
                        </td>
                        <td>
                            <form action="<?php echo URLROOT ?>categories/delete/<?php echo $category->id ?>" method="post">
                                <button type="submit" class="btn btn-danger" 
                                    onclick="try{if(confirm('آیا اطمینان به حذف دسته بندی دارید؟')){return true;}else{return false;}}catch(e){return true;};">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </main>
    
    <?php require(APPROOT . 'views/inc/footer.php'); ?>