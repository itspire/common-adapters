<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Api;

use Itspire\Common\Adapter\AdapterListInterface;
use Itspire\Common\Collection\CollectionWrapperInterface;

interface ApiListAdapterInterface extends AdapterListInterface
{
    public function adaptApiListToBusinessList(CollectionWrapperInterface $apiList): CollectionWrapperInterface;

    public function adaptBusinessListToApiList(CollectionWrapperInterface $businessList): CollectionWrapperInterface;

    /** @return string Fully qualified ApiList class name */
    public function getApiListClass(): string;
}
