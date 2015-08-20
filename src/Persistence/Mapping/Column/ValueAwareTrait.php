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
 * Class ValueAwareTrait
 * @package Dx\Common\Persistence\Mapping\Column
 */
trait ValueAwareTrait
{
    /**
     * @var float
     */
    protected $value;

    /**
     * Set a rounded 2 float value
     *
     * @param $modified Modification DateTime. Left null for current timestamp.
     * @return $this
     */
    public function setValue($value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('The field value expects a numeric type');
        }

        $this->value = round($value, 2);

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return round($this->value, 2);
    }
}