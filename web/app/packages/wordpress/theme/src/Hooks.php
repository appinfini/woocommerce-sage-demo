<?php

namespace Packages\Wordpress\Theme;

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

        /**
         * Move add to cart above excerpt.
         */
        remove_action(
            'woocommerce_single_product_summary',
            'woocommerce_template_single_add_to_cart',
            30
        );

        add_action(
            'woocommerce_single_product_summary',
            'woocommerce_template_single_add_to_cart',
            15
        );

        /**
         * Ordering checkout fields.
         */
        add_filter(
            'woocommerce_checkout_fields',
            function ($fields) {
                $fields['billing']['billing_first_name']['priority'] = 10;
                $fields['billing']['billing_last_name']['priority'] = 20;
                $fields['billing']['billing_address_1']['priority'] = 30;
                $fields['billing']['billing_address_2']['priority'] = 40;
                $fields['billing']['billing_city']['priority'] = 50;
                $fields['billing']['billing_state']['priority'] = 60;
                $fields['billing']['billing_postcode']['priority'] = 70;
                $fields['billing']['billing_country']['priority'] = 90;
                $fields['billing']['billing_phone']['priority'] = 100;
                $fields['billing']['billing_email']['priority'] = 110;

                // Remove company.
                unset($fields['billing']['billing_company']);

                // Return ordered fields.
                return $fields;
            },
            1
        );        
    }

    /**
     * Woocommerce post save hook.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerWoocommercePostSaveHook()
    {
        add_filter(
            'acf/update_value',
            array(
                __NAMESPACE__ . '\\' . 'Actions',
                'registerWoocommercePostSaveAction'
            ),
            10,
            4
        );
    }
}