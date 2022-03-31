<?php

class Article {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getArticles()
    {
        $this->db->query('SELECT 
                            ar.id AS article_id, 
                            ar.user_id, 
                            ar.title AS article_title, 
                            ca.name AS category_name,
                            ar.content AS article_content, 
                            ar.created_at AS article_created_at,
                            u.name AS user_fullname, 
                            u.email AS user_email 
                        FROM articles AS ar 
                        INNER JOIN users AS u ON ar.user_id = u.id 
                        INNER JOIN categories AS ca ON ar.category_id = ca.id 
                        ORDER BY ar.created_at DESC');
        return $this->db->fetchAll();
    }

    public function getArticleById($article_id)
    {
        $this->db->query('SELECT * FROM articles WHERE id = :id');
        $this->db->bind(':id', $article_id);
        return $this->db->fetch();
    }

    public function getCreatedUserId($article_id)
    {
        $this->db->query('SELECT user_id FROM articles WHERE id = :id');
        $this->db->bind(':id', $article_id);
        return $this->db->fetch();
    }

    public function add($data)
    {
        $this->db->query('INSERT INTO articles (title, content, category_id, user_id) 
                        VALUES (:title, :content, :category_id, :user_id)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':user_id', getLogginId());
        $this->db->fetch();
        $count = $this->db->rowCount();
        return ($count > 0);
    }

    public function update($data)
    {
        $this->db->query('UPDATE articles 
                        SET title = :title, content = :content, category_id = :category_id 
                        WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':user_id', getLogginId());
        $this->db->fetch();
        $count = $this->db->rowCount();
        return ($count > 0);
    }

    public function delete($article_id)
    {
        $this->db->query('DELETE FROM articles WHERE id = :id');
        $this->db->bind(':id', $article_id);
        return (($this->db->execute()) ? true : false);
    }

    public function checkExistsArticleInCategoryId($category_id)
    {
        $this->db->query('SELECT category_id FROM articles WHERE category_id = :category_id LIMIT 1');
        $this->db->bind(':category_id', $category_id);
        $this->db->fetch();
        $count = $this->db->rowCount();
        return ($count > 0);
    }
}

?>