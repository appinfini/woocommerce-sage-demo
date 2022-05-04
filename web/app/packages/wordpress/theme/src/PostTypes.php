<?php

namespace Packages\Wordpress\Theme;

// Basics.
use Packages\Wordpress\Theme\Configurations as ThemeConfigurations;

class PostTypes
{
    /**
     * Class properties.
     *
     */
    public static $classConfigurations = [];

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
    }

    /**
     * Get all post types from the project.
     *
     * @since   1.0.0
     * @return  array
     */
    public static function getPostTypes()
    {
        // Basics.
        $preparedContents = [];

        // Iterate post types.
        foreach (ThemeConfigurations::$themeConfigurations['posts']['types']['data'] as $key => $postTypeMeta) {
            $preparedContents[] = $postTypeMeta['meta']['postType'];
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Get post type meta for the provided post type.
     *
     * @param string $postType
     * 
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPostTypeMeta($postType)
    {
        // Basics.
        $preparedContents = null;

        // Iterate post types.
        foreach (ThemeConfigurations::$themeConfigurations['posts']['types']['data'] as $key => $postTypeMeta) {

            // If post type matches?
            if ($postType == $postTypeMeta['meta']['postType']) {
                $preparedContents = $postTypeMeta;

                // Break.
                break;
            }
        }
        
        // Return.
        return $preparedContents;
    }
}