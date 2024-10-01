<?php

declare(strict_types=1);

namespace App\Enum;

enum MediaTypeEnum: string
{
    case MOVIE = 'movie';
    case SERIES = 'series';
    case DOCUMENTARY = 'documentary';
    case ANIMATION = 'animation';
    case SHORTFILM = 'shortfilm';
    case LIVE_EVENT = 'live-event';
}
