<?php

/**
 * ModernPath View Class.
 *
 * Custom View class that overrides _paths() method for custom template resolution
 */
App::uses('View', 'View');

/**
 * ModernPathView Class.
 *
 * Extends CakePHP's View class by overriding the _paths() method
 * to include custom template paths using the same logic as core paths
 */
class ModernPathView extends View
{
    /**
     * Override _paths method to include custom template paths.
     *
     * @param string $plugin Plugin name
     * @param bool   $cached Whether to use cached paths
     *
     * @return array Array of paths to search for templates
     */
    protected function _paths($plugin = null, $cached = true)
    {
        // Get original paths from parent
        $originalPaths = parent::_paths($plugin, $cached);

        // Get custom template path from configuration
        $customTemplatePath = Configure::read('ModernPath.templatePath');

        // Start with custom paths if available
        $paths = [];
        if ($customTemplatePath && is_dir($customTemplatePath)) {
            $paths[] = $customTemplatePath;
        }

        // Merge with core paths (same logic as CakePHP core)
        $paths = array_merge($paths, $originalPaths);

        // Cache and return using CakePHP's standard pattern
        if (null !== $plugin) {
            return $this->_pathsForPlugin[$plugin] = $paths;
        }

        return $this->_paths = $paths;
    }
}
