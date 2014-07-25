<?php

namespace Lb;

Class Backend 
{

    /**
     * Add asset file with theme structure 
     * @param array  $files  
     * @param string  $type  
     * @param string  $group 
     * @param string $theme  
     * @param boolean $casset
     * @param array   $attr  
     * @param boolean $raw  
     * @param string $pathName 
     */
    public static function addAsset($files, $type, $group, $theme = null, $casset = false, $attr = array(), $raw = false, $pathName = 'theme')
    {
        $group = (\Config::get('lb.theme.assets.'.$group) ? : $group);

        if ($casset)
        {
            $pathName = ($pathName == false) ? '' : $pathName . '::';
            foreach((array)$files as $file)
                \Casset::{$type}($pathName.$file, false, $group);
        }
        else
        {
            ($theme !== null) and $theme->asset->{$type}($files, $attr, $group, $raw);
        }
    }

}