<?php

/**
 * ModernPath Plugin Bootstrap.
 *
 * Simple template path management for CakePHP 2.x
 * Uses custom View class to enhance template path resolution
 */
App::uses('CakeEventManager', 'Event');
App::uses('ModernPathViewConfigListener', 'ModernPath.Lib');

/*
 * Default configuration
 *
 * Sets default template path to project root /templates directory
 * Can be overridden by setting ModernPath.templatePath in application config
 */
if (!Configure::check('ModernPath.templatePath')) {
    Configure::write('ModernPath.templatePath', ROOT.DS.'templates'.DS);
}

/*
 * Register event listeners
 */
CakeEventManager::instance()->attach(new ModernPathViewConfigListener());

/*
 * Set the locale directory path
 */
if (!Configure::check('ModernPath.localePath')) {
    Configure::write('ModernPath.localePath', ROOT.DS.'resources'.DS.'locales'.DS);
}
App::build([
    'Locale' => [Configure::read('ModernPath.localePath')],
]);
