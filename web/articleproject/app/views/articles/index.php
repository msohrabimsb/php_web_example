<?php require(APPROOT . 'views/inc/header.php'); ?>

<div class="bg-dark cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <?php require(APPROOT . 'views/inc/nav.php'); ?>
    
    <main role="main" class="app-main text-right text-white">
        <?php flash('message_of_article') ?>
        
        <div class="row bg-light p-2 text-dark">
            <div class="col col-10">
                <h5>لیست مقالات:</h5>
            </div>
            <div class="col col-2">
                <a class="btn btn-dark text-white" href="<?php echo URLROOT; ?>articles/add">افزودن مقاله</a>
            </div>
        </div>
        
        <table class="table table-hover bg-light text-center">
            <thead class="thead-dark">
                <tr>
                    <th>دسته بندی</th>
                    <th>عنوان مقاله</th>
                    <th>بخشی از محتوا</th>
                    <th>تاریخ ایجاد</th>
                    <th>ایجاد شده توسط</th>
                    <th>مشاهده مقاله</th>
                    <th>ویرایش</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['articles'] as $article) : ?>
                    <tr>
                        <td>
                            <?php echo $article->category_name ?>
                        </td>
                        <td>
                            <?php echo $article->article_title ?>
                        </td>
                        <td>
                            <?php 
                                if (strlen($article->article_content) > 100) {
                                    echo substr($article->article_content, 0, 100) . ' ...';
                                }
                                else {
                                    echo $article->article_content;
                                }
                            ?>
                        </td>
                        <td><?php echo $article->article_created_at ?></td>
                        <td title="ایمیل کاربر: <?php echo $article->user_email ?>">
                            <?php echo $article->user_fullname ?>
                        </td>
                        <td>
                            <a href="<?php echo URLROOT ?>articles/detail/<?php echo $article->article_id ?>" class="btn btn-dark">
                                مشاهده
                            </a>
                        </td>

                        <?php if (checkUserIdEqualToLoginId($article->user_id)) : ?>
                            <td>
                                <a href="<?php echo URLROOT ?>articles/edit/<?php echo $article->article_id ?>" class="btn btn-info">
                                    ویرایش
                                </a>
                            </td>
                            <td>
                                <form action="<?php echo URLROOT ?>articles/delete/<?php echo $article->article_id ?>" method="post">
                                    <button type="submit" class="btn btn-danger" 
                                        onclick="try{if(confirm('آیا اطمینان به حذف مقاله دارید؟')){return true;}else{return false;}}catch(e){return true;};" >
                                        حذف
                                    </button>
                                </form>
                            </td>
                        <?php else : ?>
                            <td>-</td>
                            <td>-</td>
                        <?php endif ?>

                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </main>
    
    <?php require(APPROOT . 'views/inc/footer.php'); ?>