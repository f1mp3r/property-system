<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Viewing()
 * @method static static Selling()
 */
final class AgentJobTypeEnum extends Enum
{
    const Viewing =   1;
    const Selling =   2;
}
