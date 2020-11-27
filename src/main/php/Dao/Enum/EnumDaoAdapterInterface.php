<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Dao\Enum;

use Itspire\Common\Adapter\AdapterInterface;
use Itspire\Common\Enum\EnumInterface;

interface EnumDaoAdapterInterface extends AdapterInterface
{
    /** @param mixed $daoEnumValue */
    public function adaptDaoToBusiness($daoEnumValue): EnumInterface;

    /** @return mixed */
    public function adaptBusinessToDao(EnumInterface $businessEnum);
}
