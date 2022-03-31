<?php

class Category {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getCategories()
    {
        $this->db->query('SELECT * FROM categories WHERE user_id = :user_id ORDER BY name ASC');
        $this->db->bind(':user_id', getLogginId());
        return $this->db->fetchAll();
    }

    public function getCategoryById($category_id)
    {
        $this->db->query('SELECT * FROM categories WHERE id = :id');
        $this->db->bind(':id', $category_id);
        return $this->db->fetch();
    }

    public function getCreatedUserId($category_id)
    {
        $this->db->query('SELECT user_id FROM categories WHERE id = :id');
        $this->db->bind(':id', $category_id);
        return $this->db->fetch();
    }

    public function add($data)
    {
        $this->db->query('INSERT INTO categories (name, user_id) VALUES (:name, :user_id)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':user_id', getLogginId());
        $this->db->fetch();
        $count = $this->db->rowCount();
        return ($count > 0);
    }

    public function update($data)
    {
        $this->db->query('UPDATE categories 
                        SET name = :name
                        WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':user_id', getLogginId());
        $this->db->fetch();
        $count = $this->db->rowCount();
        return ($count > 0);
    }

    public function delete($category_id)
    {
        $this->db->query('DELETE FROM categories WHERE id = :id');
        $this->db->bind(':id', $category_id);
        return (($this->db->execute()) ? true : false);
    }
}

?>