<?php

class Users extends Controller {
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            // ضد عفونی کردن ورودی ها:
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),

                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];

            $is_valid = true;
            if (empty($data['name']))
            {
                $is_valid = false;
                $data['name_error'] = "لطفاً کادر نام را تکمیل نمایید.";
            }
            if (empty($data['email']))
            {
                $is_valid = false;
                $data['email_error'] = "لطفاً کادر ایمیل را تکمیل نمایید.";
            }
            elseif (strlen($data['email']) < 5)
            {
                $is_valid = false;
                $data['email_error'] = "طول ایمیل بایستی حداقل 5 کاراکتر باشد.";
            }
            elseif ($this->userModel->checkExistsUserByEmail($data['email']))
            {
                $is_valid = false;
                $data['email_error'] = "ایمیل وارد شده قبلاً ثبت شده است!";
            }
            if (empty($data['password']))
            {
                $is_valid = false;
                $data['password_error'] = "لطفاً کادر رمز عبور را تکمیل نمایید.";
            }
            elseif (strlen($data['password']) < 6)
            {
                $is_valid = false;
                $data['password_error'] = "طول رمز عبور بایستی حداقل 6 کاراکتر باشد.";
            }
            if (empty($data['confirm_password']))
            {
                $is_valid = false;
                $data['confirm_password_error'] = "لطفاً کادر تکرار رمز عبور را تکمیل نمایید.";
            }
            elseif (!empty($data['password']) && $data['password'] != $data['confirm_password'])
            {
                $is_valid = false;
                $data['confirm_password_error'] = "دو رمز عبور وارد شده یکسان نمی باشند!";
            }

            if ($is_valid == false)
            {
                $this->view('users/register', $data);
            }
            else
            {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->userModel->createNewUser($data))
                {
                    flash('success_register_user', "حساب کاربری با موفقیت ایجاد گردید. لطفاً وارد حساب کاربری خود شوید.");
                    redirect('users/login');
                }
                else
                {
                    flash('not_register_user', "عدم موفقیت در ایجاد حساب کاربری. لطفاً دوباره تلاش نمایید.", 'alert alert-danger');
                }
            }
        }
        else
        {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',

                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            // ضد عفونی کردن ورودی ها:
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),

                'email_error' => '',
                'password_error' => ''
            ];

            $is_valid = true;
            if (empty($data['email']))
            {
                $is_valid = false;
                $data['email_error'] = "لطفاً کادر ایمیل را تکمیل نمایید.";
            }
            if (empty($data['password']))
            {
                $is_valid = false;
                $data['password_error'] = "لطفاً کادر رمز عبور را تکمیل نمایید.";
            }

            if ($is_valid == false)
            {
                $this->view('users/login', $data);
            }
            else
            {
                $loggedUser = $this->userModel->getLogin($data);
                if (!is_bool($loggedUser))
                {
                    $this->createUserSetionLogin($loggedUser);
                }
                else
                {
                    flash('not_valid_login', "اطلاعات وارد شده صحیح نمی باشد.", 'alert alert-danger');
                    $data['email_error'] = "لطفاً ایمیل صحیح را وارد نمایید.";
                    $data['password_error'] = "لطفاً رمز عبور صحیح را وارد نمایید.";
                    $this->view('users/login', $data);
                }
            }
        }
        else
        {
            $data = [
                'email' => '',
                'password' => '',

                'email_error' => '',
                'password_error' => ''
            ];
            $this->view('users/login', $data);
        }
    }

    private function createUserSetionLogin($loggedUser)
    {
        $_SESSION['user_id'] = $loggedUser->id;
        $_SESSION['user_name'] = $loggedUser->name;
        $_SESSION['user_email'] = $loggedUser->email;
        $_SESSION['user_created_at'] = $loggedUser->created_at;

        redirect('pages/index');
    }

    public function logout()
    {
        if (isLogedIn())
        {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_created_at']);

            flash('success_logout', "خروج از سامانه با موفقیت انجام شد.");
            redirect('users/login');
        }
        else
        {
            redirect('page/index');
        }
    }
}

?>