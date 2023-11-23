<?php

namespace App\Enums;

enum TripStatus: string
{
    case NEW = 'New';
    case UPCOMING = 'Upcoming';
    case IN_PROGRESS = 'In Progress';
    case FINISHED = 'Finished';
    case CANCELLED = 'Cancelled';
    case PAY_PROCESSED = 'Pay Processed';
    case RESCHEDULED = 'Rescheduled';
}
