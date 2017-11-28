<?php

namespace Acme\StoreBundle\Entity;


class RegistrationTask {

    private $email;

    private $password;

    private $passwordRepeat;

    private $login;

    private $nickname;

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPasswordRepeat($value) {
        $this->passwordRepeat = $value;
    }

    public function getPasswordRepeat() {
        return $this->passwordRepeat;
    }

    public function setLogin($value) {
        $this->login = $value;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setNickname($value) {
        $this->nickname = $value;
    }

    public function getNickname() {
        return $this->nickname;
    }
}