<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Fixtures\Api;

use Itspire\Common\Adapter\Api\AbstractApiAdapter;
use Itspire\Common\Adapter\Tests\Fixtures\Api\Model\ApiList;
use Itspire\Common\Adapter\Tests\Fixtures\Api\Model\ApiObject;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\BusinessList;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\BusinessObject;
use Itspire\Common\Util\EquatableInterface;

class ApiAdapter extends AbstractApiAdapter
{
    /** @param ApiObject $apiObject */
    protected function adaptApiObject(EquatableInterface $apiObject): EquatableInterface
    {
        return (new BusinessObject())->setCode($apiObject->getCode());
    }

    /** @param BusinessObject $businessObject */
    protected function adaptBusinessObject(EquatableInterface $businessObject): EquatableInterface
    {
        return (new ApiObject())->setCode($businessObject->getCode());
    }

    public function getBusinessClass(): string
    {
        return BusinessObject::class;
    }

    public function getBusinessListClass(): string
    {
        return BusinessList::class;
    }

    public function getApiClass(): string
    {
        return ApiObject::class;
    }

    public function getApiListClass(): string
    {
        return ApiList::class;
    }
}
