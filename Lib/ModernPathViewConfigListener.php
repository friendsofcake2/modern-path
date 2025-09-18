<?php

/**
 * ModernPath View Configuration Listener.
 *
 * Event listener that automatically configures controllers to use ModernPathView
 */
App::uses('CakeEventListener', 'Event');

/**
 * ModernPathViewConfigListener Class.
 *
 * Automatically sets the viewClass to ModernPathView for all controllers
 * without requiring changes to existing controller code
 */
class ModernPathViewConfigListener implements CakeEventListener
{
    /**
     * Returns the list of events this listener handles.
     *
     * @return array Array of event names and their handlers
     */
    public function implementedEvents(): array
    {
        return [
            'Controller.initialize' => 'setModernPathView',
        ];
    }

    /**
     * Sets the viewClass to ModernPathView for controllers.
     *
     * @param CakeEvent $event The event object containing the controller
     *
     * @return void
     */
    public function setModernPathView($event): void
    {
        /** @var Controller $controller */
        $controller = $event->subject();

        // Skip if viewClass is already set to something other than View
        // (e.g., JsonView, XmlView, etc.)
        if (isset($controller->viewClass)
            && 'View' !== $controller->viewClass) {
            return;
        }

        // Set the custom view class
        $controller->viewClass = 'ModernPath.ModernPath';
    }
}
