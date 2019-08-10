<?php
namespace App\Helpers;

class Helpers {
    public static function setSelected($uriSegment){
        return request()->segment(1) == $uriSegment ? 'active' : '';
    }

}