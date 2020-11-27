<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Fixtures\Api\Enum;

use Itspire\Common\Adapter\Api\Enum\AbstractEnumApiAdapter;
use Itspire\Common\Adapter\Tests\Fixtures\Api\Model\Enum\SerializableEnum;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\Enum\BusinessEnum;

class EnumApiAdapter extends AbstractEnumApiAdapter
{
    public function getBusinessClass(): string
    {
        return BusinessEnum::class;
    }

    public function getApiClass(): string
    {
        return SerializableEnum::class;
    }

    public function getTranslationDomain(): ?string
    {
        return 'enums';
    }
}
