<?php
namespace Packages\Wordpress\Plugins\ACF;

// Basics.
use Packages\Wordpress\Plugins\ACF\Actions as AcfActions;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

class Hooks
{
    /**
     * Class properties.
     */


    /**
     * Constructor.
     */
    public function __construct()
    {
    }


    /**
     * ACF Options page hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function acfOptionPagesHook() {

        // If ACF is enabled?
        if (ThemeFunctions::isAcfCurrentlyActive()) {

            // Register option pages.
            AcfActions::registerOptionPages();
        }
    }
}