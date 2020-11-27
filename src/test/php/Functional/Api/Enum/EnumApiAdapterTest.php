<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Functional\Api\Enum;

use Itspire\Common\Adapter\Tests\Fixtures\Api\Enum\EnumApiAdapter;
use Itspire\Common\Adapter\Tests\Fixtures\Api\Model\Enum\SerializableEnum;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\Enum\BusinessEnum;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

class EnumApiAdapterTest extends TestCase
{
    private static ?TranslatorInterface $translator = null;
    private ?BusinessEnum $businessEnum = null;
    private ?SerializableEnum $apiEnum = null;
    private ?EnumApiAdapter $enumApiAdapter = null;

    public static function setUpBeforeClass(): void
    {
        if (null === self::$translator) {
            self::$translator = new Translator('en');
            self::$translator->addLoader('yml', new YamlFileLoader());

            $finder = new Finder();
            $finder->files()->in(realpath('src/test/resources/translations'));

            foreach ($finder as $file) {
                $fileNameParts = explode('.', $file->getFilename());
                self::$translator->addResource('yml', $file->getRealPath(), $fileNameParts[1], $fileNameParts[0]);
            }
        }
    }

    public static function tearDownAfterClass(): void
    {
        self::$translator = null;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->businessEnum = new BusinessEnum(BusinessEnum::TEST);

        $this->apiEnum = (new SerializableEnum())
            ->setCode('TEST')
            ->setDescription('My test enumeration value description');

        $this->enumApiAdapter = new EnumApiAdapter(self::$translator);
    }

    protected function tearDown(): void
    {
        unset($this->enumApiAdapter, $this->businessEnum, $this->apiEnum);

        parent::tearDown();
    }

    /** @test */
    public function adaptBusinessToApiTest(): void
    {
        static::assertEquals($this->apiEnum, $this->enumApiAdapter->adaptBusinessToApi($this->businessEnum));
    }

    /** @test */
    public function adaptApiToBusinessTest(): void
    {
        static::assertEquals($this->businessEnum, $this->enumApiAdapter->adaptApiToBusiness($this->apiEnum));
    }
}
