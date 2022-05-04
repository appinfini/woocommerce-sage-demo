<?php
namespace Packages\Wordpress\Theme;

// Basics.
use Packages\Wordpress\Theme\Configurations as ThemeConfigurations;
use Packages\Wordpress\Theme\DatabaseQueries as ThemeDatabaseQueries;
use Packages\Wordpress\Theme\notifications\JobCandidates;

class Apis
{
    /**
     * Class properties.
     *
     */
    public static $classConfigurations = [
        'apis' => [
            'postSlackNotificationsListing' => [
                'apiKey' => 'api_post_slack_notifications_listing',
                'nonceKey' => 'api_post_slack_notifications_listing_nonce',
                'scriptHandler' => 'js-ajax-custom-apis',
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
     * Post slack notifications.
     * 
     */
    public static function notifyJobCandidates() {

        // Basics.
        $acfPostGroupField = 'post_type_based_job_candidate';
        $acfPostGroupDateField = implode('_', [$acfPostGroupField, 'group_candidate_interview_date_time_primary']);
        $todayDate = date("Y-m-d");
        $notifications = [];

        // nonce check for an extra layer of security, the function will exit if it fails.
        /*if (!wp_verify_nonce($_REQUEST['nonce'], self::$classConfigurations['apis']['postSlackNotificationsListing']['nonceKey'])) {

            // Add message.
            $response['message'] = 'Invalid form request. Please try again.';
        }*/

        // Prepare meta query array to get today's job candidate.
        $queryParameters = [
            'option_query_posts_meta_query' => [
                [
                    'key' => $acfPostGroupDateField,
                    'value' => $todayDate,
                    'compare' => 'LIKE'
                ]
            ],
            'option_query_order_by_posts' => $acfPostGroupDateField,
            'option_query_sort_order' => 'ASC'
        ];

        // Get posts.
        $posts = ThemeDatabaseQueries::getPosts(
            ThemeConfigurations::$themeConfigurations['posts']['types']['data']['jobCandidate']['meta']['postType'],
            $queryParameters
        );

        // If we've posts?
        if(!empty($posts)) {
            // Get notifications.
            $notifications = JobCandidates::notify($posts);            
        }
        
        // Echo.
        echo json_encode($notifications);

        // don't forget to end your scripts with a die() function - very important
        die();
    }
}