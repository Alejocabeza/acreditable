<?php

namespace App\Enum;

enum PeriodBudget: int
{
    case Day = 1;
    case Week = 2;
    case Month = 3;
    case Year = 4;
}
