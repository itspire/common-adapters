<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Fixtures\Dao;

use Itspire\Common\Adapter\Dao\AbstractDaoAdapter;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\BusinessList;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\BusinessObject;
use Itspire\Common\Adapter\Tests\Fixtures\Dao\Model\DaoList;
use Itspire\Common\Adapter\Tests\Fixtures\Dao\Model\DaoObject;
use Itspire\Common\Util\EquatableInterface;

class DaoAdapter extends AbstractDaoAdapter
{
    protected function adaptDaoObject(EquatableInterface $apiObject): EquatableInterface
    {
        /** @var DaoObject $apiObject */
        return (new BusinessObject())->setCode($apiObject->getCode());
    }

    protected function adaptBusinessObject(EquatableInterface $businessObject, EquatableInterface $daoObject): void
    {
        $daoObject->setCode($businessObject->getCode());
    }

    public function getBusinessClass(): string
    {
        return BusinessObject::class;
    }

    public function getBusinessListClass(): string
    {
        return BusinessList::class;
    }

    public function getDaoClass(): string
    {
        return DaoObject::class;
    }

    public function getDaoListClass(): string
    {
        return DaoList::class;
    }
}
