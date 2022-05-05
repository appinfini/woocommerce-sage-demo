<?php

namespace Packages\Wordpress\Plugins\ACF;

// Theme - Functions.
use Packages\Wordpress\Theme\PostTypes as ThemePostTypes;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

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
     * Get Page Layouts.
     *
     * @return array
     */
    public static function getAllLayouts()
    {
        global $post;

        // Basics.
        $preparedContents = [
            'layouts' => [],
            'meta' => self::getPostTypeMeta(
                $post->post_type,
                $post->ID
            )
        ];

        // Is it desired content type?
        if (in_array($post->post_type, ['page', 'testimonial'])) {
            $allLayouts = get_field('all_available_sections');

            // Is it a valid array?
            if (ThemeFunctions::hasValidArrayContents($allLayouts)) {

                // Iterate them.
                foreach ($allLayouts as $layout) {
                    $layout['acf_fc_template'] = str_replace('_', '-', $layout['acf_fc_layout']);

                    // Push to $preparedContents.
                    $preparedContents['layouts'][] = $layout;
                }
            }
        }

        // Push "Latest News" layout.
        if (is_front_page()) {
            $preparedContents['layouts'][] = [
                'acf_fc_layout' => 'news_builder',
                'acf_fc_template' => 'news-builder',
                'section_configuration' => []
            ];
        }

        // Push "Get in touch" layout.
        $preparedContents['layouts'][] = [
            'acf_fc_layout' => 'get_in_touch',
            'acf_fc_template' => 'get-in-touch',
            'section_configuration' => []
        ];

        // Push "Our partners" layout.
        $preparedContents['layouts'][] = [
            'acf_fc_layout' => 'our_partners',
            'acf_fc_template' => 'our-partners',
            'section_configuration' => get_field('global_template_configurations_partners', 'option')
        ];

        // Return.
        return $preparedContents;
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