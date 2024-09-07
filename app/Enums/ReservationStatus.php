<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case paid = 'paid';
    case InCart = 'InCart';
}
