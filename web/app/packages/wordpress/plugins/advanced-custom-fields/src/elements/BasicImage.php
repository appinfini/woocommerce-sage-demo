<?php

namespace Packages\Wordpress\Plugins\ACF\elements;

// Basics.
use WPGraphQL\AppContext;
use WPGraphQL\Data\DataSource;

// ACF Elements.
use Packages\Wordpress\Plugins\ACF\elements\BasicString as AcfElementBasicString;

class BasicImage
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
     * @param $element object
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedElement($element, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = null;

        // If we have option selected?
        if (!empty($element['radio_primary'])) {

            // Init $preparedContents.
            $preparedContents = [
                'icon' => null,
                'image' => null,
                'type' => $element['radio_primary'],
            ];

            // Is it icon or image?
            if ($element['radio_primary'] == 'image') {
                $preparedContents['image'] = self::getPreparedDataSource(
                    $element['image_primary']
                );
                
            } elseif ($element['radio_primary'] == 'material') {
                $preparedContents['icon'] = self::getPreparedMaterialSource(
                    $element
                );
            }
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared element.
     *
     * @param $element object
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedDataSource($element, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = null;

        // If we have URL?
        if (!empty($element['url'])) {
            $preparedContents = self::getPreparedDataSourceById(
                $element['ID'],
                $element
            );
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared element.
     *
     * @param $id numeric
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedDataSourceById($id, $element = null, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = null;

        // If we have URL?
        if (!empty($id)) {
            $preparedContents = DataSource::resolve_post_object(
                (int) $id,
                new AppContext()
            );
        }

        // If we don't have it?
        if (
            wp_doing_ajax()
            && $element
            && (
                !empty($preparedContents->state)
                || !empty($preparedContents->promise->state)
            )
        ) {

            // Let's get image.
            $preparedContents = [
                'altText' => $element['alt'],
                'caption' => $element['caption'],
                'id' => $element['ID'],
                'localFile' => [
                    'id' => $element['ID'],
                    'publicURL' => $element['url']
                ],
                'title' => $element['title']
            ];
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared icon.
     *
     * @param $element object
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedMaterialSource($element, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [
            'color' => AcfElementBasicString::getPreparedElement(
                $element,
                'select_secondary'
            ),
            'name' => AcfElementBasicString::getPreparedElement(
                $element,
                'text_primary'
            ),
            'sectionClasses' => [
                'material-icons',
                'MuiIcon-root',
                AcfElementBasicString::getPreparedElement(
                    $element,
                    'select_secondary'
                )
            ],
            'type' => 'material'
        ];

        // Return.
        return $preparedContents;
    }
}
