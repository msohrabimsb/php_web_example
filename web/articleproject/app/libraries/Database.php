<?php

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;// db_handlear
    private $stmt;
    private $error;

    public function __construct()
    {
        // تنظیم DNS:
        $dns = 'mysql:host=' . $this->host 
            . ';dbname=' . $this->dbname 
            . ';charset=utf8;';

        // ایجاد نمونه از PDO:
        try {
            $this->dbh = new PDO($dns, $this->user, $this->pass);
            $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        catch (PDOExeption $ex) {
            $this->error = $ex->getMessage();
            echo "وقوع خطا در اتصال به پایگاه داده: " . $this->error;
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value)
    {
        $this->stmt->bindParam($param, $value);
    }
    
    public function execute()
    {
        return $this->stmt->execute();
    }

    // برای تعدادی رکورد
    // بازگرداندن نتیجه به صورت آرایه ای از آبجکت ها
    public function fetchAll()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // برای خواندن فقط یک رکورد
    // بازگرداندن یک رکورد به صورت آبجکت
    public function fetch()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}

?>