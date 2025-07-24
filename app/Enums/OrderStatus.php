<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING_PAYMENT = 'pending_payment';
    case PENDING_DEALER_ACCEPTANCE = 'pending_dealer_acceptance';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case SEARCHING_NEW_DEALER = 'searching_new_dealer';
}