<?php
namespace src\observers;

use src\entity\User;

class UserSubject implements \splsubject{
    private $observers;
    private $user;

    public function __construct(User $user){
        $this->observers = new \SplObjectStorage();
        $this->user = $user;
    }

    public function attach(\SplObserver $observer) {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer) {
        $this->observers->detach($observer);
    }

    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    /**
     * Get the value of user
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @param User $user
     *
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}