<?php
namespace src\entity;

use config\AbstractEntity;
use src\entity\AttributeTrait;

class User extends AbstractEntity{
    use AttributeTrait;
    private $email = "";
    private $password = "";
    private $name = "";
    private $address = "";
    private $roles = "visitor";
    private $removed = "";



    /**
     * Get the value of email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @param string $address
     *
     * @return self
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of roles
     *
     * @return string
     */
    public function getRoles(): string
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     *
     * @param string $roles
     *
     * @return self
     */
    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the value of removed
     *
     * @return string
     */
    public function getRemoved(): string
    {
        return $this->removed;
    }

    /**
     * Set the value of removed
     *
     * @param string $removed
     *
     * @return self
     */
    public function setRemoved(string $removed): self
    {
        $this->removed = $removed;

        return $this;
    }
}