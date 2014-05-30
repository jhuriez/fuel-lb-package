<?php

namespace Lb;

class Lb_Addons_Twig extends \Twig_Extension
{

    /**
     * Gets the name of the extension.
     *
     * @return  string
     */
    public function getName()
    {
        return 'lb';
    }

    /**
     * Sets up all of the functions this extension makes available.
     *
     * @return  array
     */
    public function getFunctions()
    {
        return array(
            'debug_dump' => new \Twig_Function_Function('Debug::dump'),
            'auth_check' => new \Twig_Function_Function('Auth::check'),
            'auth_get_screen_name' => new \Twig_Function_Method($this, 'authGetUserArray'),
            'security_fetch_token' => new \Twig_Function_Function('Security::fetch_token'),
            'view_render' => new \Twig_Function_Method($this, 'viewRender'),
            'show_csrf' => new \Twig_Function_Method($this, 'showCsrf'),
        );
    }

    public function viewRender($path, $vars = array(), $auto_filter = null)
    {
        $html = render($path, $vars, $auto_filter);
        return $html;
    }

    public function authGetUserArray()
    {
        $user_array = \Auth::instance()->get_user_array();
        return $user_array['screen_name'];
    }

    public function showCsrf()
    {
        return \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token());
    }

}

/* End of file twig.php */
