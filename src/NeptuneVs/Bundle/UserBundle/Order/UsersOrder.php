<?php

namespace NeptuneVs\Bundle\UserBundle\Order;

class UsersOrder {

    private $users;
    private $listReturn;

    public function __construct($users) {
        $this->users = $users;
        $this->listReturn = array();
    }

    public function listUserUnLocked() {
        $list = array();
        foreach ($this->users as $user) {
            if ($user->isEnabled() && !$user->isLocked()) {
                $list[] = $user;
            }
        }
        return $list;
    }

    public function listUserLocked() {
        $list = array();
        foreach ($this->users as $user) {
            if ($user->isEnabled() && $user->isLocked()) {
                $list[] = $user;
            }
        }
        return $list;
    }

    public function listUserInscription() {
        $list = array();
        foreach ($this->users as $user) {
            if (!$user->isEnabled()) {
                $list[] = $user;
            }
        }
        return $list;
    }

}