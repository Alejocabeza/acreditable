<?php

namespace App\Enum;

enum TypeAccount: int
{
    case Efectivo = 1;
    case Monedero = 2;
    case Tarjeta = 3;
    case Banco = 4;
    case Inversion = 5;
}
