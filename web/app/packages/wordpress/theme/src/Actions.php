<?php

namespace Packages\Wordpress\Theme;

// Basics.
use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;
use Packages\Wordpress\Plugins\ACF\elements\BasicString;
use Packages\Wordpress\Theme\Configurations as ThemeConfigurations;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

class Actions
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
     * Register custom post types action hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerCustomPostTypeHook()
    {
        // Basics.
        $menuPositionCounter = 5;

        // Retrieve CPT configurations.
        $postTypeConfigs = ThemeConfigurations::$themeConfigurations['posts']['types']['data'];

        // Iterate all.
        if (count($postTypeConfigs) > 0) {
            foreach ($postTypeConfigs as $postTypeKey => $postTypeConfig) {

                // Don't process it if it's the default post type.
                if ($postTypeConfig['meta']['default']) {
                    continue;
                }

                // Finalize args.
                $postTypeArgs = [
                    'labels' => [
                        'name' => $postTypeConfig['args']['namePlural'],
                        'singular_name' => $postTypeConfig['args']['nameSingular'],
                        'menu_name' => $postTypeConfig['args']['namePlural'],
                        'name_admin_bar' => $postTypeConfig['args']['nameSingular'],
                        'all_items' => 'All ' . $postTypeConfig['args']['namePlural'],
                        'add_new' => __('Add New'),
                        'add_new_item' => 'Add New ' . $postTypeConfig['args']['nameSingular'],
                        'edit_item' => 'Edit ' . $postTypeConfig['args']['nameSingular'],
                        'new_item' => 'New ' . $postTypeConfig['args']['nameSingular'],
                        'view_item' => 'View ' . $postTypeConfig['args']['nameSingular'],
                        'search_items' => 'Search ' . $postTypeConfig['args']['namePlural'],
                        'not_found' => 'No ' . strtolower($postTypeConfig['args']['namePlural']) . ' found.',
                        'not_found_in_trash' => 'No ' . strtolower($postTypeConfig['args']['namePlural']) . ' found in Trash.',
                        'parent_item_colon' => 'Parent ' . $postTypeConfig['args']['namePlural'] . ':',
                    ],
                    'hierarchical' => false,
                    'public' => true,
                    'menu_position' => $menuPositionCounter,
                    'menu_icon' => $postTypeConfig['args']['dashIcon']
                        ? $postTypeConfig['args']['dashIcon']
                        : 'dashicons-welcome-widgets-menus',
                    'supports' => [
                        'author',
                        'custom-fields',
                        'title'
                    ],
                    'has_archive' => false,
                    'rewrite' => [
                        'slug' => $postTypeConfig['args']['slug']
                    ]
                ];

                // Register this post type.
                register_post_type(
                    $postTypeConfig['meta']['postType'],
                    $postTypeArgs
                );

                // Increase counter.
                $menuPositionCounter++;
            }
        }
    }

    /**
     * Register custom taxonomies action hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerCustomTaxonomyHook()
    {

        // Retrieve TAX configurations.
        $taxonomyTypeConfigs = ThemeConfigurations::$themeConfigurations['taxonomies']['types']['data'];

        // Iterate all.
        if (count($taxonomyTypeConfigs) > 0) {
            foreach ($taxonomyTypeConfigs as $taxonomyTypeConfig) {

                // Don't process it if it's the default taxonomy type.
                if ($taxonomyTypeConfig['meta']['default']) {
                    continue;
                }

                // Finalize args.
                $taxonomyTypeArgs = [
                    'labels' => [
                        'name' => __($taxonomyTypeConfig['args']['namePlural']),
                        'singular_name' => __($taxonomyTypeConfig['args']['nameSingular']),
                        'menu_name' => __($taxonomyTypeConfig['args']['namePlural']),
                        'all_items' => __('All ' . $taxonomyTypeConfig['args']['namePlural']),
                        'edit_item' => __('Edit ' . $taxonomyTypeConfig['args']['nameSingular']),
                        'view_item' => __('View ' . $taxonomyTypeConfig['args']['nameSingular']),
                        'update_item' => __('Update ' . $taxonomyTypeConfig['args']['nameSingular']),
                        'add_new_item' => __('Add New ' . $taxonomyTypeConfig['args']['nameSingular']),
                        'new_item_name' => __('New ' . $taxonomyTypeConfig['args']['nameSingular']),
                        'parent_item' => __('Parent ' . $taxonomyTypeConfig['args']['nameSingular']),
                        'parent_item_colon' => __('Parent ' . $taxonomyTypeConfig['args']['nameSingular'] . ':'),
                        'search_items' => __('Search ' . $taxonomyTypeConfig['args']['namePlural']),
                    ],
                    'hierarchical' => true,
                    'show_admin_column' => false,
                    'rewrite' => [
                        'slug' => $taxonomyTypeConfig['args']['slug']
                    ],
                    'show_in_rest' => false,
                    'supports' => [
                        'editor'
                    ]
                ];

                // Register this taxonomy.
                register_taxonomy(
                    $taxonomyTypeConfig['meta']['taxonomyType'],
                    $taxonomyTypeConfig['meta']['postTypes'],
                    $taxonomyTypeArgs
                );
            }
        }
    }

    /**
     * Enqueue admin theme stylesheet action.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function enqueueAdminAssetsHook()
    {
        global $post;
        if (ThemeFunctions::isAdminEditPage() && in_array($post->post_type, ['page'])) {
            wp_enqueue_style('admin-theme-custom-css', get_template_directory_uri() . '/resources/styles/style.css');
        }
    }

    /**
     * Register additional mime types.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerMimeTypeAction($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    /**
     * Register additional mime types.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerWoocommerceShopColumnAction($mimes)
    {
        return 3;
    }

    /**
     * Register hook when product is aaved.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerWoocommercePostSaveAction($value, $post_id, $field, $original)
    {
        global $post;

        // If it's not the desired filed?
        if ($field['name'] != 'post_type_based_product_section_product_splash_content') {
            return $value;
        }

        // Basics.
        $preparedPhotos = [];

        // Get post meta.
        $sectionPostMeta = AcfFunctions::getPostTypeMeta(
            $post->post_type,
            $post_id
        );

        // Do we have the keyword?
        if (BasicString::hasPreparedElement($sectionPostMeta, 'section_product_splash')) {

            // Init Unspalsh.
            \Unsplash\HttpClient::init([
                'applicationId'    => env('UNSPLASH_APPLICATION_ACCESS_KEY'),
                'secret'    => env('UNSPLASH_APPLICATION_SECRET_KEY'),
                'callbackUrl'    => 'https://your-application.com/oauth/callback',
                'utmSource' => 'AppInfini Technologies'
            ]);

            // Let's get the pics.
            $rawPhotos = \Unsplash\Search::photos($sectionPostMeta['section_product_splash'], 1, 3, 'landscape');

            // Do we have them?
            if (isset($rawPhotos[0]) > 0) {
                for ($i = 0; $i <=2; $i++) {
                    $preparedPhotos[] = [
                        'id' => $rawPhotos[$i]['id'],
                        'description' => $rawPhotos[$i]['id'],
                        'url' => $rawPhotos[$i]['urls']['thumb'],
                    ];
                }
            }
        }

        // Return.
        return json_encode($preparedPhotos);
    }

    /**
     * Set ajaxurl variable in JS.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function setAjaxUrlJavascriptVariable()
    {
    ?>
        <script type="text/javascript">
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        </script>
    <?php
    }
}
