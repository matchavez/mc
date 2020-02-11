<?php
namespace Grav\Plugin;

use Grav\Common\Assets;
use Grav\Common\Plugin;
use Grav\Common\Uri;

class DarkadminPlugin extends Plugin
{
    public static function getSubscribedEvents() {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
        ];
    }

    public function onPluginsInitialized()
    {
        /** @var Uri $uri */
        $uri = $this->grav['uri'];
        $route = $this->config->get('plugins.admin.route');

        if ($route && preg_match('#' . $route . '#', $uri->path())) {
            $this->enable([
                'onPageInitialized' => ['onPageInitialized', 0]
            ]);
        }
    }

    public function onPageInitialized()
    {
        $assets = $this->grav['assets'];
        $assets->addCss('user/plugins/darkadmin/darkadmin.css', 1);
    }
}
