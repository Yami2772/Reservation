<?php

namespace App\Enums;

enum LoginType: string
{
    case with_password = 'with_password';
    case code_request = 'code_request';
    case code_confirm = 'code_confirm';
}
