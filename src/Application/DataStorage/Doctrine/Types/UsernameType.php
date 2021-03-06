<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */

namespace Ads\Application\DataStorage\Doctrine\Types;

use Ads\CodeList\Posters\Username;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

class UsernameType extends StringType
{
    /**
     * @param mixed $value
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof Username) {
            return (string)$value;
        }
        if (\is_string($value)) {
            return $value;
        }
        throw ConversionException::conversionFailedInvalidType(
            $value,
            'Username',
            ['null', 'string', Username::class]
        );
    }

    /**
     * @param mixed $value
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Username
    {
        if (empty($value)) {
            return null;
        }
        try {
            return new Username($value);
        } catch (InvalidArgumentException $exception) {
            throw ConversionException::conversionFailed($exception->getMessage(), 'Username');
        }
    }
}
