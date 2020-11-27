<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Dao\Enum;

use Itspire\Common\Enum\EnumInterface;

abstract class AbstractEnumDaoAdapter implements EnumDaoAdapterInterface
{
    /** @param mixed $daoEnumValue */
    public function adaptDaoToBusiness($daoEnumValue): EnumInterface
    {
        /** @var EnumInterface $businessEnumClass */
        $businessEnumClass = $this->getBusinessClass();

        return $businessEnumClass::resolveValue($daoEnumValue);
    }

    /** @return mixed */
    public function adaptBusinessToDao(EnumInterface $businessEnum)
    {
        $this->supports(get_class($businessEnum));

        return $businessEnum->getValue();
    }

    final public function supports(string $class): void
    {
        if ($class !== $this->getBusinessClass()) {
            throw new \InvalidArgumentException(sprintf('Adapter %s does not support %s class', static::class, $class));
        }
    }
}
