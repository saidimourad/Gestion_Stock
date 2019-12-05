<?php


namespace App\Entity;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;


class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "le mot de passe actuel incorrect"
     * )
     * @Assert\NotBlank(message="le mot de passe est obligatoire")
     */

    protected $oldPassword;
    /**
     * @Assert\NotBlank(message="le mot de passe est obligatoire")

     */
    protected $password;


    function getOldPassword() {
        return $this->oldPassword;
    }

    function getPassword() {
        return $this->password;
    }

    function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    function setPassword($password) {
        $this->password = $password;
        return $this;
    }
}