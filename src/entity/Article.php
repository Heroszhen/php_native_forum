<?php
namespace src\entity;

use config\AbstractEntity;
use src\entity\AttributeTrait;

class Article extends AbstractEntity{
    use AttributeTrait;
    private $user_id = 0;
    private $category_id = 0;
    private $title = "";
    private $content = "";


    /**
     * Get the value of user_id
     *
     * @return int
     */
    public function getUser_id(): int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @param int $user_id
     *
     * @return self
     */
    public function setUser_id(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of category_id
     *
     * @return int
     */
    public function getCategory_id(): int
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param int $category_id
     *
     * @return self
     */
    public function setCategory_id(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param string $content
     *
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}