<?php

/**
 * Doctrine Extended Common
 *
 * @author Felipe Sayão Lobato Abreu <contato@felipeabreu.com.br>
 * @since 2015-08-19
 */
namespace Dx\Common\Persistence\Mapping\Column;

use DateTime;

/**
 * Class CreatedAwareTrait
 * @package Dx\Common\Persistence\Mapping\Column
 */
trait CreatedAwareTrait
{
    /**
     * @var DateTime
     */
    protected $created;

    /**
     * Sets a creation timestamp
     *
     * @param DateTime $created optional Creation DateTime. Left null for current timestamp.
     * @return $this
     */
    public function setCreated(DateTime $created = null)
    {
        if (!$created) {
            $created = new DateTime();
        }

        $this->created = $created;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        if (!$this->created) {
            $this->setCreated(null);
        }

        return $this->created;
    }
}