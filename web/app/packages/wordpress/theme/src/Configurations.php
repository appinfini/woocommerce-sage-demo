<?php

namespace Packages\Wordpress\Theme;

// Basics.
use Packages\Wordpress\Theme\Hooks as ThemeHooks;
use Packages\Wordpress\Plugins\ACF\Hooks as AcfHooks;

class Configurations
{
    /**
     * Class properties.
     *
     */
    public static $themeConfigurations = [

        // Pages.
        'pages' => [
        ],

        // Posts.
        'posts' => [
            'types' => [
                'data' => [
                    'page' => [
                        'args' => [
                            'dashIcon' => null,
                            'namePlural' => 'Pages',
                            'nameSingular' => 'Page',
                            'slug' => 'page'
                        ],
                        'meta' => [
                            'default' => true, // if this CPT is provided by WP.
                            'postType' => 'page'
                        ]
                    ],
                    'post' => [
                        'args' => [
                            'dashIcon' => null,
                            'namePlural' => 'Posts',
                            'nameSingular' => 'Post',
                            'slug' => 'post'
                        ],
                        'meta' => [
                            'default' => true,
                            'postType' => 'post'
                        ]
                    ],
                    'testimonial' => [
                        'args' => [
                            'dashIcon' => 'dashicons-testimonial',
                            'namePlural' => 'Testimonials',
                            'nameSingular' => 'Testimonial',
                            'slug' => 'testimonial'
                        ],
                        'meta' => [
                            'default' => false,
                            'postType' => 'testimonial'
                        ]
                    ]
                ]
            ]
        ],

        // Taxonomies.
        'taxonomies' => [
            'types' => [
                'data' => []
            ]
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
     * Init theme.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function initTheme()
    {

        // Register post types, taxonomies etc.
        ThemeHooks::registerCustomPostTypeHook();
        ThemeHooks::registerCustomTaxonomyHook();

        // Register theme hooks.
        ThemeHooks::addMiscellaneousHooks();
        // ThemeHooks::enqueueAssetsHook();
        ThemeHooks::registerAjaxHooks();
        ThemeHooks::registerMimeTypeHook();

        /*
         * ACF hooks.
         * 
         */
        // Register ACF option pages hook.
        AcfHooks::acfOptionPagesHook();

        /**
         * Woocommerce
         * 
         */
        ThemeHooks::registerWoocommerceShopColumnHook();
        ThemeHooks::registerWoocommerceRemoveSectionsHook();
    }
}