<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Unit\Dao;

use Itspire\Common\Adapter\Tests\Fixtures\Business\Model as BusinessModel;
use Itspire\Common\Adapter\Tests\Fixtures\Dao\DaoAdapter;
use Itspire\Common\Adapter\Tests\Fixtures\Dao\Model as DaoModel;
use Itspire\Common\Collection\CollectionWrapperInterface;
use Itspire\Common\Util\EquatableInterface;
use PHPUnit\Framework\TestCase;

class DaoAdapterTest extends TestCase
{
    private ?EquatableInterface $businessObject = null;
    private ?CollectionWrapperInterface $businessList = null;
    private ?EquatableInterface $daoObject = null;
    private ?CollectionWrapperInterface $daoList = null;
    private ?DaoAdapter $daoAdapter = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->businessObject = (new BusinessModel\BusinessObject())->setCode('TEST');
        $this->businessList = (new BusinessModel\BusinessList(BusinessModel\BusinessObject::class))
            ->addElement($this->businessObject);

        $this->daoObject = (new DaoModel\DaoObject())->setCode('TEST');
        $this->daoList = (new DaoModel\DaoList(DaoModel\DaoObject::class))->addElement($this->daoObject);

        $this->daoAdapter = new DaoAdapter();
    }

    protected function tearDown(): void
    {
        unset(
            $this->daoAdapter,
            $this->businessList,
            $this->daoList,
            $this->businessObject,
            $this->daoObject
        );

        parent::tearDown();
    }

    /** @test */
    public function adaptBusinessToDaoWithUnsupportedClassTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Adapter %s does not support objects of type %s',
                DaoAdapter::class,
                BusinessModel\DummyBusinessObject::class
            )
        );

        $this->daoAdapter->adaptBusinessToDao(new BusinessModel\DummyBusinessObject(), new DaoModel\DaoObject());
    }

    /** @test */
    public function adaptBusinessListToDaoListWithUnsupportedClassTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Adapter %s does not support objects of type %s',
                DaoAdapter::class,
                BusinessModel\DummyBusinessList::class
            )
        );

        $this->daoAdapter->adaptBusinessListToDaoList(
            new BusinessModel\DummyBusinessList(BusinessModel\DummyBusinessObject::class)
        );
    }

    /** @test */
    public function adaptDaoToBusinessWithUnsupportedClassTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Adapter %s does not support objects of type %s', DaoAdapter::class, DaoModel\DummyDaoObject::class)
        );

        $this->daoAdapter->adaptDaoToBusiness(new DaoModel\DummyDaoObject());
    }

    /** @test */
    public function adaptDaoListToBusinessListWithUnsupportedClassTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Adapter %s does not support objects of type %s',
                DaoAdapter::class,
                DaoModel\DummyDaoList::class
            )
        );

        $this->daoAdapter->adaptDaoListToBusinessList(new DaoModel\DummyDaoList(DaoModel\DummyDaoObject::class));
    }

    /** @test */
    public function adaptBusinessToDaoTest(): void
    {
        $this->daoAdapter->adaptBusinessToDao($this->businessObject->setCode('TEST2'), $this->daoObject);

        static::assertEquals('TEST2', $this->daoObject->getCode());
    }

    /** @test */
    public function adaptBusinessListToDaoListTest(): void
    {
        $daoList = $this->daoAdapter->adaptBusinessListToDaoList($this->businessList);

        static::assertCount(1, $daoList->getElements());
        static::assertTrue($this->daoObject->equals($daoList->getElements()->first()));
    }

    /** @test */
    public function adaptDaoToBusinessTest(): void
    {
        $businessObject = $this->daoAdapter->adaptDaoToBusiness($this->daoObject);

        static::assertTrue($this->businessObject->equals($businessObject));
    }

    /** @test */
    public function adaptDaoListToBusinessListTest(): void
    {
        $businessList = $this->daoAdapter->adaptDaoListToBusinessList($this->daoList);

        static::assertCount(1, $businessList->getElements());
        static::assertTrue($this->businessObject->equals($businessList->getElements()->first()));
    }
}
