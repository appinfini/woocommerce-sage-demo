<?php
namespace Packages\Wordpress\Theme;

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
     * Return if acf is active.
     *
     * @since   1.0.0
     * @return  boolean
     */
    public static function isAcfCurrentlyActive() {
        return class_exists('acf');
    }

    /**
     * Checks if a given array has data.
     *
     * @param $data mixed
     *`
     * @since   1.0.0
     * @return  boolean
     */
    public static function hasValidArrayContents($data)
    {
        return (!empty($data)
            && is_array($data)
            && count($data) > 0);
    }

    /**
     * Checks if post content has specified blocks.
     *
     * @param $block string
     *`
     * @since   1.0.0
     * @return  boolean
     */
    public static function hasSpecifiedBlockInContent($block = 'acf/acf-image-and-content-builder')
    {
        global $post;

        // Basics.
        $preparedContents = false;

        // Do we have blocks?
        if (has_blocks($post->post_content)) {
            $blocks = parse_blocks($post->post_content);

            // Iterate blocks.
            if (count($blocks) > 0) {
                foreach ($blocks as $block) {
                    if ($block['blockName'] === 'acf/acf-image-and-content-builder') {
                        $preparedContents = true;
                        break;
                    }
                }
            }
        }

        // Return.
        return $preparedContents;
    }

    /**
     * is_edit_page 
     * function to check if the current page is a post edit page
     * 
     * @param  string  $new_edit what page to check for accepts new - new post page ,edit - edit post page, null for either
     * @return boolean
     */
    public static function isAdminEditPage($new_edit = null)
    {
        global $pagenow;

        //make sure we are on the backend.
        if (!is_admin()) return false;

        if ($new_edit == "edit")
            return in_array($pagenow, array('post.php',));
        elseif ($new_edit == "new") //check for new post page
            return in_array($pagenow, array('post-new.php'));
        else //check for either new or edit
            return in_array($pagenow, array('post.php', 'post-new.php'));
    }
}