<?php
namespace App\Models;

class PostCommentModel extends Model
{
    protected $id_comment;
    protected $comment_content;
    protected $comment_active;
    protected $comment_createdAt;
    protected $comment_updatedAt;
    protected $post_id;
    protected $user_id;

    public function __construct()
    {
        $this->table = 'post_comment';
    }


    /**
     * Get the value of id_comment
     */ 
    public function getId_comment()
    {
        return $this->id_comment;
    }

    /**
     * Set the value of id_comment
     *
     * @return  self
     */ 
    public function setId_comment($id_comment)
    {
        $this->id_comment = $id_comment;

        return $this;
    }

    /**
     * Get the value of comment_content
     */ 
    public function getComment_content()
    {
        return $this->comment_content;
    }

    /**
     * Set the value of comment_content
     *
     * @return  self
     */ 
    public function setComment_content($comment_content)
    {
        $this->comment_content = $comment_content;

        return $this;
    }

    /**
     * Get the value of comment_active
     */ 
    public function getComment_active()
    {
        return $this->comment_active;
    }

    /**
     * Set the value of comment_active
     *
     * @return  self
     */ 
    public function setComment_active($comment_active)
    {
        $this->comment_active = $comment_active;

        return $this;
    }

    /**
     * Get the value of comment_createdAt
     */ 
    public function getComment_createdAt()
    {
        return $this->comment_createdAt;
    }

    /**
     * Set the value of comment_createdAt
     *
     * @return  self
     */ 
    public function setComment_createdAt($comment_createdAt)
    {
        $this->comment_createdAt = $comment_createdAt;

        return $this;
    }

    /**
     * Get the value of comment_updatedAt
     */ 
    public function getComment_updatedAt()
    {
        return $this->comment_updatedAt;
    }

    /**
     * Set the value of comment_updatedAt
     *
     * @return  self
     */ 
    public function setComment_updatedAt($comment_updatedAt)
    {
        $this->comment_updatedAt = $comment_updatedAt;

        return $this;
    }

    /**
     * Get the value of post_id
     */ 
    public function getPost_id()
    {
        return $this->post_id;
    }

    /**
     * Set the value of post_id
     *
     * @return  self
     */ 
    public function setPost_id($post_id)
    {
        $this->post_id = $post_id;

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
}