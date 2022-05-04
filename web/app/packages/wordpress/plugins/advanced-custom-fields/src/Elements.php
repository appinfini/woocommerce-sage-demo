<?php

namespace Packages\Wordpress\Plugins\ACF;

// Basics.
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

class Elements {
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
     * Get section paragraphs.
     *
     * @param $paragraphs array | null
     * @param $configurations array
     *
     * @since   1.0.0
     *
     * @return  string
     */
    public static function getSectionParagraphs($paragraphs, $configurations = [])
    {
        // Basics.
        $contentHTML = '';

        // Finalize class.
        $paragraphClasses = !empty($configurations['classes']) ? $configurations['classes'] : '';

        // If we have a valid array?
        if (ThemeFunctions::hasValidArrayContents($paragraphs)) {
            foreach ($paragraphs as $paragraph) {
                $contentHTML .= '<p class="' . $paragraphClasses . '">' . $paragraph['paragraph_content'] . '</p>';
            }
        }

        // Return.
        return $contentHTML;
    }

    /**
     * Output section paragraphs.
     *
     * @param $paragraphs array | null
     * @param $configurations array
     *
     * @since   1.0.0
     *
     * @return  void
     */
    public static function outputSectionParagraphs($paragraphs, $configurations = [])
    {
        echo self::getSectionParagraphs(
            $paragraphs,
            $configurations
        );
    }

    /**
     * Get social links.
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getSocialLinks()
    {
        // Get links.
        $socialLinks = get_field('global_templates_website_configuration_social_links', 'option');

        // If the data is valid?
        return ThemeFunctions::hasValidArrayContents($socialLinks)
            ? $socialLinks
            : null;
    }

    /**
     * Output social links.
     *
     * @since   1.0.0
     * @return  void
     */
    public static function outputSocialLinks()
    {
        // Basics.
        $output = '';

        // Social links.
        $socialLinks = self::getSocialLinks();

        // If we have them?
        if ($socialLinks) {
            foreach ($socialLinks as $socialLink) {
                $output .= '<a target="_blank" href="' . $socialLink['link_url'] . '"><i class="' . $socialLink['link_icon'] . '"></i></a>';
            }
        }

        // Echo.
        echo $output;
    }

    /**
     * Get notifications data from website configuration.
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getNotificationsData($subgroupName = null)
    {
        // Basics.
        $acfFieldName = 'global_templates_website_configuration_contact_settings_notifications';

        // If we have the subgroup.
        if ($subgroupName) {
            $acfFieldName = implode('_', [
                $acfFieldName,
                $subgroupName
            ]);
        }

        // Get links.
        $notifications = get_field($acfFieldName, 'option');

        // If the data is valid?
        return ThemeFunctions::hasValidArrayContents($notifications)
            ? $notifications
            : null;
    }
}