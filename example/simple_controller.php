<?php

class Controller_Simple extends \Controller_Hybrid
{
	public $template = 'template';

    public function before() {
        // Set template
        $this->theme = \Theme::instance();

        // If ajax or content_only, set a theme with an empty layout
        if (\Input::is_ajax() || \Input::get('content_only'))
        {
            $this->theme->active('default');
            $this->template = '';
            return parent::before();
        }
        else if (!\Request::is_hmvc())
        {
            $this->theme->set_template($this->template);
        }

        // Don't re-set Media if is an HMVC request
        !\Request::is_hmvc() and $this->setMedia();
    }

    public function action_index()
    {

    }

    public function action_404()
    {
        $messages = array('Uh Oh!', 'Huh ?');
        $data['notfound_title'] = $messages[array_rand($messages)];
        $this->dataGlobal['pageTitle'] = 'Page introuvable!';
        $this->theme->set_partial('content', '_partials/404')->set($data);
    }
    
    public function after($response)
    {
        // If nothing was returned set the theme instance as the response
        if (empty($response))
        {
            $response = \Response::forge($this->theme);
        }

        if (!$response instanceof \Response)
        {
            $response = \Response::forge($response);
        }
        
        return parent::after($response);
    }

    public function setMedia()
    {
        // Set module media for backend (include jQuery, Bootstrap v3 and Font Awesome)
        $loadLibrary = false;

        if ($loadLibrary)
        {
            $activeTheme = $this->theme->active();
            $casset = \Config::get('lb.theme.use_casset');
            $casset and \Casset::add_path('theme', $activeTheme['asset_base']);
       
            \Lb\Backend::addAsset(array(
                'jquery.min.js',
                'jquery-ui.min.js',
            ), 'js', 'js_core', $this->theme, $casset);
            
            \Lb\Backend::addAsset(array(
                'bootstrap/css/bootstrap.css',
                'bootstrap/css/bootstrap-glyphicons.css',
            ), 'css', 'css_plugin', $this->theme, $casset);

            \Lb\Backend::addAsset(array(
                'bootstrap.js',
            ), 'js', 'js_core', $this->theme, $casset);
            
            \Lb\Backend::addAsset(array(
                'font-awesome/css/font-awesome.css',
            ), 'css', 'css_plugin', $this->theme, $casset);
        }
    }
}