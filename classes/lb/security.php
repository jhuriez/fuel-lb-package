<?php

namespace Lb;

class Security
{

    /**
     * 
     * Check if the user has access (with \Auth and OrmAuth)
     * 
     * @param string $controller
     * @param string $action
     * @param string $module
     * @return boolean
     */
    public static function check_auth($controller, $action, $module = null, $redirect = '')
    {
        $user_id = \Auth::get_user_id();
        $user = \Auth\Model\Auth_User::find($user_id[1]);
        
        // Get permission name (module.controller[actions])
        $permission = ($module) ? : 'app';
        $permission .= '.'.$controller.'['.$action.']';
        
        // If has not access and it's not the auth
        if (!\Auth::has_access($permission) && 
                $controller != 'auth' && 
                $action != 'login')
        {
            if (\Request::is_hmvc())
            {
                return false;
            }

            if (\Auth::check() === false)
            {
                // If he isn't logged
                \Messages::error(\Lang::get('login.access_denied.must_login'));
                if (empty($redirect)) \Response::redirect_back();
                else \Response::redirect($redirect);
            }
            else
            {
                // Access denied
                \Messages::error(\Lang::get('login.access_denied.no_access'));
                if (empty($redirect)) \Response::redirect_back();
                else \Response::redirect($redirect);
            }
        }
        // Has access
        return true;
    }

}
