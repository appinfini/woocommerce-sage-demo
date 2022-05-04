<?php
namespace Packages\Wordpress\Theme;

class DatabaseQueries
{
    /**
     * Class properties.
     *
     */
    public static $classProperties = [];


    /**
     * Constructor.
     *
     */
    public function __construct()
    {
    }

    /**
     * Return all taxonomies.
     *
     * @param $type string
     * 
     * @since   1.0.0
     * @return  array
     */
    public static function getAllTaxonomies($type)
    {
        // Return.
        $taxonomies = get_terms([
            'taxonomy' => $type,
            'hide_empty' => false,
            'orderby' => 'title',
            'order'   => 'ASC',
        ]);

        // Return.
        return $taxonomies;
    }

    /**
     * Return posts.
     *
     * @param $postTypes array
     * @param $queryParameters array
     * @param $defaultOverrides array
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array
     */
    public static function getPosts($postTypes, $queryParameters = [], $defaultOverrides = [], $additionalParameters = [])
    {
        // Basics.
        // $preparedMeta = [
        //     'relation' => 'AND'
        // ];
        // $preparedSecondaryMeta = [
        //     'relation' => !empty($queryParameters['meta_query_operator_secondary'])
        //     ? $queryParameters['meta_query_operator_secondary']
        //     : 'AND'
        // ];

        // Default parameters.
        $preparedParameters = [
            'post_type' => $postTypes,
            'post_status' => 'publish',
            'orderby' => 'ID',
            'order' => 'desc',
            'ignore_sticky_posts' => 1
        ];


        /**
         * Populate some default parameter overrides.
         * 
         */
        // Do we have title match?
        if (!empty($queryParameters['s'])) {
            $preparedParameters['s'] = $queryParameters['s'];
        }

        // Do we have fields?
        if (!empty($queryParameters['option_query_fields'])) {
            $preparedParameters['fields'] = $queryParameters['option_query_fields'];
        }

        // Do we have posts in?
        if (!empty($queryParameters['option_query_posts_in'])) {
            $preparedParameters['post__in'] = $queryParameters['option_query_posts_in'];
        }

        // Do we have posts not in?
        if (!empty($queryParameters['option_query_posts_not_in'])) {
            $preparedParameters['post__not_in'] = $queryParameters['option_query_posts_not_in'];
        }


        // Do we have meta query?
        if (!empty($queryParameters['option_query_posts_meta_query'])) {
            $preparedParameters['meta_query'] = $queryParameters['option_query_posts_meta_query'];
        }

        /**
         * Set order and visibility.
         * 
         */
        // If we have the limited posts set?
        if (!empty($queryParameters['option_query_visibility_type'])) {

            // If it's to fetch all records?
            if (in_array($queryParameters['option_query_visibility_type'], ['all'])) {

                // Do we have number of posts?
                $preparedParameters['posts_per_page'] = -1;
            } else {
                // Do we have number of posts?
                if (!empty($queryParameters['option_query_visibility_number'])) {
                    $preparedParameters['posts_per_page'] = $queryParameters['option_query_visibility_number'];
                }
            }
        }

        // Do we have order by?
        if (!empty($queryParameters['option_query_order_by_posts'])) {
            $preparedParameters['orderby'] = $queryParameters['option_query_order_by_posts'];

        } else {
            if (!empty($defaultOverrides['option_query_order_by_posts'])) {
                $preparedParameters['orderby'] = $defaultOverrides['option_query_order_by_posts'];
            }
        }

        // Do we have order?
        if (!empty($queryParameters['option_query_sort_order'])) {
            $preparedParameters['order'] = $queryParameters['option_query_sort_order'];
        } else {
            if (!empty($defaultOverrides['option_query_sort_order'])) {
                $preparedParameters['order'] = $defaultOverrides['option_query_sort_order'];
            }
        }


        /**
         * ACF filter groups.
         * 
         */
        // ACF Filter groups.
        // $acfFilterGroups = [];
        // $taxonomyFilterGroups = [];
        // if (in_array($type, ['newsletter', 'post'])) {
        //     $acfFilterGroups = [

        //         // Taxonomies.
        //         [
        //             'acfKey' => 'post_type_based_posts_option_query_filter_tax_pillars',
        //             'filterKey' => 'option_query_filter_tax_pillars',
        //             'targetColumn' => 'term_id'
        //         ],
        //         [
        //             'acfKey' => 'post_type_based_posts_option_query_filter_tax_pillars',
        //             'filterKey' => 'option_query_filter_manual_tax_pillars',
        //             'targetColumn' => null
        //         ]
        //     ];

        //     // If it's newsletter?
        //     if (in_array($type, ['newsletter'])) {

        //         // Taxonomy filters.
        //         $taxonomyFilterGroups = [
        //             'newsletter_category' => [
        //                 'taxonomy' => 'newsletter_category',
        //                 'terms' => [],
        //                 'field' => 'term_id',
        //                 'operator' => 'IN'
        //             ]
        //         ];
        //     } else {

        //         // Taxonomy filters.
        //         $taxonomyFilterGroups = [
        //             'category' => [
        //                 'taxonomy' => 'category',
        //                 'terms' => [],
        //                 'field' => 'term_id',
        //                 'operator' => 'IN'
        //             ]
        //         ];
        //     }
        // } elseif (in_array($type, ['awards'])) {
        //     $acfFilterGroups = [

        //         // Post types.
        //     ];
        // } elseif (in_array($type, ['event'])) {
        //     $acfFilterGroups = [

        //         // Post types.
        //         [
        //             'acfKey' => 'post_type_based_events_option_query_filter_post_posts',
        //             'filterKey' => 'option_query_filter_post_posts',
        //             'targetColumn' => 'meta_value'
        //         ],
        //     ];
        // } elseif (in_array($type, ['testimonials'])) {
        //     $acfFilterGroups = [

        //         // Post types.
        //     ];
        // } elseif (in_array($type, ['projects'])) {
        //     $acfFilterGroups = [

        //         // Post types.
        //         [
        //             'acfKey' => 'post_type_based_projects_pillar',
        //             'filterKey' => 'option_query_filter_manual_tax_pillar',
        //             'targetColumn' => null
        //         ],
        //         [
        //             'acfKey' => 'post_type_based_projects_state',
        //             'filterKey' => 'option_query_filter_manual_tax_state',
        //             'targetColumn' => null
        //         ],
        //         [
        //             'acfKey' => 'post_type_based_projects_standard_products',
        //             'filterKey' => 'option_query_filter_manual_tax_standard_products',
        //             'targetColumn' => null
        //         ],
        //         [
        //             'acfKey' => 'post_type_based_projects_option_query_filter_post_awards',
        //             'filterKey' => 'option_query_filter_post_awards',
        //             'targetColumn' => 'meta_value'
        //         ],
        //         [
        //             'acfKey' => 'post_type_based_projects_option_query_filter_post_testimonials',
        //             'filterKey' => 'option_query_filter_post_testimonials',
        //             'targetColumn' => 'meta_value'
        //         ],
        //     ];
        // } elseif (in_array($type, ['products'])) {
        //     $acfFilterGroups = [

        //         // Post types.
        //         [
        //             'acfKey' => 'post_type_based_products_option_query_filter_post_pages',
        //             'filterKey' => 'option_query_filter_post_pages',
        //             'targetColumn' => 'meta_value'
        //         ],

        //         // Taxonomies.
        //         [
        //             'acfKey' => 'post_type_based_products_option_query_filter_tax_product_area_type',
        //             'filterKey' => 'option_query_filter_tax_product_area_type',
        //             'targetColumn' => 'meta_value'
        //         ],
        //         [
        //             'acfKey' => 'post_type_based_products_option_query_filter_tax_product_path_width',
        //             'filterKey' => 'option_query_filter_tax_product_path_width',
        //             'targetColumn' => 'meta_value'
        //         ],
        //         [
        //             'acfKey' => 'post_type_based_products_option_query_filter_tax_product_purpose',
        //             'filterKey' => 'option_query_filter_tax_product_purpose',
        //             'targetColumn' => 'meta_value'
        //         ],
        //         [
        //             'acfKey' => 'post_type_based_products_option_query_filter_tax_product_standard',
        //             'filterKey' => 'option_query_filter_tax_product_standard',
        //             'targetColumn' => 'meta_value'
        //         ],

        //         // Taxonomies NOT IN.
        //     ];

        //     // Add some taxonomy match and mismatch query params.
        //     for ($i = 0; $i <= 10; $i++) {

        //         // Match.
        //         $acfFilterGroups[] = [
        //             'acfKey' => 'post_type_based_products_option_query_filter_tax_product_feature',
        //             'filterKey' => implode('_', [
        //                 'option_query_filter_tax',
        //                 $i,
        //                 'product_feature'
        //             ]),
        //             'targetColumn' => 'meta_value'
        //         ];

        //         // Mismatch.
        //         $acfFilterGroups[] = [
        //             'acfKey' => 'post_type_based_products_option_query_filter_tax_product_feature',
        //             'compareOperator' => 'NOT LIKE',
        //             'filterKey' => implode('_', [
        //                 'option_query_filter_tax',
        //                 $i,
        //                 'not_product_feature'
        //             ]),
        //             'targetColumn' => 'meta_value'
        //         ];
        //     }
        // } elseif (in_array($type, ['videos'])) {
        // }


        // /**
        //  * Finalize meta query.
        //  * 
        //  */
        // // Iterate all filter groups.
        // if (count($acfFilterGroups) > 0) {
        //     foreach ($acfFilterGroups as $row) {

        //         // Basics.
        //         $rowObjects = !empty($queryParameters[$row['filterKey']])
        //         ? $queryParameters[$row['filterKey']]
        //         : (!empty($defaultOverrides[$row['filterKey']])
        //         ? $defaultOverrides[$row['filterKey']]
        //         : []);

        //         // Do we have this filter?
        //         if (count($rowObjects) > 0) {

        //             // Get target IDs.
        //             $filterByPostIds = AcfElementBasicString::getPreparedArrayByField(
        //                 $rowObjects,
        //                 $row['targetColumn']
        //             );

        //             // Do we have any?
        //             if (count($filterByPostIds) > 0) {

        //                 // Start preparing filter row.
        //                 $preparedRowFilter = [
        //                     'relation' => 'OR'
        //                 ];

        //                 // Iterate ids.
        //                 foreach ($filterByPostIds as $id) {
        //                     $preparedRowFilter[] = [
        //                         'key' => $row['acfKey'], // name of custom field
        //                         'value' => $id,
        //                         'compare' => !empty($row['compareOperator'])
        //                         ? $row['compareOperator']
        //                         : 'LIKE'
        //                     ];
        //                 }

        //                 // Add the row to $preparedSecondaryMeta.
        //                 $preparedSecondaryMeta[] = $preparedRowFilter;
        //             }
        //         }
        //     }

        //     // Do we have $preparedSecondaryMeta?
        //     if (count($preparedSecondaryMeta) > 1) {
        //         $preparedMeta[] = $preparedSecondaryMeta;
        //     }
        // }

        // // ACF Filter groups.
        // if ($type == 'projects') {

        //     // Do we have option set for getting preview rich content?
        //     if (!empty($defaultOverrides['option_query_preview_rich_content'])) {

        //         // Must have image.
        //         $preparedMeta[] = [
        //             'key' => 'post_type_based_projects_image_default', // name of custom field
        //             'value' => '',
        //             'compare' => '!='
        //         ];

        //         // Must have either 'statement' or 'how_does_this_project_inspire'
        //         $preparedMeta[] = [
        //             'relation' => 'OR',
        //             0 => [
        //                 'key' => 'post_type_based_projects_statement', // name of custom field
        //                 'value' => '',
        //                 'compare' => '!='
        //             ],
        //             1 => [
        //                 'key' => 'post_type_based_projects_how_does_this_project_inspire', // name of custom field
        //                 'value' => '',
        //                 'compare' => '!='
        //             ]
        //         ];
        //     }
        // }

        // // Do we have prepared meta?
        // if (count($preparedMeta) > 1) {
        //     $preparedParameters['meta_query'] = $preparedMeta;
        // }

        // // If we have additional params?
        // if (!empty($defaultOverrides['option_query_date'])) {
        //     $explodeDate = explode('/', $defaultOverrides['option_query_date']);

        //     // Check length.
        //     if (ThemeFunctions::validateArrayData($explodeDate) && count($explodeDate) === 2) {

        //         // Prepare date query.
        //         $preparedParameters['posts_per_page'] = -1;
        //         $preparedParameters['date_query'] = [
        //             [
        //                 'year'  => $explodeDate[1],
        //                 'month' => $explodeDate[0],
        //             ]
        //         ];
        //     }
        // }


        // /**
        //  * Do we have taxonomy filters?
        //  * 
        //  */
        // if (count($taxonomyFilterGroups) > 0) {

        //     // Basics.
        //     $taxonomyFilterParameters = [
        //         'relation' => !empty($queryParameters['tax_query_operator_primary'])
        //         ? $queryParameters['tax_query_operator_primary']
        //         : 'OR'
        //     ];

        //     // Iterate all.
        //     foreach ($taxonomyFilterGroups as $key => $taxonomyFilterGroup) {

        //         // Basics.
        //         $taxonomyFilterFieldName = 'option_taxonomy_filter_tax_' . $key;

        //         // If we have the field?
        //         if (!empty($queryParameters[$taxonomyFilterFieldName])) {

        //             // Let's first update the group.
        //             $taxonomyFilterGroup['terms'] = $queryParameters[$taxonomyFilterFieldName];

        //             // Add to $taxonomyFilterParameters.
        //             $taxonomyFilterParameters[] = $taxonomyFilterGroup;
        //         }
        //     }

        //     // If we have some?
        //     if (count($taxonomyFilterParameters) > 1) {
        //         $preparedParameters['tax_query'] = $taxonomyFilterParameters;
        //     }
        // }

        // Return.
        return get_posts(
            $preparedParameters
        );
    }

    /**
     * Return post by ID.
     *
     * @param $url string
     * @param $parameters array
     *
     * @since   1.0.0
     * @return  object | null
     */
    public static function getPostById($postId, $parameters = [])
    {
        // Basics.
        $post = null;

        // If we have postId?
        if ($postId) {
            $post = get_post($postId);
        }

        // Return.
        return $post;
    }

    /**
     * Return post meta by value.
     *
     * @param $type string
     * @param $metaKeyOrder integer | null
     * @param $postId integer
     * @param $parameters array
     *
     * @since   1.0.0
     * @return  object | null
     */
    public static function getPostMetaByValue($metaValue, $metaKeyOrder = null, $postId = null, $parameters = [])
    {
        global $post, $wpdb;

        // Basics.
        $preparedContents = null;
        $postId = $postId
            ? $postId
            : $post->ID;

        // Prepare query.
        $queryString = implode('', [
            "SELECT * FROM $wpdb->postmeta WHERE meta_value = '" . $metaValue . "'",
            isset($metaKeyOrder)
                ? " AND meta_key LIKE '%sections_" . $metaKeyOrder . "_element_configuration%'"
                : '',
            " AND post_id = " . $postId . " ORDER BY meta_id DESC"
        ]);
        $results = $wpdb->get_results($queryString, OBJECT);

        // If we have results.
        if ($results) {
            $preparedContents = $results[0];
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return taxonomy by id.
     *
     * @param $id numeric
     * 
     * @since   1.0.0
     * @return  object
     */
    public static function getTaxonomyById($id)
    {
        return get_term($id);
    }
}