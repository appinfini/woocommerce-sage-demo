<?php

namespace Packages\Wordpress\Plugins\ACF\elements;

// Basics.
use Packages\Wordpress\Theme\Configurations as ThemeConfigurations;

class BasicUrl
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
     * Return URL with starting slash.
     *
     * @param $relativeUrl string
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getUrlWithStartingSlash($relativeUrl, $additionalParameters = [])
    {
        return substr($relativeUrl, 0, 1) != '/'
            ?  '/' . $relativeUrl
            : $relativeUrl;
    }

    /**
     * Return URL without starting slash.
     *
     * @param $relativeUrl string
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getUrlWithoutStartingSlash($relativeUrl, $additionalParameters = [])
    {
        return ltrim($relativeUrl, '/');
    }

    /**
     * Return URL with trailing slash.
     *
     * @param $relativeUrl string
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getUrlWithTrailingSlash($relativeUrl, $additionalParameters = [])
    {
        return substr($relativeUrl, -1) != '/'
            ? $relativeUrl . '/'
            : $relativeUrl;
    }

    /**
     * Return URL without trailing slash.
     *
     * @param $relativeUrl string
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getUrlWithoutTrailingSlash($relativeUrl, $additionalParameters = [])
    {
        return rtrim($relativeUrl, '/');
    }

    /**
     * Return complete URL with trailing slash.
     *
     * @param $relativeUrl string
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getCompleteUrlWithTrailingSlash($relativeUrl, $additionalParameters = [])
    {
        // Basics.
        $preparedContent = null;

        // Websites.
        $websites = ThemeConfigurations::$themeConfigurations['websites']['data'][WP_ENV];

        // Update content.
        $preparedContent = implode('/', [
            $websites['fe']['url'],
            self::getUrlWithoutStartingSlash(
                $relativeUrl
            )
        ]);

        // Add trailing slash.
        $preparedContent = self::getUrlWithTrailingSlash(
            $preparedContent
        );

        // Finalize it.
        $preparedContent = strpos($preparedContent, 'http') === FALSE
            ? implode('://', [
                $_SERVER['HTTPS'] == 'on'
                    ? 'https'
                    : 'http',
                $preparedContent
            ])
            : $preparedContent;

        // Return.
        return $preparedContent;
    }
}
