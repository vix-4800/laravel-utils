<?php

namespace Vix\LaravelUtils\Enums;

enum Currency: string
{
    case USD = '$';
    case EUR = '€';
    case GBP = '£';
    case INR = '₹';
    case CNY = '¥';
    case JPY = '¥';
}
