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
 * Class ModifiedAwareTrait
 * @package Dx\Common\Persistence\Mapping\Column
 */
trait ModifiedAwareTrait
{
    /**
     * @var DateTime
     */
    protected $modified;

    /**
     * Sets a modification timestamp
     *
     * @param DateTime $modified optional Modification DateTime. Left null for current timestamp.
     * @return $this
     */
    public function setModified(DateTime $modified = null)
    {
        if (!$modified) {
            $modified = new DateTime();
        }

        $this->modified = $modified;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getModified()
    {
        if (!$this->modified) {
            $this->setModified(null);
        }

        return $this->modified;
    }
}