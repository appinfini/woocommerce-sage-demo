<?php
namespace Packages\Wordpress\Plugins\ACF;

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
     * Register option pages.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function registerOptionPages() {

        // If function exists to add these pages.
        if ( function_exists('acf_add_options_page') ) {
            $parent = acf_add_options_page(
                array(
                    'page_title' => 'Theme General Settings',
                    'menu_title' => 'Theme Settings',
                    'menu_slug' => 'theme-general-settings',
                    'capability' => 'manage_options',
                    'redirect' => true,
                )
            );

            acf_add_options_sub_page(
                array(
                    'page_title' => 'Global Header and Footer',
                    'menu_title' => 'Header and Footer',
                    'parent_slug' => $parent['menu_slug'],
                    'capability' => 'manage_options',
                )
            );

            acf_add_options_sub_page(
                array(
                    'page_title' => 'Global Sections',
                    'menu_title' => 'Global Sections',
                    'parent_slug' => $parent['menu_slug'],
                    'capability' => 'manage_options',
                )
            );

            acf_add_options_sub_page(
                array(
                    'page_title' => 'Website Configuration',
                    'menu_title' => 'Website Configuration',
                    'parent_slug' => $parent['menu_slug'],
                    'capability' => 'manage_options',
                )
            );
        }
    }

    /**
     * Register block data.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function acfRegisterBlockDataAction($block)
    {
        // Get ACF fields.
        if ($block['name'] == 'acf/acf-header-product-builder') {
            $block['data']['section_configuration'] = get_field('section_configuration');

        } elseif ($block['name'] == 'acf/acf-image-and-content-builder') {
            $block['data']['section_configuration'] = [
                'section_position' => get_field('section_position'),
                'section_rows' => get_field('section_rows')
            ];
        }

        // Return.
        return $block;
    }
}