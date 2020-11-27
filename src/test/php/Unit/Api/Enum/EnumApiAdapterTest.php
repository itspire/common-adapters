<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Unit\Api\Enum;

use Itspire\Common\Adapter\Tests\Fixtures\Api\Enum\EnumApiAdapter;
use Itspire\Common\Adapter\Tests\Fixtures\Api\Model\Enum\SerializableEnum;
use Itspire\Common\Adapter\Tests\Fixtures\Api\Model\Enum\DummySerializableEnum;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\Enum\BusinessEnum;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\Enum\DummyEnum;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

class EnumApiAdapterTest extends TestCase
{
    /** @var MockObject|TranslatorInterface $translatorMock */
    private $translatorMock;
    private ?BusinessEnum $businessEnum = null;
    private ?SerializableEnum $apiEnum = null;
    private ?EnumApiAdapter $enumApiAdapter = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->businessEnum = new BusinessEnum(BusinessEnum::TEST);

        $this->apiEnum = (new SerializableEnum())
            ->setCode('TEST')
            ->setDescription('My test enumeration value description');

        $this->translatorMock = $this->getMockBuilder(TranslatorInterface::class)->getMock();

        $this->enumApiAdapter = new EnumApiAdapter($this->translatorMock);
    }

    protected function tearDown(): void
    {
        unset($this->enumApiAdapter, $this->translatorMock, $this->businessEnum, $this->apiEnum);

        parent::tearDown();
    }

    /** @test */
    public function adaptBusinessToApiWithUnsupportedClassTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Adapter %s does not support %s class', EnumApiAdapter::class, DummyEnum::class)
        );

        $this->enumApiAdapter->adaptBusinessToApi(new DummyEnum(DummyEnum::TEST));
    }

    /** @test */
    public function adaptApiToBusinessWithUnsupportedClassTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Adapter %s does not support %s class', EnumApiAdapter::class, DummySerializableEnum::class)
        );

        $this->enumApiAdapter->adaptApiToBusiness(new DummySerializableEnum());
    }

    /** @test */
    public function adaptBusinessToApiTest(): void
    {
        $this->translatorMock
            ->expects(static::once())
            ->method('trans')
            ->with($this->businessEnum->getDescription(), [], 'enums')
            ->willReturn($this->apiEnum->getDescription());

        static::assertEquals($this->apiEnum, $this->enumApiAdapter->adaptBusinessToApi($this->businessEnum));
    }

    /** @test */
    public function adaptApiToBusinessTest(): void
    {
        static::assertEquals($this->businessEnum, $this->enumApiAdapter->adaptApiToBusiness($this->apiEnum));
    }
}
