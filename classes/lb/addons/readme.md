Lb Twig Extension
----

This extension adds the following Fuel helpers functions to Twig:

 - `debug_dump` : \Debug::dump()
 - `auth_check` : \Auth::check()
 - `auth_get_screen_name` : For get the username of user if he's logged
 - `security_fetch_token` : \Security::fetch_token()
 - `show_csrf` : For render csrf token in a hidden input

To enable this extension, edit `config/parser.php`, and add `Lb_Addons_Twig` to the `extensions` key under 'View_Twig', like so:

```php
'View_Twig' => array(
	'extensions' => array(
		'Twig_Fuel_Extension',
		'Lb_Addons_Twig',
	),
),
```
