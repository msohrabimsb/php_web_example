<?php

class Categories extends Controller {
    private $categoryModel;
    private $articleModel;
    private $userModel;

    public function __construct()
    {
        // بررسی لاگین بودن کاربر
        if (!isLogedIn())
        {
            redirect('users/login');
        }

        $this->categoryModel = $this->model('Category');

        $this->articleModel = $this->model('Article');

        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        $data = [
            'categories' => $categories
        ];

        $this->view('categories/index', $data);
    }

    public function detail($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if (!is_object($category))
        {
            flash('message_of_category', "دسته بندی مورد نظر یافت نشد!", 'alert alert-danger');
            redirect('categories/index');
        }

        $user = $this->userModel->getUserById($category->user_id);

        $data = [
            'category' => $category,
            'user' => $user
        ];

        $this->view('categories/detail', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            // ضد عفونی کردن ورودی ها:
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),

                'name_error' => ''
            ];

            $is_valid = true;
            if (empty($data['name']))
            {
                $is_valid = false;
                $data['name_error'] = "لطفاً کادر عنوان دسته بندی را تکمیل نمایید.";
            }

            if ($is_valid == false)
            {
                $this->view('categories/add', $data);
            }
            else
            {
                if ($this->categoryModel->add($data))
                {
                    flash('message_of_category', "دسته بندی با موفقیت ایجاد شد.");
                    redirect('categories/index');
                }
                else
                {
                    flash('message_of_category', "عدم موفقیت در ثبت دسته بندی. لطفاً دوباره تلاش نمایید.", 'alert alert-danger');
                    $this->view('categories/add', $data);
                }
            }
        }
        else
        {
            $data = [
                'name' => '',

                'name_error' => ''
            ];
            $this->view('categories/add', $data);
        }
    }

    public function edit($id)
    {
        if (empty($id))
        {
            redirect('categories/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            // ضد عفونی کردن ورودی ها:
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $id,

                'name' => trim($_POST['name']),

                'name_error' => ''
            ];

            $is_valid = true;
            if (empty($data['name']))
            {
                $is_valid = false;
                $data['name_error'] = "لطفاً کادر عنوان دسته بندی را تکمیل نمایید.";
            }

            if ($is_valid == false)
            {
                $this->view('categories/edit', $data);
            }
            else
            {
                if ($this->categoryModel->update($data))
                {
                    flash('message_of_category', "دسته بندی با موفقیت بروزرسانی شد.");
                    redirect('categories/index');
                }
                else
                {
                    $category = $this->categoryModel->getCategoryById($id);
                    if (!is_object($category))
                    {
                        flash('message_of_category', "دسته بندی مورد نظر یافت نشد!", 'alert alert-danger');
                        redirect('categories/index');
                    }
                    elseif (!checkUserIdEqualToLoginId($category->user_id))
                    {
                        flash('message_of_category', "شما مجوز ویرایش دسته بندی فرد دیگری را ندارید.", 'alert alert-danger');
                        redirect('categories/index');
                    }
                    elseif ($category->name == $data['name'])
                    {
                        flash('message_of_category', "دسته بندی مورد نظر تغییری نکرده بود تا بروزرسانی برای آن اعمال شود.");
                        redirect('categories/index');
                    }
                    else
                    {
                        flash('message_of_category', "عدم موفقیت در بروزرسانی دسته بندی. لطفاً دوباره تلاش نمایید.", 'alert alert-danger');
                        $this->view('categories/edit', $data);
                    }
                }
            }
        }
        else
        {
            $category = $this->categoryModel->getCategoryById($id);
            if (!is_object($category))
            {
                flash('message_of_category', "دسته بندی مورد نظر یافت نشد!", 'alert alert-danger');
                redirect('categories/index');
            }

            if (!checkUserIdEqualToLoginId($category->user_id))
            {
                flash('message_of_category', "دسته بندی مورد نظر توسط فرد دیگری ایجاد شده و شما مجوز ویرایش آن را ندارید!", 'alert alert-danger');
                redirect('categories/index');
            }
            
            $data = [
                'id' => $id,

                'name' => $category->name,

                'name_error' => ''
            ];
            $this->view('categories/edit', $data);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST" || empty($id))
        {
            redirect('categories/index');
        }

        $category = $this->categoryModel->getCreatedUserId($id);
        if (!is_object($category))
        {
            flash('message_of_category', "شما مجوز حذف دسته بندی فرد دیگری را ندارید.", 'alert alert-danger');
        }
        elseif (!checkUserIdEqualToLoginId($category->user_id))
        {
            flash('message_of_category', "شما مجوز حذف دسته بندی فرد دیگری را ندارید.", 'alert alert-danger');
        }
        elseif ($this->articleModel->checkExistsArticleInCategoryId($id))
        {
            flash('message_of_category', "برای دسته بندی مورد نظر مقاله ثبت نموده اید. امکان حذف دسته بندی دارای مقاله میسر نمی باشد.", 'alert alert-danger');
        }
        elseif ($this->categoryModel->delete($id))
        {
            flash('message_of_category', "دسته بندی مورد نظر با موفقیت حذف شد.");
        }
        else
        {
            flash('message_of_category', "دسته بندی مورد نظر حذف نشد! لطفاً دوباره تلاش نمایید.", 'alert alert-danger');
        }
        redirect('categories/index');
    }
}

?>