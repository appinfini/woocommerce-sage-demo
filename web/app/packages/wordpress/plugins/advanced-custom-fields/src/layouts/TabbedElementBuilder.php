<?php

namespace Packages\Wordpress\Plugins\ACF\layouts;

// Basics.
use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;

// ACF Elements.
use Packages\Wordpress\Plugins\ACF\elements\BasicArray as AcfElementBasicArray;
use Packages\Wordpress\Plugins\ACF\elements\BasicArrayOfObject as AcfElementBasicArrayOfObject;
use Packages\Wordpress\Plugins\ACF\elements\BasicImage as AcfElementBasicImage;
use Packages\Wordpress\Plugins\ACF\elements\BasicString as AcfElementBasicString;

// ACF Queries.
use Packages\Wordpress\Plugins\ACF\queries\RelationalQueryBuilder as AcfRelationalQueryBuilder;

class TabbedElementBuilder
{
    /**
     * Class properties.
     *
     */
    public static $classProperties = [

        // Basics.
        'basics' => [
            'type' => 'tabbed_element_layout'
        ]
    ];

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
     * @return  array
     */
    public static function getPreparedElement($elementMeta, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [
            'id' => AcfFunctions::getLayoutIdByField(
                $elementMeta
            ),
            'content' => null,
            'heading' => null,
            'items' => [],
            'sectionClasses' => [],
            'type' => self::$classProperties['basics']['type']
        ];

        // Let's get element.
        $behaviorSettings = AcfFunctions::getLayoutObjectByField(
            $elementMeta
        );

        // Do we have any?
        if (AcfElementBasicArray::hasValidatedArrayData($behaviorSettings)) {

            // Let's update heading.
            $preparedContents['heading'] = AcfElementBasicString::getPreparedElement(
                $behaviorSettings,
                'text_primary'
            );

            // Let's update content.
            $preparedContents['content'] = AcfElementBasicString::getPreparedElement(
                $behaviorSettings,
                'wysiwyg_primary'
            );

            // Update section classes.
            $preparedContents['sectionClasses'] = AcfFunctions::getFinalElementClasses(
                $behaviorSettings
            );

            // Let's get relaional query builder object.
            $relationalQueryBuilder = new AcfRelationalQueryBuilder(
                $behaviorSettings
            );

            // If it's relational content?
            if ($relationalQueryBuilder->hasRelationalContent()) {
                $preparedContents['items'] = self::getPreparedRelationalLayout(
                    $relationalQueryBuilder
                );
            }
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Prepare relational items.
     *
     * @param $relationalQueryBuilder object
     * @param $additionalParameters array
     *
     * @return array
     */
    public static function getPreparedRelationalLayout($relationalQueryBuilder, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [];

        // Get posts.
        $posts = $relationalQueryBuilder->getPosts();

        // Do we have any?
        if (AcfElementBasicArray::hasValidatedArrayData($posts)) {

            // Iterate it.
            foreach ($posts as $post) {

                // Let's get ACF fields.
                $childPosts = AcfFunctions::getPostTypeMeta(
                    $relationalQueryBuilder->getContentType(),
                    $post->ID,
                    [
                        'suffix' => 'group_tagging_and_categorization_all_option_query_filter_post_technology'
                    ]
                );

                // If we ha ve it?
                if (AcfElementBasicArray::hasValidatedArrayData($childPosts)) {

                    // Prepared item.
                    $preparedItem = [
                        'heading' => $post->post_title,
                        'items' => [],
                        'link' => [
                            'label' => $post->post_title,
                            'item' => AcfElementBasicArrayOfObject::getPreparedLink(
                                get_permalink(
                                    $post
                                ),
                                $post->post_title
                            )
                        ]
                    ];

                    // Iterate child posts.
                    foreach ($childPosts as $childPost) {

                        // Get child post ACF meta.
                        $childPostIconMeta = AcfFunctions::getPostTypeMeta(
                            $childPost->post_type,
                            $childPost->ID,
                            [
                               'suffix' => 'group_group_image_combination_all_group_image_combination_icon'
                            ]
                        );

                        // Push sub-item.
                        $preparedItem['items'][] = [
                            'heading' => $childPost->post_title,
                            'link' => [
                                'label' => $childPost->post_title,
                                'item' => AcfElementBasicArrayOfObject::getPreparedLink(
                                    get_permalink(
                                        $childPost
                                    ),
                                    $childPost->post_title
                                )
                            ],
                            'mediaPreview' => AcfElementBasicImage::getPreparedElement(
                                $childPostIconMeta
                            )
                        ];
                    }

                    // Push to $preparedContents.
                    $preparedContents[] = $preparedItem;
                }
            }
        }

        // Return.
        return $preparedContents;
    }
}