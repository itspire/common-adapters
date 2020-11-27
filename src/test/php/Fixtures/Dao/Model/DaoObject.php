<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Tests\Fixtures\Dao\Model;

use Itspire\Common\Util\EquatableInterface;
use Itspire\Common\Util\EquatableTrait;

class DaoObject implements EquatableInterface
{
    use EquatableTrait;

    private ?string $code = null;

    public function getUniqueIdentifier(): string
    {
        return $this->code;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
