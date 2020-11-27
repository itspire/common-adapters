<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Functional\Dao\Enum;

use Itspire\Common\Adapter\Tests\Fixtures\Dao\Enum\EnumDaoAdapter;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\Enum\BusinessEnum;
use PHPUnit\Framework\TestCase;

class EnumDaoAdapterTest extends TestCase
{
    private ?BusinessEnum $businessEnum = null;
    private ?EnumDaoAdapter $enumDaoAdapter = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->businessEnum = new BusinessEnum(BusinessEnum::TEST);

        $this->enumDaoAdapter = new EnumDaoAdapter();
    }

    protected function tearDown(): void
    {
        unset($this->enumDaoAdapter, $this->businessEnum);

        parent::tearDown();
    }

    /** @test */
    public function adaptBusinessToDaoTest(): void
    {
        static::assertEquals(0, $this->enumDaoAdapter->adaptBusinessToDao($this->businessEnum));
    }

    /** @test */
    public function adaptDaoToBusinessTest(): void
    {
        $businessEnum = $this->enumDaoAdapter->adaptDaoToBusiness(0);

        static::assertEquals($this->businessEnum->getCode(), $businessEnum->getCode());
        static::assertEquals($this->businessEnum->getValue(), $businessEnum->getValue());
        static::assertEquals($this->businessEnum->getDescription(), $businessEnum->getDescription());
    }
}
