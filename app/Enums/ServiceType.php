<?php

namespace App\Enums;

enum ServiceType: string
{
    case pool = "pool";
    case football = "football";
    case footsal = "footsal";
    case volleyball = "valleyball";
    case basketball = "basketball";
    case tennis = "tennis";
    case ping_pong = "ping_pong";
    case martial = "martisal";
}
