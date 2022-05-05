<?php

namespace Packages\Wordpress\Plugins\ACF\elements;

// Basics.
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

class BasicNumber
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
            if (isset($element->{$filterByColumn})) {
                $preparedContents = $element->{$filterByColumn};
            }
        } else {
            if (isset($element[$filterByColumn])) {
                $preparedContents = $element[$filterByColumn];
            }
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared element with suffix.
     *
     * @param $element object
     * @param $filterByColumn string
     * @param $suffix string
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getPreparedElementWithSuffix($element, $filterByColumn = null, $suffix = null, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = self::getPreparedElement(
            $element,
            $filterByColumn,
            $additionalParameters
        );

        // If we have $suffix?
        if (is_numeric($preparedContents) && $suffix) {
            $preparedContents = implode('', [
                $preparedContents,
                $suffix
            ]);
        }

        // Return.
        return $preparedContents;
    }
}
