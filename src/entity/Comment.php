<?php
namespace src\entity;

use config\AbstractEntity;
use src\entity\AttributeTrait;

class Comment extends AbstractEntity{
    use AttributeTrait;
    private $user_id = 0;
    private $article_id = 0;
    private $content = "";

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     */
    public function setUser_id($user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of article_id
     */
    public function getArticle_id()
    {
        return $this->article_id;
    }

    /**
     * Set the value of article_id
     */
    public function setArticle_id($article_id): self
    {
        $this->article_id = $article_id;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     */
    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }
}