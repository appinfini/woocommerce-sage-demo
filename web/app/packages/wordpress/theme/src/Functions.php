<?php
namespace Packages\Wordpress\Theme;

// Basics.
use DateTime;

// ACF Elements.
use Packages\Wordpress\Plugins\ACF\elements\BasicString as AcfElementBasicString;
use Packages\Wordpress\Plugins\ACF\Elements as AcfElements;

// Loggers.
use Packages\Wordpress\Plugins\Logger\Functions as LoggerFunctions;

// Theme Classes.
use Packages\Wordpress\Theme\DatabaseQueries as ThemeDatabaseQueries;

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
     * Get assets directory.
     *
     * @param $type string|null
     * @param $file string|null
     *
     * @since   1.0.0
     * @return  string
     */
    public static function getAssetsDirectory( $type = null, $file = null ) {

        // Basics.
        $assetsDirectory = get_stylesheet_directory_uri();
        $pathParts = [
            $assetsDirectory,
            'assets'
        ];

        // Asset types array.
        $assetTypes = [
            'css' => 'css',
            'fonts' => 'fonts',
            'images' => 'images',
            'js' => 'js',
        ];

        // If we have correct type?
        if (!empty($type) && array_key_exists( $type, $assetTypes)) {
            $pathParts[] = $assetTypes[$type];
        }

        // If we have file?
        if (!empty($file)) {
            $pathParts[] = $file;
        }

        // Return.
        return implode('/', $pathParts);
    }

    /**
     * Get css path.
     *
     * @param $file string
     *
     * @since   1.0.0
     * @return  string
     */
    public static function getCssPath($file) {
        return self::getAssetsDirectory('css', $file);
    }

    /**
     * Get js path.
     *
     * @param $file string
     *
     * @since   1.0.0
     * @return  string
     */
    public static function getJsPath($file) {
        return self::getAssetsDirectory('js', $file);
    }

    /**
     * Get images path.
     *
     * @param $file string
     *
     * @since   1.0.0
     * @return  string
     */
    public static function getFontPath($file) {
        return self::getAssetsDirectory('fonts', $file);
    }

    /**
     * Get images path.
     *
     * @param $file string
     *
     * @since   1.0.0
     * @return  string
     */
    public static function getImagePath($file) {
        return self::getAssetsDirectory('images', $file);
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
     * Echo assets directory.
     *
     * @param $path string
     *
     * @since   1.0.0
     * @return  boolean
     */
    public static function locateTemplate( $path ) {
        return locate_template( [$path . '.php'] );
    }

    /**
     * Echo assets directory.
     *
     * @param $type string|null
     *
     * @since   1.0.0
     * @return  void
     */
    public static function outputAssetsDirectory( $type = null ) {
        echo self::getAssetsDirectory( $type );
    }

    /**
     * Echo css path.
     *
     * @param $file string
     *
     * @since   1.0.0
     * @return  void
     */
    public static function outputCssPath($file) {
        echo self::getCssPath($file);
    }

    /**
     * Echo js path.
     *
     * @param $file string
     *
     * @since   1.0.0
     * @return  void
     */
    public static function outputJsPath($file) {
        echo self::getJsPath($file);
    }

    /**
     * Echo font path.
     *
     * @param $file string
     *
     * @since   1.0.0
     * @return  void
     */
    public static function outputFontPath($file) {
        echo self::getFontPath($file);
    }

    /**
     * Echo image path.
     *
     * @param $file string
     *
     * @since   1.0.0
     * @return  void
     */
    public static function outputImagePath($file) {
        echo self::getImagePath($file);
    }

    /**
     * Call a shortcode function by tag name.
     *
     * @since  1.4.6
     *
     * @param string $tag     The shortcode whose function to call.
     * @param array  $atts    The attributes to pass to the shortcode function. Optional.
     * @param array  $content The shortcode's content. Default is null (none).
     *
     * @return string|bool False on failure, the result of the shortcode on success.
     */
    public static function doShortcode( $tag, array $atts = array(), $content = null ) {
        global $shortcode_tags;

        if ( ! isset( $shortcode_tags[ $tag ] ) ) {
            return false;
        }

        return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
    }

    /**
     * Return left padded number.
     *
     * @param $number int
     *`
     * @since   1.0.0
     * @return  boolean
     */
    public static function getLeftPaddedNumber($number) {
        return str_pad($number, 2, '0', STR_PAD_LEFT);
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
     * Return Date after formatting.
     *
     * @param $input string
     * @param $format string
     * @param $parameters array
     *
     * @since   1.0.0
     * @return  object | array
     */
    public static function getCustomFormattedDate($input, $format = 'dS M Y', $parameters = [])
    {
        $date = DateTime::createFromFormat('d/m/Y', $input);

        // Return.
        return $date->format($format);
    }

    /**
     * Return Date after formatting.
     *
     * @param $postId integer
     * @param $format string
     * @param $parameters array
     *
     * @since   1.0.0
     * @return  object | array
     */
    public static function getCustomFormattedDateFromId($postId, $format = 'dS M Y', $parameters = [])
    {
        return get_the_date($format, $postId);
    }

    /**
     * Return social sharing details.
     *
     * @param $node object
     * @param $params array
     *
     * @throws \Exception
     *
     * @return array
     */
    public static function getSocialSharingDetails($postId, $params = [])
    {
        // Basics.
        $socialSharingPlatforms = [];

        // Get post details.
        $post = ThemeDatabaseQueries::getPostById(
            $postId
        );

        // Get link.
        $postLink = AcfElementBasicString::getCustomPermalink(
            $post->ID
        );

        // Let's add facebook.
        $socialSharingPlatforms[] = [
            'icon' => 'facebook',
            'platform' => 'facebook',
            'url' => implode('', [
                'https://www.facebook.com/share.php?',
                http_build_query([
                    'u' => $postLink,
                ])
            ]),
        ];

        // Let's add pinterest.
        $socialSharingPlatforms[] = [
            'icon' => 'pinterest',
            'platform' => 'pinterest',
            'url' => implode('', [
                'https://pinterest.com/pin/create/link/?',
                http_build_query([
                    'description' => $post->post_title,
                    'url' => $postLink
                ])
            ]),
        ];

        // Let's add twitter.
        $socialSharingPlatforms[] = [
            'icon' => 'twitter',
            'platform' => 'twitter',
            'url' => implode('', [
                'https://twitter.com/intent/tweet?',
                http_build_query([
                    'text' => $post->post_title,
                    'url' => $postLink,
                    'via' => get_bloginfo('name')
                ])
            ]),
        ];

        // Let's add email.
        $socialSharingPlatforms[] = [
            'icon' => 'envelope',
            'platform' => 'email',
            'url' => implode('', [
                '?',
                http_build_query([
                    'subject' => rawurlencode(
                        implode(' ', [
                            'I wanted you to see this article about',
                            '"' . $post->post_title . '"'
                        ])
                    ),
                    'body' => implode('%20', [
                        rawurlencode('Check out the article at:'),
                        $postLink
                    ])
                ])
            ]),
        ];

        // Return.
        return $socialSharingPlatforms;
    }

    /**
     * Executes shell command.
     *
     * @param $data mixed
     *`
     * @since   1.0.0
     * @return  boolean
     */
    public static function executeShellCommand($sourceId)
    {
        // Basics.
        $response = [
            'process' => [
                'pid' => null,
                'duration' => '0 minutes',
                'message' => null,
                'status' => LoggerFunctions::$classProperties['status']['list']['initiated'],
                'output' => [],
            ],
            'source' => null
        ];

        /**
         * Finalize source.
         * 
         */
        // Sources array.
        $sourcesArray = [
            1 => [
                'commandType' => 'basic',
                'source' => 'api'
            ],
            2 => [
                'commandType' => 'clean',
                'source' => 'acf',
            ],
            3 => [
                'commandType' => 'clean',
                'source' => 'holiday',
            ],
            4 => [
                'commandType' => 'clean',
                'source' => 'preview',
            ],
            5 => [
                'commandType' => 'clean',
                'source' => 'status_changed',
            ],
        ];

        // Current source.
        $currentSource = array_key_exists($sourceId, $sourcesArray)
            ? $sourcesArray[$sourceId]
            : $sourcesArray[1];

        // Update source.
        $response['source'] = $currentSource;

        // Log this.
        do_action(
            'logger',
            $response,
            'debug'
        );
    }

    /**
     * Return if the environment is production.
     * 
     * @return boolean
     */
    public static function shouldEnforceSecureSsl()
    {
        return in_array(WP_ENV, [
            'production',
            'staging'
        ]);
    }

    /**
     * replace http: URL with https: URL
     * @param string $url
     * @return string
     */
    public static function sslInsecureContentFixUrl($url)
    {
        // only fix if source URL starts with http://
        if (
            self::shouldEnforceSecureSsl()
            && stripos($url, 'http://') === 0
        ) {
            $url = 'https' . substr($url, 4);
        }

        // Return.
        return $url;
    }

    /**
     * Post slack notification.
     * 
     * @since  1.0.0
     * @param  $data
     * @return  mixed
     */
    public static function postSlackNotification($data) {

        // Preparing message.
        $preparedContents = [
            'blocks' => $data,
            'text' => null
        ];

        // Slack webhook URL
        $notificationMeta = AcfElements::getNotificationsData(
            'slack'
        );

        // Finalize webhook URL.
        $slackWebhookUrl = !empty($notificationMeta['link_default'])
            ? $notificationMeta['link_default']['url']
            : 'https://hooks.slack.com/services/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';

        // Update text.
        $preparedContents['text'] = $notificationMeta['text_primary'];

        // POSTing data to an API.
        return wp_remote_post( $slackWebhookUrl, [
            'body' => json_encode($preparedContents)
        ]);
    }

    /**
     * User to send notifications.
     * 
     * @since  1.0.0
     * @param  $userSlackIds
     * @return  mixed
     */
    public static function userToSendNotifications($userSlackIds) {
        $slackMentionUsers = [];

        // Iterate.
        foreach($userSlackIds as $slackId) {
            $slackMentionUsers[] = '<@' . $slackId .'>';
        }

        // Return.
        return $slackMentionUsers;
    }

}