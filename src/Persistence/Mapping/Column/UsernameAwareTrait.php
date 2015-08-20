<?php

/**
 * Doctrine Extended Common
 *
 * @author Felipe Sayão Lobato Abreu <contato@felipeabreu.com.br>
 * @since 2015-08-19
 */
namespace Dx\Common\Persistence\Mapping\Column;

/**
 * Class UsernameAwareTrait
 * @package Dx\Common\Persistence\Mapping\Column
 */
trait UsernameAwareTrait
{
    /**
     * @var string
     */
    protected $username;

    /**
     * Sets a string not empty username to column
     *
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        if (!is_string($username)) {
            throw new \InvalidArgumentException('The username needs to be a string');
        }

        $username = trim($username);

        if (empty($username)) {
            throw new \InvalidArgumentException('The username can not be left empty');
        }

        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}