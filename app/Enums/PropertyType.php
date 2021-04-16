<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Sale()
 * @method static static Rent()
 */
final class PropertyType extends Enum
{
    const Sale = 'sale';
    const Rent = 'rent';
}
