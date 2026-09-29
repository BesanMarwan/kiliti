<?php

namespace App\Enums;

enum FamilyRelationship: string
{
    case FATHER = 'father';
    case MOTHER = 'mother';
    case BROTHER = 'brother';
    case SISTER = 'sister';
    case SON = 'son';
    case DAUGHTER = 'daughter';
    case HUSBAND = 'husband';
    case WIFE = 'wife';
    case OTHER = 'other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function labelAr(): string
    {
        return match ($this) {
            self::FATHER => 'الأب',
            self::MOTHER => 'الأم',
            self::BROTHER => 'الأخ',
            self::SISTER => 'الأخت',
            self::SON => 'الابن',
            self::DAUGHTER => 'الابنة',
            self::HUSBAND => 'الزوج',
            self::WIFE => 'الزوجة',
            self::OTHER => 'أخرى',
        };
    }

    public function labelEn(): string
    {
        return match ($this) {
            self::FATHER => 'Father',
            self::MOTHER => 'Mother',
            self::BROTHER => 'Brother',
            self::SISTER => 'Sister',
            self::SON => 'Son',
            self::DAUGHTER => 'Daughter',
            self::HUSBAND => 'Husband',
            self::WIFE => 'Wife',
            self::OTHER => 'Other',
        };
    }

    public function labels(): array
    {
        return [
            'value' => $this->value,
            'label_ar' => $this->labelAr(),
            'label_en' => $this->labelEn(),
        ];
    }
}
