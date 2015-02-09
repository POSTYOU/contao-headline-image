<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Himage
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'postyou',
));
/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
    'postYou\HImageModel' => '/system/modules/headline-image/classes/HImageModel.php',
));
