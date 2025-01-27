<?php

namespace App\Core\Enums;

enum Operation: string {
    case AND = 'AND';
    case OR = 'OR';
    case LIKE = 'LIKE';
}