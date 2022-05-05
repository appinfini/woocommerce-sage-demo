<?php

namespace Packages\Wordpress\Plugins\ACF\elements;

// Basics.
use Packages\Wordpress\Theme\Configurations as ThemeConfigurations;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

class BasicString
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
     * Return prepared element.
     *
     * @param $element object
     * @param $filterByColumn string
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getPreparedElement($element, $filterByColumn, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = null;

        // Do we have the column in this row?
        if (is_object($element)) {
            if (!empty($element->{$filterByColumn})) {
                $preparedContents = $element->{$filterByColumn};
            }
            
        } else {
            if (!empty($element[$filterByColumn])) {
                $preparedContents = $element[$filterByColumn];
            }
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared element.
     *
     * @param $element object
     * @param $filterByColumn string
     * @param $defaultValue string | object
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getPreparedElementWithDefaultValue($element, $filterByColumn, $defaultValue, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = null;

        // Get value.
        $preparedContents = self::getPreparedElement(
            $element,
            $filterByColumn,
            $additionalParameters
        );

        // If we don't have the value?
        if (!$preparedContents) {

            // Do we have string as override?
            if (is_string($defaultValue)) {
                $preparedContents = $defaultValue;
            } elseif (is_object($defaultValue)) {
                $preparedContents = $defaultValue->post_title;
            } else {
                $preparedContents = $defaultValue;
            }
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return true if element has value.
     *
     * @param $element object
     * @param $filterByColumn string
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  boolean
     */
    public static function hasPreparedElement($element, $filterByColumn, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = self::getPreparedElement($element, $filterByColumn, $additionalParameters);

        // Return.
        return $preparedContents ? true : false;
    }
}
