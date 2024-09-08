<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case paid = 'paid';
    case waiting_for_payment = 'waiting for payment';
}
