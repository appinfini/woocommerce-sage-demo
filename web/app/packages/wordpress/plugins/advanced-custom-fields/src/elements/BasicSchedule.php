<?php
namespace Packages\Wordpress\Plugins\ACF\elements;
//date_default_timezone_set('Australia/Sydney');

// Basics.
use Packages\Wordpress\Theme\DatabaseQueries as ThemeDatabaseQueries;
use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;

class BasicSchedule
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
     * @param $dayTimings array
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getPreparedElement($dayTimings, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [];

        // Days array.
        $daysArray = [
            0 => [
                'day' => 'Monday'
            ],
            1 => [
                'day' => 'Tuesday'
            ],
            2 => [
                'day' => 'Wednesday'
            ],
            3 => [
                'day' => 'Thursday'
            ],
            4 => [
                'day' => 'Friday'
            ],
            5 => [
                'day' => 'Saturday'
            ],
            6 => [
                'day' => 'Sunday'
            ],
        ];

        // Let's get all the holidays.
        $holidays = ThemeDatabaseQueries::getHolidaysInRange();

        // 7 days from now.
        $date = date('Y-m-d', strtotime('-10 day', strtotime(date('Y-m-d')))); //today date
        for ($i = 1; $i <= 70; $i++) {
            $date = ($i == 1)
                ? $date
                : date('Y-m-d', strtotime('+1 day', strtotime($date)));
            $dayName = date('l', strtotime($date));

            // Let's iterate $daysArray.
            foreach ($daysArray as $key => $item) {

                // If this is equal to $dayName.
                if ($dayName == $item['day']) {

                    // Is it a holiday?
                    $rowHasOff = array_key_exists(
                        $date,
                        $holidays
                    );

                    // Let's prepare day.
                    $rowDay = $rowHasOff
                        ? $holidays[$date]['text_default']
                        : $daysArray[$key]['day'];

                    // Let's prepare day.
                    /*$rowDay = $rowHasOff
                        ? $holidays[$date]['text_default']
                        : ($i == 1
                            ? 'Today'
                            : ($i == 2
                                ? 'Tomorrow'
                                : $daysArray[$key]['day']));*/

                    // Add to $preparedContents.
                    $preparedContents[] = [
                        'day' => $rowDay,
                        'date' => date('jS F', strtotime($date)),
                        'datePlain' => $date,
                        'end' => $dayTimings[$key]['day_timings']['time_end'],
                        'hasOff' => $rowHasOff,
                        'message' => $rowHasOff
                            ? implode(
                                ' ',
                                [
                                    'Closed',
                                    'today'
                                ]
                            )
                            : implode(
                                ' ',
                                [
                                    'Open till',
                                    $dayTimings[$key]['day_timings']['time_end'],
                                    'today'
                                ]
                            ),
                        'start' => $dayTimings[$key]['day_timings']['time_start'],
                        'timing' => $rowHasOff
                            ? 'CLOSED'
                            : implode(' ', [
                                $dayTimings[$key]['day_timings']['time_start'],
                                'till',
                                $dayTimings[$key]['day_timings']['time_end']
                            ])
                    ];

                    // Break loop.
                    break;
                }
            }
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared element.
     *
     * @param $dayTimings array
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getPreparedElementForFullView($dayTimings, $additionalParameters = []) {

        // Let's get timings.
        $preparedContents = [
            AcfFunctions::getLayoutDynamicId(
                'schedule'
            ),
            'items' => self::getPreparedElement(
                $dayTimings,
                [
                    'isFullView' => true
                ]
            ),
            'heading' => null,
            'subHeadings' => [],
            'type' => 'schedule'
        ];

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared element.
     *
     * @param $dayTimings array
     * @param $post object | null
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getPreparedElementForMiniView($dayTimings, $post = null, $additionalParameters = []) {

        // Get some configurations.
        $websiteSettings = get_field('global_templates_general_settings_website_configuration', 'option');

        // Let's get timings.
        $preparedContents = [
            AcfFunctions::getLayoutDynamicId(
                'schedule'
            ),
            'items' => self::getPreparedElement(
                $dayTimings,
                [
                    'isFullView' => false
                ]
            ),
            'heading' => $post
                ? null
                : 'Some stores have differing trading hours.',
            'subHeadings' => [
                $post
                    ? get_the_title($post->ID)
                    : $websiteSettings['name_default']
            ],
            'type' => 'schedule'
        ];

        // Update heading.
        /*if ($preparedContents['items'][0]['hasOff']) {
            $preparedContents['subHeadings'][] = implode(' ', [
                'Closed',
                'today'
            ]);
        } else {
            $preparedContents['subHeadings'][] = implode(' ', [
                'Open till',
                $preparedContents['items'][0]['end'],
                'today'
            ]);
        }*/

        // Unset 1st row as well.
        //unset($preparedContents['items'][0]);

        // Reset keys.
        $preparedContents['items'] = array_values(
            $preparedContents['items']
        );

        // Return.
        return $preparedContents;
    }
}
