<nav class="navbar navbar-expand-lg nav-tabs" style="background-color: #0a4275;">
    <div class="container">
        <a href="<?php echo URLROOT; ?>pages/index">
            <h4 class="text-center text-white">
                <?php
                    if (isLogedIn()) {
                        echo getLogginName();
                    }
                    else
                    {
                        echo SITENAME;
                    }
                ?>
            </h4>
        </a>
        <nav class="nav justify-content-center">
        <a class="nav-link text-white <?php echo (isset($_GET['url']) && $_GET['url'] == 'pages/index' ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>pages/index">خانه</a>
            <?php if (isLogedIn()): ?>
                <a class="nav-link text-white <?php echo (isset($_GET['url']) && $_GET['url'] == 'categories/index' ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>categories/index">دسته بندی‌های من</a>
                <a class="nav-link text-white <?php echo (isset($_GET['url']) && $_GET['url'] == 'articles/index' ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>articles/index">لیست مقالات</a>
                <a class="nav-link text-white <?php echo (isset($_GET['url']) && $_GET['url'] == 'users/logout' ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>users/logout">خروج</a>
            <?php else: ?>
                <a class="nav-link text-white <?php echo (isset($_GET['url']) && $_GET['url'] == 'users/login' ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>users/login">ورود</a>
                <a class="nav-link text-white <?php echo (isset($_GET['url']) && $_GET['url'] == 'users/register' ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>users/register">عضویت</a>
            <?php endif ?>
        </nav>
    </div>
</nav>