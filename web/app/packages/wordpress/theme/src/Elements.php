<?php

namespace Packages\Wordpress\Theme;

// Basics.
use Packages\Wordpress\Theme\Configurations as ThemeConfigurations;

class Elements
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
     * Get main navigation menu.
     *
     * @return array
     */
    public static function getMainNavigationMenu()
    {
        global $post;

        // Basics.
        $arrangedMenu = [];

        // Get menu.
        $rawMenu = wp_get_nav_menu_items('menu-main');

        // Get current page id.
        $currentPageId = (is_page() && is_singular())
            ? $post->ID
            : null;

        // Let's iterate and create parent child hierarchy.
        foreach ($rawMenu as $menu) {

            // Current menu.
            $currentArrangedMenu = [
                'children' => [],
                'classes' => ($currentPageId == $menu->object_id)
                    ? [
                        'active'
                    ]
                    : [],
                'menu' => $menu,
            ];

            // Is it a parent?
            if (empty($menu->menu_item_parent)) {

                // If we don't have this menu in $arrangedMenu yet.
                if (!isset($arrangedMenu[$menu->ID])) {
                    $arrangedMenu[$menu->ID] = $currentArrangedMenu;
                }

            } else {

                // Do we have the parent in $arrangedMenu?
                if (isset($arrangedMenu[$menu->menu_item_parent])) {
                    $arrangedMenu[$menu->menu_item_parent]['children'][$menu->ID] = $currentArrangedMenu;

                    // If it's active then mark parent as active.
                    if (in_array('active', $currentArrangedMenu['classes'])) {
                        $arrangedMenu[$menu->menu_item_parent]['classes'][] = 'active';
                    }
                } else {
                    // Now we will need to iterate all menus from $arrangedMenu to check their submenus.
                    foreach ($arrangedMenu as $parentMenuId => $parentMenu) {

                        // Iterate submenu.
                        if (count($parentMenu['children']) > 0) {
                            foreach ($parentMenu['children'] as $chileMenuId => $childMenu) {

                                // Now does are 3rd level menu is child of 2nd level menu?
                                if ($menu->menu_item_parent == $chileMenuId) {
                                    $arrangedMenu[$parentMenuId]['children'][$chileMenuId]['children'][$menu->ID] = $currentArrangedMenu;

                                    // If it's active then mark parents as active.
                                    if (in_array('active', $currentArrangedMenu['classes'])) {

                                        // If parent is not already active?
                                        if (!in_array('active', $arrangedMenu[$parentMenuId]['classes'])) {
                                            $arrangedMenu[$parentMenuId]['classes'][] = 'active';
                                        }

                                        // If 2nd level parent is not already active?
                                        if (!in_array('active', $arrangedMenu[$parentMenuId]['children'][$chileMenuId]['classes'])) {
                                            $arrangedMenu[$parentMenuId]['children'][$chileMenuId]['classes'][] = 'active';
                                        }
                                    }

                                    // Add "has-third-level-menu" class to 2nd level menu.
                                    if (!in_array('has-third-level-menu', $arrangedMenu[$parentMenuId]['children'][$chileMenuId]['classes'])) {
                                        $arrangedMenu[$parentMenuId]['children'][$chileMenuId]['classes'][] = 'has-third-level-menu';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Return.
        return $arrangedMenu;
    }

    /**
     * Get footer navigation menu.
     *
     * @return array
     */
    public static function getFooterNavigationMenu()
    {

        // Basics.
        $arrangedMenu = [];

        // Get menu.
        $rawMenu = wp_get_nav_menu_items('footer');

        // Let's iterate and create parent child hierarchy.
        foreach ($rawMenu as $menu) {

            // Is it a parent?
            if (empty($menu->menu_item_parent)) {

                // If we don't have this menu in $arrangedMenu yet.
                if (!isset($arrangedMenu[$menu->ID])) {
                    $arrangedMenu[$menu->ID] = [
                        'menu' => $menu,
                        'children' => []
                    ];
                }
            }
        }

        // Return.
        return $arrangedMenu;
    }
}
