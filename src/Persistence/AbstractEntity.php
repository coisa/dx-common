<?php

/**
 * Doctrine Extended Common
 *
 * @author Felipe Sayão Lobato Abreu <contato@felipeabreu.com.br>
 * @since 2015-08-19
 */
namespace Dx\Common\Persistence;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManagerAware;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Hydrator\HydratorAwareInterface;
use Zend\Stdlib\Hydrator\HydratorAwareTrait;

/**
 * Class AbstractEntity
 * @package Dx\Common\Persistence
 */
abstract class AbstractEntity implements ObjectManagerAware, ObjectManagerAwareInterface, HydratorAwareInterface, \ArrayAccess
{
    /** Traits */
    use ProvidesObjectManager, HydratorAwareTrait;

    /**
     * @var ClassMetadata|null
     */
    private $classMetadata = null;

    /**
     * Sets the class metadata for entity
     *
     * @param ClassMetadata $classMetadata
     */
    public function setClassMetadata(ClassMetadata $classMetadata)
    {
        $this->classMetadata = $classMetadata;
    }

    /**
     * @return ClassMetadata
     */
    public function getClassMetadata()
    {
        if ($this->classMetadata === null) {
            if (!$this->getObjectManager()) {
                throw new \RuntimeException("No runtime object manager set. Call AbstractEntity#setObjectManager().");
            }

            $this->classMetadata = $this->getObjectManager()->getClassMetadata(get_class($this));
        }

        return $this->classMetadata;
    }

    /**
     * Injects the Doctrine Object Manager.
     *
     * @param ObjectManager $objectManager
     * @param ClassMetadata $classMetadata
     * @return void
     */
    public function injectObjectManager(ObjectManager $objectManager, ClassMetadata $classMetadata)
    {
        $this->setObjectManager($objectManager);
        $this->setClassMetadata($classMetadata);
    }

    /**
     * Overwrite trait method to insert a default hydrator
     *
     * @return null|HydratorInterface
     */
    public function getHydrator()
    {
        if ($this->hydrator === null) {
            $this->setHydrator(new DoctrineObject($this->getObjectManager()));
        }

        return $this->hydrator;
    }

    /**
     * Hydrate the given data
     *
     * @param array $data
     * @return AbstractEntity
     */
    public function hydrate(array $data = array())
    {
        return $this->getHydrator()->hydrate($data, $this);
    }

    /**
     * Extract current entity data
     *
     * @return array
     */
    public function extract()
    {
        return $this->getHydrator()->extract($this);
    }

    /**
     * Converts entity to array
     *
     * @param int $maxDepth optional Max depth relations. Default is no one.
     * @return array
     */
    public function toArray($maxDepth = 0)
    {
        $data = $this->extract();

        foreach ($data as $fieldName => $value) {
            if ($this->getClassMetadata()->isCollectionValuedAssociation($fieldName)) {
                if (is_integer($maxDepth) && $maxDepth > 0) {
                    $data[$fieldName] = $value->toArray();

                    foreach ($data[$fieldName] as $assoc => $association) {
                        if ($association instanceof AbstractEntity) {
                            $data[$fieldName][$assoc] = $association->toArray($maxDepth - 1);
                        } else {
                            unset($data[$fieldName][$assoc]);
                        }
                    }
                } else {
                    unset($data[$fieldName]);
                }
            } else if ($this->getClassMetadata()->isSingleValuedAssociation($fieldName)) {
                if ($value instanceof AbstractEntity) {
                    $data[$fieldName] = $value->toArray($maxDepth - 1);
                } else {
                    unset($data[$fieldName]);
                }
            }
        }

        return $data;
    }

    /**
     * ArrayAccess Interface Method
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        $data = $this->extract();

        return isset($data[$offset]);
    }

    /**
     * ArrayAccess Interface Method
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $data = $this->extract();

        return $data[$offset];
    }

    /**
     * ArrayAccess Interface Method
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $method = 'set' . ucwords($offset);

        if (method_exists($this, $method)) {
            $this->$method($offset, $value);
        }
    }

    /**
     * ArrayAccess Interface Method
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        return $this->hydrate([$offset => null]);
    }
}