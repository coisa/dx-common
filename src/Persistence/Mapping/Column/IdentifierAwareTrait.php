<?php

/**
 * Doctrine Extended Common
 *
 * @author Felipe Sayão Lobato Abreu <contato@felipeabreu.com.br>
 * @since 2015-08-19
 */
namespace Dx\Common\Persistence\Mapping\Column;

/**
 * Class IdentifierAwareTrait
 * @package Dx\Common\Persistence\Mapping\Column
 */
trait IdentifierAwareTrait
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Set the identifier value
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}