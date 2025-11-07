<?php

namespace App\Enums;

enum NotificationActionType: string
{
    case Reaction = 'reaction';
    case Comment = 'comment';
    case Follow = 'follow';
    case SpecialReaction = 'special_reaction';
    
}

