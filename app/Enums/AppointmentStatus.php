<?php

namespace App\Enums;

enum AppointmentStatus: String
{
    case PENDING = 'pending';
    case CONCLUDED = 'concluded';
    case IN_SERVICE = 'in_service';
    case OVERDUE = 'overdue';
}
