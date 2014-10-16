<?php

Autoloader::add_core_namespace('Lb');

Autoloader::add_classes(array(
		'Lb\\Backend'    => __DIR__.'/classes/lb/backend.php',
		'Lb\\ModuleUtility'    => __DIR__.'/classes/lb/moduleUtility.php',
        'Lb\\Tool' => __DIR__.'/classes/lb/tool.php',
        'Lb\\Security' => __DIR__.'/classes/lb/security.php',
        'Lb\\Collection' => __DIR__.'/classes/lb/collection.php',
		'Lb\\Lb_Addons_Twig'    => __DIR__.'/classes/lb/addons/twig.php',
		'Lb\\DepartementHelper' => __DIR__.'/classes/lb/departementHelper.php',
		'Lb\\ImageHelper' => __DIR__.'/classes/lb/imageHelper.php',
		'Lb\\Validate' => __DIR__.'/classes/lb/validate.php',
));

\Config::load('lb', true);

/* End of file bootstrap.php */
