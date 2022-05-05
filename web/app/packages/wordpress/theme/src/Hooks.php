<?php

namespace Packages\Wordpress\Theme;

// Basics.
use Packages\Wordpress\Theme\Apis as ThemeApis;

class Hooks
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
     * Register custom post types hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerCustomPostTypeHook() {
        add_action(
            'init',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'registerCustomPostTypeHook'
            )
        );
    }

    /**
     * Register custom taxonomies hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerCustomTaxonomyHook() {
        add_action(
            'init',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'registerCustomTaxonomyHook'
            ),
            0
        );
    }

    /**
     * Enqueue theme stylesheet action.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function enqueueAssetsHook() {
        add_action( 
            'wp_enqueue_scripts',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'enqueueAssetsHook'
            )
        );
    }

    /**
     * Enqueue admin theme stylesheet action.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function enqueueAdminAssetsHook() {
        add_action(
            'admin_enqueue_scripts',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'enqueueAdminAssetsHook'
            )
        );
    }

    /**
     * Add misc hooks.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function addMiscellaneousHooks() {

        // Set ajaxurl JS variable.
        add_action(
            'wp_head',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'setAjaxUrlJavascriptVariable'
            )
        );
    }

    /**
     * Register menu hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerMenuHook() {
        add_action(
            'init',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'registerMenuHook'
            )
        );
    }

    /**
     * Remove asset version hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function removeAssetVersionHook() {
        add_filter(
            'script_loader_src',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'removeAssetVersionHook'
            ),
            9999
        );

        add_filter(
            'style_loader_src',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'removeAssetVersionHook'
            ),
            9999
        );
    }

    /**
     * Theme's functions and definitions.
     *
     * @link https://developer.wordpress.org/themes/basics/theme-functions/
     *
     * @author Hari Shankar
     * @package Custom Theme
     */
    public static function addImageSize() {
        add_image_size( 'left-right-image', 300, 167, false );
    }

    /**
     * Move yoast block to bottom hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function moveYoastSeoBlockToBottomHook() {
        add_filter(
            'wpseo_metabox_prio',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'moveYoastSeoBlockToBottomHook'
            )
        );
    }

    /**
     * Register yoast locale.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerYoastLocaleHook() {
        add_filter(
            'wpseo_locale',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'registerYoastLocale'
            )
        );
    }

    /**
     * Hide the wordpress content editor on a specific page hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function hideContentEditorHook() {
        add_action(
            'admin_init',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'hideContentEditor'
            )
        );
    }

    /**
     * Set ajax hooks.
     * 
     */
    public static function registerAjaxHooks()
    {
        // Set ajaxurl JS variable.
        add_action(
            'wp_head',
            function () {
            ?>
            <script type="text/javascript">
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            </script>
            <?php
            }
        );

        // Posts listing.
        add_action(
            "wp_ajax_" . ThemeApis::$classConfigurations['apis']['postSlackNotificationsListing']['apiKey'],
            function () {
                ThemeApis::notifyJobCandidates();
            }
        );

        add_action(
            "wp_ajax_nopriv_" . ThemeApis::$classConfigurations['apis']['postSlackNotificationsListing']['apiKey'],
            function () {
                ThemeApis::notifyJobCandidates();
            }
        );
    }

    /**
     * Add additional mime types.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerMimeTypeHook()
    {
        add_filter(
            'upload_mimes',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'registerMimeTypeAction'
            )
        );
    }

    /**
     * Add additional mime types.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerWoocommerceShopColumnHook()
    {
        add_filter(
            'loop_shop_columns',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'registerWoocommerceShopColumnAction'
            ),
            999
        );
    }

    /**
     * Remove woo sections.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerWoocommerceRemoveSectionsHook()
    {
        add_filter(
            'init',
            function () {
                remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
            }
        );

        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    }
}