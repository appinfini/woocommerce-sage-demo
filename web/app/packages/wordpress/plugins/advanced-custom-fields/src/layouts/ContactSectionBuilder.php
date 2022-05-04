<?php

namespace Packages\Wordpress\Plugins\ACF\layouts;

use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;
use Packages\Wordpress\Plugins\ACF\elements\BasicImage as AcfElementBasicImage;

class ContactSectionBuilder
{
    /**
     * Class properties.
     *
     */
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
    }

    /**
     * Return prepared element.
     *
     * @param $elementMeta array
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string
     */
    public static function getPreparedElement($elementMeta, $args, $context, $info, $additionalParameters = [])
    {        
        // Basics.
        $preparedContents = [
            'id' => AcfFunctions::getLayoutIdByField(
                $elementMeta
            ),
            'heading' => null,
            'content' => null,
            'type' => 'technology_element_builder'
        ];

        // Let's get element.
        $behaviorSettings = AcfFunctions::getLayoutObjectByField(
            $elementMeta,
            null,
            [
                'info' => $info
            ]
        );

        // Do we have any?
        if (ThemeFunctions::hasValidArrayContents($behaviorSettings)) {

            // Let's update heading.
            $preparedContents['heading'] = !empty($behaviorSettings['section_heading'])
                ? $behaviorSettings['section_heading']
                : null;

            // Let's update content.
            $preparedContents['content'] = !empty($behaviorSettings['section_content'])
                ? $behaviorSettings['section_content']
                : null;
                
        }

        // Return.
        return $preparedContents;
    }



}