<?php

namespace app\src\classes\modules\config;

class mysql
{
    private $host   = "";
    private $user     = "";
    private $password = "";
    private $database = "";

    public function __construct()
    {
        $this->Load();
    }

    private function Load()
    {

        if (!isset($_SESSION)) {
            @session_start();
        }

        $database = 'sicoficial_bd';
        $user     = 'sicoficial_admin';
        $password = '!Dlfs02**';
        $host     = '187.73.210.163';

        $this->setDatabase($database);
        $this->setUser($user);
        $this->setPassword($password);
        $this->setHost($host);
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @param string $database
     */
    public function setDatabase(string $database): void
    {
        $this->database = $database;
    }
}