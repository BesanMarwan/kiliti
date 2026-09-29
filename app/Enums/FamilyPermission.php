<?php

namespace App\Enums;

enum FamilyPermission: string
{
    case VIEW_MEDICATIONS = 'view_medications';
    case VIEW_DIALYSIS_SESSIONS = 'view_dialysis_sessions';
    case VIEW_FLUID_DATA = 'view_fluid_data';
    case VIEW_SYMPTOMS = 'view_symptoms';
    case VIEW_LABS = 'view_labs';
    case VIEW_MEASUREMENTS = 'view_measurements';
    case RECEIVE_ALERTS = 'receive_alerts';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
