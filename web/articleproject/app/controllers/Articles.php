<?php

class Articles extends Controller {
    private $articleModel;
    private $userModel;

    public function __construct()
    {
        // بررسی لاگین بودن کاربر
        if (!isLogedIn())
        {
            redirect('users/login');
        }

        $this->articleModel = $this->model('Article');

        $this->categoryModel = $this->model('Category');

        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $articles = $this->articleModel->getArticles();
        $data = [
            'articles' => $articles
        ];

        $this->view('articles/index', $data);
    }

    public function detail($id)
    {
        $article = $this->articleModel->getArticleById($id);
        if (!is_object($article))
        {
            flash('message_of_article', "مقاله مورد نظر یافت نشد!", 'alert alert-danger');
            redirect('articles/index');
        }
        $category = $this->categoryModel->getCategoryById($article->category_id);
        $user = $this->userModel->getUserById($article->user_id);

        $data = [
            'article' => $article,
            'category' => $category,
            'user' => $user
        ];

        $this->view('articles/detail', $data);
    }

    public function add()
    {
        $categories = $this->categoryModel->getCategories();
        if (!is_array($categories))
        {
            flash('message_of_category', "لطفاً جهت ایجاد مقاله ابتدا یک دسته بندی ایجاد نمایید.", 'alert alert-danger');
            redirect('categories/add');
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            // ضد عفونی کردن ورودی ها:
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'categories' => $categories,

                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'category_id' => trim($_POST['category_id']),

                'title_error' => '',
                'content_error' => '',
                'category_id_error' => ''
            ];

            $is_valid = true;
            if (empty($data['category_id']))
            {
                $is_valid = false;
                $data['category_id_error'] = "لطفاً دسته بندی را انتخاب نمایید.";
            }
            if (empty($data['title']))
            {
                $is_valid = false;
                $data['title_error'] = "لطفاً کادر عنوان مقاله را تکمیل نمایید.";
            }
            if (empty($data['content']))
            {
                $is_valid = false;
                $data['content_error'] = "لطفاً کادر متن مقاله را تکمیل نمایید.";
            }

            if ($is_valid == false)
            {
                $this->view('articles/add', $data);
            }
            else
            {
                if ($this->articleModel->add($data))
                {
                    flash('message_of_article', "مقاله با موفقیت ایجاد شد.");
                    redirect('articles/index');
                }
                else
                {
                    flash('message_of_article', "عدم موفقیت در ثبت مقاله. لطفاً دوباره تلاش نمایید.", 'alert alert-danger');
                    $this->view('articles/add', $data);
                }
            }
        }
        else
        {
            $data = [
                'categories' => $categories,

                'title' => '',
                'content' => '',
                'category_id' => '',

                'title_error' => '',
                'content_error' => '',
                'category_id_error' => ''
            ];
            $this->view('articles/add', $data);
        }
    }

    public function edit($id)
    {
        if (empty($id))
        {
            redirect('articles/index');
        }

        $categories = $this->categoryModel->getCategories();
        if (!is_array($categories))
        {
            flash('message_of_category', "لطفاً جهت ایجاد مقاله ابتدا یک دسته بندی ایجاد نمایید.", 'alert alert-danger');
            redirect('categories/add');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            // ضد عفونی کردن ورودی ها:
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'categories' => $categories,

                'id' => $id,

                'title' => trim($_POST['title']),
                'content' => trim($_POST['content']),
                'category_id' => trim($_POST['category_id']),

                'title_error' => '',
                'content_error' => '',
                'category_id_error' => ''
            ];

            $is_valid = true;
            if (empty($data['category_id']))
            {
                $is_valid = false;
                $data['category_id_error'] = "لطفاً دسته بندی را انتخاب نمایید.";
            }
            if (empty($data['title']))
            {
                $is_valid = false;
                $data['title_error'] = "لطفاً کادر عنوان مقاله را تکمیل نمایید.";
            }
            if (empty($data['content']))
            {
                $is_valid = false;
                $data['content_error'] = "لطفاً کادر متن مقاله را تکمیل نمایید.";
            }

            if ($is_valid == false)
            {
                $this->view('articles/edit', $data);
            }
            else
            {
                if ($this->articleModel->update($data))
                {
                    flash('message_of_article', "مقاله با موفقیت بروزرسانی شد.");
                    redirect('articles/index');
                }
                else
                {
                    $article = $this->articleModel->getArticleById($id);
                    if (!is_object($article))
                    {
                        flash('message_of_article', "مقاله مورد نظر یافت نشد!", 'alert alert-danger');
                        redirect('articles/index');
                    }
                    elseif (!checkUserIdEqualToLoginId($article->user_id))
                    {
                        flash('message_of_article', "شما مجوز ویرایش مقاله فرد دیگری را ندارید.", 'alert alert-danger');
                        redirect('articles/index');
                    }
                    elseif ($article->title == $data['title'] && $article->content == $data['content'])
                    {
                        flash('message_of_article', "مقاله مورد نظر تغییری نکرده بود تا بروزرسانی برای آن اعمال شود.");
                        redirect('articles/index');
                    }
                    else
                    {
                        flash('message_of_article', "عدم موفقیت در بروزرسانی مقاله. لطفاً دوباره تلاش نمایید.", 'alert alert-danger');
                        $this->view('articles/edit', $data);
                    }
                }
            }
        }
        else
        {
            $article = $this->articleModel->getArticleById($id);
            if (!is_object($article))
            {
                flash('message_of_article', "مقاله مورد نظر یافت نشد!", 'alert alert-danger');
                redirect('articles/index');
            }

            if (!checkUserIdEqualToLoginId($article->user_id))
            {
                flash('message_of_article', "مقاله مورد نظر توسط فرد دیگری ایجاد شده و شما مجوز ویرایش آن را ندارید!", 'alert alert-danger');
                redirect('articles/index');
            }
            
            $data = [
                'categories' => $categories,

                'id' => $id,

                'title' => $article->title,
                'content' => $article->content,
                'category_id' => $article->category_id,

                'title_error' => '',
                'content_error' => '',
                'category_id_error' => ''
            ];
            $this->view('articles/edit', $data);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST" || empty($id))
        {
            redirect('articles/index');
        }

        $article = $this->articleModel->getCreatedUserId($id);
        if (!is_object($article))
        {
            flash('message_of_article', "شما مجوز حذف مقاله فرد دیگری را ندارید.", 'alert alert-danger');
        }
        elseif (!checkUserIdEqualToLoginId($article->user_id))
        {
            flash('message_of_article', "شما مجوز حذف مقاله فرد دیگری را ندارید.", 'alert alert-danger');
        }
        elseif ($this->articleModel->delete($id))
        {
            flash('message_of_article', "مقاله مورد نظر با موفقیت حذف شد.");
        }
        else
        {
            flash('message_of_article', "مقاله مورد نظر حذف نشد! لطفاً دوباره تلاش نمایید.", 'alert alert-danger');
        }
        redirect('articles/index');
    }
}

?>