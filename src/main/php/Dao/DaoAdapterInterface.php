<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Dao;

use Itspire\Common\Adapter\AdapterInterface;
use Itspire\Common\Util\EquatableInterface;

interface DaoAdapterInterface extends AdapterInterface
{
    public function adaptDaoToBusiness(EquatableInterface $daoObject): EquatableInterface;

    public function adaptBusinessToDao(EquatableInterface $businessObject, EquatableInterface $daoObject): void;

    /** @return string Fully qualified Dao class name */
    public function getDaoClass(): string;
}
