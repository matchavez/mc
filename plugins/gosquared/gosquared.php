<?php
namespace Grav\Plugin;
use Grav\Common\Plugin;

class GoSquaredPlugin extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onAssetsInitialized' => ['onAssetsInitialized', 0]
        ];
    }
    /**
     * Add GoSquared JS in assets initialisation
     */
    public function onAssetsInitialized()
    {
        // Get our defaults
        $runInAdmin = $this->config->get('plugins.gosquared.gsInAdmin') == 0;
        $gsn = trim($this->config->get('plugins.gosquared.gsn'));
        $loadLate = $this->config->get('plugins.gosquared.gsLoadLate') == 1;

        // See if we're set to run in admin
        if (!$runInAdmin && $this->isAdmin()) {
            return;
        }

        /**
         * Ok, we're ready to go
         */
        if ($gsn) {
            $gsjs = <<<GoSquaredJS
// GoSquared
!function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
  arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
  d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
  insertBefore(d,q)}(window,document,'script','_gs');

_gs('$gsn');

// GoSquared End  
GoSquaredJS;

            if (!$loadLate) {
                $this->grav['assets']->addInlineJs($gsjs);
            } else {
                $this->grav['assets']->addInlineJs($gsjs, null, 'bottom');
            }
        }
    }
}
