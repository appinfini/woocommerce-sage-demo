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
        if (!empty($queryParameters['section_set_limit'])) {
            $preparedParameters['posts_per_page'] = $queryParameters['section_limit'];

        } else {
            $preparedParameters['posts_per_page'] = -1;
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

        // Return.
        return get_posts(
            $preparedParameters
        );
    }

    /**
     * Return taxonomy post types.
     *
     * @param $postTypes array
     * @param $queryParameters array
     * @param $defaultOverrides array
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array
     */
    public static function getPostTestimonials($postConfigurations, $queryParameters = [], $defaultOverrides = [], $additionalParameters = [])
    {
        return self::getPosts(
            [
                'testimonial'
            ],
            $postConfigurations
        );
    }

    /**
     * Return taxonomy post types.
     *
     * @param $postTypes array
     * @param $queryParameters array
     * @param $defaultOverrides array
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array
     */
    public static function getPostProducts($postConfigurations, $queryParameters = [], $defaultOverrides = [], $additionalParameters = [])
    {
        return self::getPosts(
            [
                'product'
            ],
            [
                'section_set_limit' => true,
                'section_limit' => 2
            ]
        );
    }
}