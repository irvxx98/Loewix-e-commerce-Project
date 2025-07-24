<?php

namespace App\Enums;

enum OrderDealerAssignmentStatus: string
{
    case OFFERED = 'offered';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case TIMED_OUT = 'timed_out';
}
