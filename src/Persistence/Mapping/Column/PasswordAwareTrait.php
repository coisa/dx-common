<?php

/**
 * Doctrine Extended Common
 *
 * @author Felipe Sayão Lobato Abreu <contato@felipeabreu.com.br>
 * @since 2015-08-19
 */
namespace Dx\Common\Persistence\Mapping\Column;

/**
 * Class PasswordAwareTrait
 * @package Dx\Common\Persistence\Mapping\Column
 */
trait PasswordAwareTrait
{
    /**
     * @var string
     */
    protected $password;

    /**
     * Send encoded password to column
     *
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        if (!is_string($password)) {
            throw new \InvalidArgumentException('The password needs to be a string');
        }

        if (empty($password)) {
            throw new \InvalidArgumentException('The password can not be left empty');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($hashedPassword === false) {
            throw new \RuntimeException('The password could not be hashed');
        }

        $this->password = $hashedPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}