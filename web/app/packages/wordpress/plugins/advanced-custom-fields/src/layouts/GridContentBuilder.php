<?php

namespace Packages\Wordpress\Plugins\ACF\layouts;

use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;
use Packages\Wordpress\Plugins\ACF\elements\BasicImage as AcfElementBasicImage;

class GridContentBuilder
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
            'items' => [],
            'type' => 'cardt_element_builder'
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
                
            // Add items.
            if (ThemeFunctions::hasValidArrayContents($behaviorSettings['section_grids'])) {
                foreach ($behaviorSettings['section_grids'] as $row) {

                    // Basics.
                    $preparedRow = [
                        'heading' => !empty($row['section_heading'])
                            ? $row['section_heading']
                            : null,
                        'content' => !empty($row['section_content'])
                            ? $row['section_content']
                            : null,
                        'icon' => null
                    ];

                    // If we havbe icon?
                    if (ThemeFunctions::hasValidArrayContents($row['icon_configuration'])) {
                        $preparedRow['icon'] = [
                            'color' => !empty($row['icon_configuration']['icon_color'])
                                ? $row['icon_configuration']['icon_color']
                                : null,
                            'featuredImage' => AcfElementBasicImage::getPreparedDataSource(
                                $row['icon_configuration']['icon_image']
                            ),
                            'name' => !empty($row['icon_configuration']['icon_name'])
                                ? $row['icon_configuration']['icon_name']
                                : null,
                            'type' => !empty($row['icon_configuration']['icon_type'])
                                ? $row['icon_configuration']['icon_type']
                                : null,
                        ];
                    }

                    // Add to $preparedContents.
                    $preparedContents['items'][] = $preparedRow;
                }
            }
        }

        // Return.
        return $preparedContents;
    }



}