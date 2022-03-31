<?php

class User {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function checkExistsUserByEmail($email)
    {
        $this->db->query('SELECT email FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->fetch();
        $count = $this->db->rowCount();
        return ($count > 0);
    }

    public function createNewUser($data)
    {
        $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->fetch();
        $count = $this->db->rowCount();
        return ($count > 0);
    }

    public function getLogin($data)
    {
        $this->db->query('SELECT id, name, email, password, created_at FROM users WHERE email = :email');
        $this->db->bind(':email', $data['email']);
        $row = $this->db->fetch();
        $count = $this->db->rowCount();
        if ($count > 0)
        {
            $hashedPassword = $row->password;
            if (password_verify($data['password'], $hashedPassword))
            {
                return $row;
            }
        }
        return false;
    }

    public function getUserById($user_id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $user_id);
        return $this->db->fetch();
    }
}

?>