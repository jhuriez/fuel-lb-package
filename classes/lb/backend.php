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
        $onlyGroup = (isset($options['onlyGroup'])) ? (array)$options['onlyGroup'] : false;
        $toggleStatus = (isset($options['toggleStatus'])) ? $options['toggleStatus'] : null;

        // Gestion permission groupe
        if ($onlyGroup)
        {
            $user = \Model\Auth_User::find(\Auth::get('id'));
            if ( ! $user || ! in_array($user->group->name, $onlyGroup))
                return '';
        }

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

                // Onclick delete
                $attr['onclick'] = "return confirm('Etes vous sûre de vouloir supprimer ?');";
                break;

            case 'toggle-active':
                if ($toggleStatus)
                {
                    $class .= ' btn-success';
                    ! $title and $title = 'Cliquez pour désactiver';
                    $icon or $icon = 'fa-check'; 
                }
                else
                {
                    $class .= ' btn-danger';
                    ! $title and $title = 'Cliquez pour activer';
                    $icon or $icon = 'fa-close';
                }

                break;

            case 'view':
                $class .= ' btn-info';
                ! $title and $title = 'Voir';
                $icon or $icon = 'fa-search';
                break;
        }

        $res = '<a href="'.$url.'"';

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