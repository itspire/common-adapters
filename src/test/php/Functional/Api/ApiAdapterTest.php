<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Functional\Api;

use Itspire\Common\Adapter\Tests\Fixtures\Api\ApiAdapter;
use Itspire\Common\Adapter\Tests\Fixtures\Api\Model\ApiList;
use Itspire\Common\Adapter\Tests\Fixtures\Api\Model\ApiObject;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\BusinessList;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\BusinessObject;
use Itspire\Common\Collection\CollectionWrapperInterface;
use Itspire\Common\Util\EquatableInterface;
use PHPUnit\Framework\TestCase;

class ApiAdapterTest extends TestCase
{
    private ?EquatableInterface $businessObject = null;
    private ?CollectionWrapperInterface $businessList = null;
    private ?EquatableInterface $apiObject = null;
    private ?CollectionWrapperInterface $apiList = null;
    private ?ApiAdapter $apiAdapter = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->businessObject = (new BusinessObject())->setCode('TEST');
        $this->businessList = (new BusinessList(BusinessObject::class))->addElement($this->businessObject);

        $this->apiObject = (new ApiObject())->setCode('TEST');
        $this->apiList = (new ApiList(ApiObject::class))->addElement($this->apiObject);

        $this->apiAdapter = new ApiAdapter();
    }

    protected function tearDown(): void
    {
        unset(
            $this->apiAdapter,
            $this->businessList,
            $this->apiList,
            $this->businessObject,
            $this->apiObject
        );

        parent::tearDown();
    }

    /** @test */
    public function adaptBusinessToApiTest(): void
    {
        static::assertEquals($this->apiObject, $this->apiAdapter->adaptBusinessToApi($this->businessObject));
    }

    /** @test */
    public function adaptBusinessListToApiListTest(): void
    {
        static::assertEquals($this->apiList, $this->apiAdapter->adaptBusinessListToApiList($this->businessList));
    }

    /** @test */
    public function adaptApiToBusinessTest(): void
    {
        static::assertEquals($this->businessObject, $this->apiAdapter->adaptApiToBusiness($this->apiObject));
    }

    /** @test */
    public function adaptApiListToBusinessListTest(): void
    {
        static::assertEquals($this->businessList, $this->apiAdapter->adaptApiListToBusinessList($this->apiList));
    }
}
