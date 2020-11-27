<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Api;

use Itspire\Common\Adapter\AdapterInterface;
use Itspire\Common\Util\EquatableInterface;

interface ApiAdapterInterface extends AdapterInterface
{
    public function adaptApiToBusiness(EquatableInterface $apiObject): EquatableInterface;

    public function adaptBusinessToApi(EquatableInterface $business): EquatableInterface;

    /** @return string Fully qualified Api class name */
    public function getApiClass(): string;
}
