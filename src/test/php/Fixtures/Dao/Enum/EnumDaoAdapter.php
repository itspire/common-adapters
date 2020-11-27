<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Fixtures\Dao\Enum;

use Itspire\Common\Adapter\Dao\Enum\AbstractEnumDaoAdapter;
use Itspire\Common\Adapter\Tests\Fixtures\Business\Model\Enum\BusinessEnum;

class EnumDaoAdapter extends AbstractEnumDaoAdapter
{
    public function getBusinessClass(): string
    {
        return BusinessEnum::class;
    }
}
