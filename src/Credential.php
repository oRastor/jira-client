<?php

namespace JiraClient;

/**
 * Description of Credential
 *
 * @author pbrasseur
 */
class Credential
{

    private $login;
    private $password;

    public function __construct($login = null, $password = null)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

}
