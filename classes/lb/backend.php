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


    public static function getBtn($type, $url, $options = array())
    {
        // Default options
        $useTooltip = (isset($options['use_tooltip'])) ? $options['use_tooltip'] : true;
        $title = (isset($options['title'])) ? $options['title'] : false;
        $id = (isset($options['id'])) ? $options['id'] : false;
        $moreClasses = (isset($options['class'])) ? $options['class'] : '';
        $attr = (isset($options['attr'])) ? $options['attr'] : array();
        $icon = (isset($options['icon'])) ? $options['icon'] : false;

        $res = '<a href="'.$url.'"';

        // By type
        $class = 'btn btn-circle';
        switch($type)
        {
            case 'add':
                $class .= ' btn-success';
                ! $title and $title = 'Ajouter';
                $icon or $icon = 'fa-plus';

                break;

            case 'edit':
                $class .= ' btn-warning';
                ! $title and $title = 'Modifier';
                $icon or $icon = 'fa-pencil';
                break;

            case 'delete':
                $class .= ' btn-danger';
                ! $title and $title = 'Supprimer';
                $icon or $icon = 'fa-trash-o';
                break;

            case 'view':
                $class .= ' btn-info';
                ! $title and $title = 'Voir';
                $icon or $icon = 'fa-search';
                break;
        }

        // Link class
        $class .= ' '.$moreClasses;
        $res .= ' class="'.$class.'"';

        // Id
        $id and $res .= ' id="'.$id.'"';

        // Tooltip
        $useTooltip and $res .= ' data-toggle="tooltip"';

        // Title
        $title and $res .= ' title="'.$title.'"';

        // Attr
        foreach($attr as $k => $v)
        {
            $res .= ' '.$k.'="'.$v.'"';
        }

        // Icon
        $icon = '<i class="fa fa-lg '.$icon.'"></i>';

        $res .= '>'.$icon.'</a>';

        return $res;
    }
}