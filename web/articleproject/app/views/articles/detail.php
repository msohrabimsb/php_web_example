<?php require(APPROOT . 'views/inc/header.php'); ?>

<div class="bg-dark cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <?php require(APPROOT . 'views/inc/nav.php'); ?>
    <main role="main" class="app-main text-right text-dark">
        <h5 class="bg-light p-2">جزئیات مقاله:</h5>
        <div class="card">
            <div class="card-body">
                <?php 
                    if (isset($data['article']))
                    {
                        $article = $data['article'];
                        $category = $data['category'];
                        $user = $data['user'];
                    }
                    if (isset($article) && is_object($article)) :
                ?>
                    <div class="p-1">
                        <b>دسته بندی: </b>
                        <span><?php echo $category->name ?></span>
                    </div>
                    <div class="p-1">
                        <b>عنوان مقاله: </b>
                        <span><?php echo $article->title ?></span>
                    </div>
                    <div class="p-1">
                        <b>تاریخ ایجاد: </b>
                        <span><?php echo $article->created_at ?></span>
                    </div>
                    <div class="p-1">
                        <b>ایجاد کننده: </b>
                        <span title="ایمیل کاربر: <?php echo $user->email ?>">
                        <?php echo $user->name ?>
                    </span>
                    <div class="p-1">
                        <b>متن مقاله: </b>
                        <div class="p-3"><?php echo $article->content ?></div>
                    </div>
                    
                    <?php if (checkUserIdEqualToLoginId($article->user_id)) : ?>
                        <footer class="text-center">
                            <a href="<?php echo URLROOT ?>articles/edit/<?php echo $article->id ?>" class="btn btn-info ml-2">
                                ویرایش
                            </a>
                            <form action="<?php echo URLROOT ?>articles/delete/<?php echo $article->id ?>" method="post" style="display: inline-block;">
                                <button type="submit" class="btn btn-danger" 
                                    onclick="try{if(confirm('آیا اطمینان به حذف مقاله دارید؟')){return true;}else{return false;}}catch(e){return true;};" >
                                    حذف
                                </button>
                            </form>
                        </footer>
                    <?php endif ?>
                
                <?php endif ?>
            </div>
        </div>
    </main>
    
    <?php require(APPROOT . 'views/inc/footer.php'); ?>