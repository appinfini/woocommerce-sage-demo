<?php

namespace Packages\Wordpress\Plugins\ACF;

// Theme - Functions.
use Packages\Wordpress\Theme\PostTypes as ThemePostTypes;

class Functions
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
     * Get post type based meta.
     *
     * @param $postType string
     * @param $postId integer
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPostTypeMeta($postType, $postId, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = null;

        // Let's get post meta.
        $themePostMeta = ThemePostTypes::getPostTypeMeta(
            $postType
        );

        // Let's get acf meta.
        if ($themePostMeta) {

            // Meta field.
            $acfPostMetaField = implode('_', [
                'post_type_based',
                $postType
            ]);

            // Do we have suffix?
            if (!empty($additionalParameters['suffix'])) {
                $acfPostMetaField = implode('_', [
                    $acfPostMetaField,
                    $additionalParameters['suffix']
                ]);
            }

            // Get ACF meta from the field.
            $preparedContents = get_field(
                $acfPostMetaField,
                in_array($postType, ['user'])
                    ? implode('_', [
                        'user',
                        $postId
                    ])
                    : $postId
            );
        }

        // Return.
        return $preparedContents;
    }
}