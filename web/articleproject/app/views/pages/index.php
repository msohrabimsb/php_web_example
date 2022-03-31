<?php require(APPROOT . 'views/inc/header.php'); ?>

<div class="bg-dark cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <?php require(APPROOT . 'views/inc/nav.php'); ?>
    
    <main role="main" class="app-main text-right text-white">
        <h5 class="p-5 text-center">
            <?php
            if (!isLogedIn())
            {
                echo "لطفاً وارد حساب کاربری خود شوید.";
            }
            else
            {
                echo "کاربر محترم " . getLogginName() . " خوش آمدید.";
            }
            ?>
        </h5>
    </main>
    
    <?php require(APPROOT . 'views/inc/footer.php'); ?>