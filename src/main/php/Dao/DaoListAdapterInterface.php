<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Dao;

use Itspire\Common\Adapter\AdapterListInterface;
use Itspire\Common\Collection\CollectionWrapperInterface;

interface DaoListAdapterInterface extends AdapterListInterface
{
    public function adaptDaoListToBusinessList(CollectionWrapperInterface $daoList): CollectionWrapperInterface;

    public function adaptBusinessListToDaoList(CollectionWrapperInterface $businessList): CollectionWrapperInterface;

    /** @return string Fully qualified DaoList class name */
    public function getDaoListClass(): string;
}
