<?php
namespace src\entity;

trait AttributeTrait{
        private $id = null;
        private $created = "";

        /**
         * Get the value of id
         *
         * @return int
         */
        public function getId(): int|null
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @param int $id
         *
         * @return self
         */
        public function setId(int $id): self
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of created
         *
         * @return string
         */
        public function getCreated(): string
        {
                return $this->created;
        }

        /**
         * Set the value of created
         *
         * @param string $created
         *
         * @return self
         */
        public function setCreated(string $created): self
        {
                $this->created = $created;

                return $this;
        }
}