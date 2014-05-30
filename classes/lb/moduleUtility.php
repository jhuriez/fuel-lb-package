<?php

namespace Lb;

class ModuleUtility
{

    /**
     * Return all path variables for assets
     * @param  string $module
     * @return array         
     */
    public static function getThemeVars($module)
    {
        \Config::load('theme', 'theme');

        $vars = array(
            'publicPath' => DOCROOT.DS.'public',
            'assetFolder' => \Config::get('theme.assets_folder'),
            'activeTheme' => \Config::get('theme.active'),
        );     

        $vars['assetJsPath'] = $vars['publicPath'].DS.$vars['assetFolder'].DS.$vars['activeTheme'].DS.'js'.DS.'modules'.DS.$module;
        $vars['assetCssPath'] = $vars['publicPath'].DS.$vars['assetFolder'].DS.$vars['activeTheme'].DS.'css'.DS.'modules'.DS.$module;

        return $vars;
    }

    /**
     * Install asset from module
     * @param  string $module     
     * @param  string $moduleDir  
     * @param  string $publicPath 
     * @param  string $theme      
     * @return bool             
     */
    public static function installAsset($module, $moduleDir, $publicPath = null, $theme = null)
    {
        $vars = self::getThemeVars($module);

        // Public path specify
        if ($publicPath !== null && $publicPath !== 'null')
        {
            $oldPublicPath = $vars['publicPath'];
            $vars['publicPath'] = DOCROOT.DS.$publicPath;
            $vars['assetJsPath'] = str_replace($oldPublicPath, $vars['publicPath'], $vars['assetJsPath']);
            $vars['assetCssPath'] = str_replace($oldPublicPath, $vars['publicPath'], $vars['assetCssPath']);
        } 

        if ($theme !== null)
        {
            $vars['assetJsPath'] = str_replace($vars['activeTheme'], $theme, $vars['assetJsPath']);
            $vars['assetCssPath'] = str_replace($vars['activeTheme'], $theme, $vars['assetCssPath']);
        }
    
        if (is_dir($vars['publicPath'])) {
            // Create dir
            is_dir($vars['assetJsPath']) 
                or mkdir($vars['assetJsPath'], 0755, TRUE);

            is_dir($vars['assetCssPath']) 
                or mkdir($vars['assetCssPath'], 0755, TRUE);

            // Copy JS Assets
            is_dir($moduleDir.DS.'assets'.DS.'js') and \File::copy_dir($moduleDir.DS.'assets'.DS.'js', $vars['assetJsPath']);
            // Copy CSS Assets
            is_dir($moduleDir.DS.'assets'.DS.'css') and \File::copy_dir($moduleDir.DS.'assets'.DS.'css', $vars['assetCssPath']);

            die('Module '.$module.' assets install : OK');
        } else {
            die('Unknow public path : ' . $vars['publicPath']);
        }
    }

    /**
     * Uninstall asset from module
     * @param  string $module     
     * @param  string $publicPath 
     * @param  string $theme      
     * @return boolean             
     */
    public static function uninstallAsset($module, $publicPath = null, $theme = null)
    {
        $vars = self::getThemeVars($module);

        // Public path specify
        if ($publicPath !== null && $publicPath !== 'null')
        {
            $oldPublicPath = $vars['publicPath'];
            $vars['publicPath'] = DOCROOT.DS.$publicPath;
            $vars['assetJsPath'] = str_replace($oldPublicPath, $vars['publicPath'], $vars['assetJsPath']);
            $vars['assetCssPath'] = str_replace($oldPublicPath, $vars['publicPath'], $vars['assetCssPath']);
        } 

        if ($theme !== null)
        {
            $vars['assetJsPath'] = str_replace($vars['activeTheme'], $theme, $vars['assetJsPath']);
            $vars['assetCssPath'] = str_replace($vars['activeTheme'], $theme, $vars['assetCssPath']);
        }
        if (is_dir($vars['publicPath'])) {
            is_dir($vars['assetJsPath']) and \File::delete_dir($vars['assetJsPath'], true);
            is_dir($vars['assetCssPath']) and \File::delete_dir($vars['assetCssPath'], true);

            die('Module '.$module.' assets uninstall : OK');
        }
        else
        {
            die('Unknow public path : ' . $vars['publicPath']);
        }
    }

}
