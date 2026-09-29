<?php

namespace App\Enums;

enum FamilyInvitationStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case EXPIRED = 'expired';
    case CANCELLED = 'cancelled';
}
