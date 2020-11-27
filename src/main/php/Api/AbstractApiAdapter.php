<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Api;

use Itspire\Common\Collection\CollectionWrapperInterface;
use Itspire\Common\Util\EquatableInterface;

abstract class AbstractApiAdapter implements ApiAdapterInterface, ApiListAdapterInterface
{
    final public function adaptApiListToBusinessList(CollectionWrapperInterface $apiList): CollectionWrapperInterface
    {
        $this->supports(get_class($apiList));

        $businessListClass = $this->getBusinessListClass();
        /** @var CollectionWrapperInterface $businessList */
        $businessList = new $businessListClass($this->getBusinessClass());

        foreach ($apiList->getElements() as $apiObject) {
            $businessList->addElement($this->adaptApiToBusiness($apiObject));
        }

        return $businessList;
    }

    final public function adaptApiToBusiness(EquatableInterface $apiObject): EquatableInterface
    {
        $this->supports(get_class($apiObject));

        return $this->adaptApiObject($apiObject);
    }

    final public function adaptBusinessListToApiList(
        CollectionWrapperInterface $businessList
    ): CollectionWrapperInterface {
        $this->supports(get_class($businessList));

        $apiListClass = $this->getApiListClass();
        /** @var CollectionWrapperInterface $businessList */
        $apiList = new $apiListClass($this->getApiClass());

        foreach ($businessList->getElements() as $businessObject) {
            $apiList->addElement($this->adaptBusinessToApi($businessObject));
        }

        return $apiList;
    }

    final public function adaptBusinessToApi(EquatableInterface $business): EquatableInterface
    {
        $this->supports(get_class($business));

        return $this->adaptBusinessObject($business);
    }

    abstract protected function adaptApiObject(EquatableInterface $apiObject): EquatableInterface;

    abstract protected function adaptBusinessObject(EquatableInterface $businessObject): EquatableInterface;

    final public function supports(string $class): void
    {
        $supportedClasses = [
            $this->getApiListClass(),
            $this->getBusinessListClass(),
            $this->getApiClass(),
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
