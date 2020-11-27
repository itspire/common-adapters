<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Dao;

use Itspire\Common\Collection\CollectionWrapperInterface;
use Itspire\Common\Util\EquatableInterface;

abstract class AbstractDaoAdapter implements DaoAdapterInterface, DaoListAdapterInterface
{
    final public function adaptDaoListToBusinessList(CollectionWrapperInterface $daoList): CollectionWrapperInterface
    {
        $this->supports(get_class($daoList));

        $businessListClass = $this->getBusinessListClass();
        /** @var CollectionWrapperInterface $businessListClass */
        $businessList = new $businessListClass($this->getBusinessClass());

        foreach ($daoList->getElements() as $daoObject) {
            $businessList->addElement($this->adaptDaoToBusiness($daoObject));
        }

        return $businessList;
    }

    final public function adaptDaoToBusiness(EquatableInterface $daoObject): EquatableInterface
    {
        $this->supports(get_class($daoObject));

        return $this->adaptDaoObject($daoObject);
    }

    final public function adaptBusinessListToDaoList(
        CollectionWrapperInterface $businessList
    ): CollectionWrapperInterface {
        $this->supports(get_class($businessList));

        $daoListClass = $this->getDaoListClass();
        $daoObjectClass = $this->getDaoClass();

        /** @var CollectionWrapperInterface $businessListClass */
        $daoList = new $daoListClass($daoObjectClass);

        foreach ($businessList->getElements() as $businessObject) {
            $daoObject = new $daoObjectClass();

            $this->adaptBusinessObject($businessObject, $daoObject);

            $daoList->addElement($daoObject);
        }

        return $daoList;
    }

    final public function adaptBusinessToDao(
        EquatableInterface $businessObject,
        EquatableInterface $daoObject
    ): void {
        $this->supports(get_class($businessObject));
        $this->supports(get_class($daoObject));

        $this->adaptBusinessObject($businessObject, $daoObject);
    }

    abstract protected function adaptDaoObject(EquatableInterface $daoObject): EquatableInterface;

    abstract protected function adaptBusinessObject(
        EquatableInterface $businessObject,
        EquatableInterface $daoObject
    ): void;

    final public function supports(string $class): void
    {
        $supportedClasses = [
            $this->getDaoListClass(),
            $this->getBusinessListClass(),
            $this->getDaoClass(),
            $this->getBusinessClass(),
        ];

        $isSupported = false;
        foreach ($supportedClasses as $supportedClass) {
            if (is_a($class, $supportedClass, true)) {
                $isSupported = true;
            }
        }

        if (false === $isSupported) {
            throw new \InvalidArgumentException(
                sprintf('Adapter %s does not support objects of type %s', static::class, $class)
            );
        }
    }
}
