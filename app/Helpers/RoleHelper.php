<?php

namespace App\Helpers;

class RoleHelper
{
    public static function getUserRole()
    {
        $userData = session('user_data');
        if ($userData && isset($userData['user']['staff_dept'])) {
            return strtolower($userData['user']['staff_dept']);
        }
        return null;
    }
    
    public static function isCTO()
    {
        return self::getUserRole() === 'cto';
    }
    
    public static function isCX()
    {
        return self::getUserRole() === 'cx';
    }
    
    public static function canDelete()
    {
        // CX users cannot delete
        return !self::isCX();
    }
}