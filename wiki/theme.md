# Lb Package - Theme

All Lb modules which use Theme class for backend, use the Lb config file.

## Config

Create your own lb config file in `app/config/lb.php` : 

```php
	'theme' => array(
		'use_casset' => false, // If you use Casset instead of Asset
		'assets' => array(
			// 'css_plugin' => 'css', // Set the asset group "css" instead of "css_plugin",
		),
	),
```

## Theme

It uses the Theme class from FuelPHP, consequently you need to have a theme for your administration.

## Implementation

All variables used in the template file from theme :

* $pageTitle : For the title of the page in any action
* $partials['content'] : The partial for the content
* `<?= \Theme::instance()->asset->render('css_plugin'); ?>` in the head
* `<?= \Theme::instance()->asset->render('js_core'); ?>` in the head
* `<?= \Theme::instance()->asset->render('js_plugin'); ?>` in the footer
* Your need to load jQuery, jQuery UI, and optionnaly Twitter Bootstrap v3 + Font Awesome

You can see an example of template here : [`url/example/template.php`](http://github.com/jhuriez/fuel-lb-package/blob/master/example/template.php)

### Change assets groups name

In your theme you don't want to use the asset group "css_plugin", but just "css" ? No problem, you can change it in the config file !

# Error

- JS and CSS files are not loaded!
Be sure you have included jQuery + jQuery UI + Bootstrap v3 + Font Awesome for UI