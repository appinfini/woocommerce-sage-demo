<?php

namespace Packages\Wordpress\Plugins\ACF\elements;

// ACF Elements.
use Packages\Wordpress\Plugins\ACF\elements\BasicString as AcfElementBasicString;

class BasicArray
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
     * Checks if a given array has data.
     *
     * @param $data mixed
     * @param $filterByColumn string
     * @param $additionalParameters array
     *`
     * @since   1.0.0
     * @return  boolean
     */
    public static function hasValidatedArrayData($data, $filterByColumn = null, $additionalParameters = [])
    {
        // Basics.
        if ($filterByColumn) {
            $data = AcfElementBasicString::getPreparedElement(
                $data,
                $filterByColumn
            );
        }

        // Return.
        return (!empty($data)
            && is_array($data)
            && count($data) > 0);
    }

    /**
     * Return validate array.
     *
     * @param $data mixed
     * @param $filterByColumn string
     * @param $additionalParameters array
     *`
     * @since   1.0.0
     * @return  boolean
     */
    public static function getValidatedContents($data, $filterByColumn = null, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [];

        // Basics.
        if (self::hasValidatedArrayData($data, $filterByColumn, $additionalParameters)) {
            $preparedContents = $data[$filterByColumn];
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return array of objects having custom key.
     *
     * @param $array array
     * @param $targetKey string
     * @param $parameters array
     *`
     * @since   1.0.0
     * @return  array
     */
    public static function getCustomKeyedArrayOfObjects($array, $targetKey, $parameters = [])
    {
        // Basics.
        $preparedArray = [];

        // Do we have valid array?
        if (self::hasValidatedArrayData($array)) {
            foreach ($array as $row) {

                // If we have target in this row?
                if (isset($row->{$targetKey})) {
                    $preparedArray[$row->{$targetKey}] = $row;
                }
            }
        }

        // Return.
        return $preparedArray;
    }

    /**
     * Return values from array of a custom key.
     *
     * @param $array array
     * @param $targetKey string
     * @param $parameters array
     *`
     * @since   1.0.0
     * @return  array
     */
    public static function getCustomKeyedArrayValues($array, $targetKey = 'ID', $parameters = [])
    {
        // Basics.
        $preparedArray = [];

        // Do we have valid array?
        if (self::hasValidatedArrayData($array)) {
            foreach ($array as $row) {

                // If we have target in this row?
                if (isset($row->{$targetKey})) {
                    $preparedArray[] = $row->{$targetKey};
                }
            }
        }

        // Return.
        return $preparedArray;
    }
}
