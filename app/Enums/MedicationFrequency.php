<?php

namespace App\Enums;

enum MedicationFrequency: string
{
    case ONCE_DAILY = 'once_daily';
    case TWICE_DAILY = 'twice_daily';
    case THREE_TIMES_DAILY = 'three_times_daily';
    case FOUR_TIMES_DAILY = 'four_times_daily';

    case EVERY_12_HOURS = 'every_12_hours';
    case EVERY_8_HOURS = 'every_8_hours';
    case EVERY_6_HOURS = 'every_6_hours';

    case AS_NEEDED = 'as_needed';

    public function label(): string
    {
        return match ($this) {
            self::ONCE_DAILY => 'مرة يوميًا',
            self::TWICE_DAILY => 'مرتين يوميًا',
            self::THREE_TIMES_DAILY => '3 مرات يوميًا',
            self::FOUR_TIMES_DAILY => '4 مرات يوميًا',

            self::EVERY_12_HOURS => 'كل 12 ساعة',
            self::EVERY_8_HOURS => 'كل 8 ساعات',
            self::EVERY_6_HOURS => 'كل 6 ساعات',

            self::AS_NEEDED => 'عند الحاجة',
        };
    }
}
