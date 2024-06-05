<?php

namespace App\Constants;


class TaskConstants{

    const Top = 1;
    const Down = 2;


    public static function getAllPriorities(){
        return [
            self::Top => '#1',
            self::Down => '#2'
        ];
    }

    public static function getPrioritiesBadges(){
            return [
                self::Top => "badge rounded-pill bg-danger",
                self::Down => "badge rounded-pill bg-primary"
            ];
    }  
    
    
    public static function getPriorityBadge($priority){
        return   self::getPrioritiesBadges()[$priority];
    }
 
}