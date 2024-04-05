<?php

namespace App\Enums;

//Статусы заказа
enum StateEnum: int
{
    case Cancelled = -1;
    case New = 0;
    case Approved = 1;
}
