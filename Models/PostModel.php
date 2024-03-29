<?php

namespace App\Models;

class PostModel extends Model
{
    protected $id_post;
    protected $user_id;
    protected $post_title;
    protected $post_chapo;
    protected $post_content;
    protected $post_image;
    protected $post_createdAt;
    protected $post_updatedAt;

    public function __construct()
    {
        $this->table = 'post';
    }

    //Correction ordre decroissant
    public function findAllPost() {
        return $this->request("SELECT * FROM $this->table ORDER BY post_createdAt DESC")->fetchAll();
    }

    public function findPostWithAuthor(int $id)
    {
        return $this->request("SELECT * FROM post LEFT JOIN user 
                            ON user.id = post.user_id WHERE post.id_post = ?", [$id])->fetch();
    }

    //Correction ordre decroissant
    public function findPostWithComment(int $id)
    {
        return $this->request("SELECT * FROM comment LEFT JOIN user
                            ON user.id = comment.user_id WHERE comment.id_post = ? AND comment.comment_active = 1 ORDER BY comment_createdAt DESC;", [$id])->fetchAll();
    }

    public function findById(int $id)
    {
        return $this->request("SELECT * FROM $this->table WHERE id_post = $id")->fetch();
    }

    public function deleteWithComment(int $id)
    {
        return $this->request("DELETE post FROM post WHERE post.id_post = ?", [$id]);
    }

    /**
     * Get the value of id_post
     */
    public function getId_post()
    {
        return $this->id_post;
    }

    /**
     * Set the value of id_post
     *
     * @return  self
     */
    public function setId_post($id_post)
    {
        $this->id_post = $id_post;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of post_title
     */
    public function getPost_title()
    {
        return $this->post_title;
    }

    /**
     * Set the value of post_title
     *
     * @return  self
     */
    public function setPost_title($post_title)
    {
        $this->post_title = $post_title;

        return $this;
    }

    /**
     * Get the value of post_chapo
     */
    public function getPost_chapo()
    {
        return $this->post_chapo;
    }

    /**
     * Set the value of post_chapo
     *
     * @return  self
     */
    public function setPost_chapo($post_chapo)
    {
        $this->post_chapo = $post_chapo;

        return $this;
    }

    /**
     * Get the value of post_content
     */
    public function getPost_content()
    {
        return $this->post_content;
    }

    /**
     * Set the value of post_content
     *
     * @return  self
     */
    public function setPost_content($post_content)
    {
        $this->post_content = $post_content;

        return $this;
    }

    /**
     * Get the value of post_image
     */
    public function getPost_image()
    {
        return $this->post_image;
    }

    /**
     * Set the value of post_image
     *
     * @return  self
     */
    public function setPost_image($post_image)
    {
        $this->post_image = $post_image;

        return $this;
    }

    /**
     * Get the value of post_createdAt
     */
    public function getPost_createdAt()
    {
        return $this->post_createdAt;
    }

    /**
     * Set the value of post_createdAt
     *
     * @return  self
     */
    public function setPost_createdAt($post_createdAt)
    {
        $this->post_createdAt = $post_createdAt;

        return $this;
    }

    /**
     * Get the value of post_updatedAt
     */
    public function getPost_updatedAt()
    {
        return $this->post_updatedAt;
    }

    /**
     * Set the value of post_updatedAt
     *
     * @return  self
     */
    public function setPost_updatedAt($post_updatedAt)
    {
        $this->post_updatedAt = $post_updatedAt;

        return $this;
    }
}
