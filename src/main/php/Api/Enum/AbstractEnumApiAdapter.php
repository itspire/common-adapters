<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Common\Adapter\Api\Enum;

use Itspire\Common\Adapter\Api\TranslatableApiAdapterInterface;
use Itspire\Common\Enum\EnumInterface;
use Itspire\Common\Serializer\Enum\SerializableEnumInterface;
use Itspire\Common\Util\EquatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractEnumApiAdapter implements TranslatableApiAdapterInterface
{
    protected ?TranslatorInterface $translator = null;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param SerializableEnumInterface $apiEnumObject
     * @return EnumInterface
     */
    final public function adaptApiToBusiness(EquatableInterface $serializableEnum): EquatableInterface
    {
        $this->supports(get_class($serializableEnum));

        /** @var EnumInterface $serializableEnumClass */
        $serializableEnumClass = $this->getBusinessClass();

        return $serializableEnumClass::resolveCode($serializableEnum->getCode());
    }

    /**
     * @param EnumInterface $businessEnum
     * @return SerializableEnumInterface
     */
    final public function adaptBusinessToApi(EquatableInterface $businessEnum): EquatableInterface
    {
        $this->supports(get_class($businessEnum));

        $serializableEnumClass = $this->getApiClass();
        /** @var SerializableEnumInterface $serializableEnum */
        $serializableEnum = new $serializableEnumClass();

        return $serializableEnum
            ->setCode($businessEnum->getCode())
            ->setDescription(
                null !== $this->getTranslationDomain()
                    ? $this->translator->trans($businessEnum->getDescription(), [], $this->getTranslationDomain())
                    : $businessEnum->getDescription()
            );
    }

    final public function supports(string $class): void
    {
        if (false === in_array($class, [$this->getApiClass(), $this->getBusinessClass()], true)) {
            throw new \InvalidArgumentException(sprintf('Adapter %s does not support %s class', static::class, $class));
        }
    }
}
