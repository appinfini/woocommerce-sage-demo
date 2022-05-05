<?php

namespace Packages\Wordpress\Plugins\ACF\elements;

// Basics.
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

// ACF Elements.
use Packages\Wordpress\Plugins\ACF\elements\BasicString as AcfElementBasicString;

class BasicArrayOfObject
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
     * @param $filterByColumn object
     * @param $type string
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string | null
     */
    public static function getPreparedElement($element, $filterByColumn, $type = 'singleRowText', $additionalParameters = [])
    {
        // Basics.
        $inputArray = [];
        $preparedContents = AcfElementBasicString::getPreparedElement(
            $element,
            $filterByColumn
        );

        // If we have contents?
        if ($preparedContents) {

            // Do we have text?
            $inputArray['text'] = AcfElementBasicString::getPreparedElement(
                $additionalParameters,
                'text'
            );

            // Switch cases.
            switch($type) {

                case 'link':
                    $preparedContents = self::getPreparedLink(
                        $preparedContents,
                        $inputArray['text']
                    );
                    break;

                case 'linkGroup':
                    $preparedContents = self::getPreparedLinkGroup(
                        $preparedContents,
                        $inputArray['text']
                    );
                    break;

                case 'linkGroupOther':
                    $preparedContents = self::getPreparedLinkGroupOther(
                        $preparedContents,
                        $inputArray['text']
                    );
                    break;
                    
                case 'linkField':
                    $preparedContents = self::getPreparedLinkField(
                        $preparedContents,
                        $inputArray['text']
                    );
                    break;

                case 'location':
                    $preparedContents = self::getPreparedLocation(
                        $preparedContents
                    );
                    break;

                case 'singleRowText':
                    $preparedContents = self::getPreparedText(
                        $preparedContents
                    );
                    break;

                case 'singleRowTextFromArrayOfObjects':
                    $preparedContents = self::getPreparedTextFromArrayOfObjects(
                        $preparedContents
                    );
                    break;

                case 'socials':
                    $preparedContents = self::getPreparedSocials(
                        $preparedContents
                    );
                    break;

                case 'tel':
                    $preparedContents = self::getPreparedTel(
                        $preparedContents
                    );
                    break;

                case 'telGroup':
                    $preparedContents = self::getPreparedTelGroup(
                        $preparedContents,
                        $inputArray['text']
                    );
                    break;

                default:
                    break;
            }
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared Link.
     *
     * @param $element object
     * @param $text string | null
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedLink($element, $text = null, $target = null, $additionalParameters = [])
    {
        // Basics.
        $link = (strpos($element, get_home_url()) !== FALSE) // if it contains current website URL.
            ? ((strpos($element, 'app/uploads') === FALSE) // If it doesn't contain uploads directory URL?
                ? wp_make_link_relative($element)
                : $element
            )
            : AcfElementBasicString::getContentWithRelativeUrls(
                [
                    'link_default' => $element
                ],
                'link_default'
            );

        // Finalize text.
        // Check for null and empty strings.
        if (empty($text)) {
            $parsedUrl = parse_url($link);
            $text = $parsedUrl['host'] . $parsedUrl['path'];

            // Remove www as well.
            if (strpos($text, 'www.') !== FALSE) {
                $text = str_replace(
                    'www.',
                    '',
                    $text
                );
            }
        }

        // Prepare content.
        $preparedContents = [
            'subType' => (substr($link, 0, 1) === '/')
                ? 'internal'
                : 'external',
            'target' => $target,
            'type' => 'link',
            'text' => $text,
            'value' => $link
        ];

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared Link.
     *
     * @param $element object
     * @param $text string | null
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedLinkField($element, $text = null, $additionalParameters = [])
    {
        return self::getPreparedLink(
            $element['url'],
            $text
                ? $text
                : $element['title'],
            AcfElementBasicString::getPreparedElement(
                $element,
                'target'
            )
        );
    }

    /**
     * Return prepared Link.
     *
     * @param $element object | array
     * @param $text string | null
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedLinkGroup($element, $text = null, $additionalParameters = [])
    {
        // Basics.
        $element = is_object($element)
            ? [
                'url' => get_the_permalink($element->ID),
                'title' => $element->post_title
            ]
            : $element;

        // Get contents.
        $preparedContents = self::getPreparedLinkField(
            $element,
            $text
        );

        // Return.
        return [
            'label' => $preparedContents['text'],
            'item' => $preparedContents
        ];
    }

    /**
     * Return prepared Link.
     * Which has separate label and item['text'] values.
     *
     * @param $element object | array
     * @param $text string | null
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedLinkGroupOther($element, $text = null, $additionalParameters = [])
    {
        // Get contents.
        $preparedContents = self::getPreparedLinkField(
            $element,
            null
        );

        // Return.
        return [
            'label' => !empty($text)
                ? $text
                : $preparedContents['text'],
            'item' => $preparedContents
        ];
    }

    /**
     * Return prepared Location.
     *
     * @param $element object
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedLocation($element, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [
            'subType' => null,
            'target' => null,
            'type' => 'multiRowText',
            'text' => null,
            'value' => null
        ];

        // Do we have the level taxonomy?
        if (!empty($element['level'])) {
            $preparedContents['text'] = $element['level']->name;
        }

        // Do we have the address?
        if (!empty($element['address'])) {
            $preparedContents['value'] = $element['address'];
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared social links.
     *
     * @param $element object
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array
     */
    public static function getPreparedSocials($element, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [];

        // Platforms.
        $platformsArray = [
            'facebook' => [
                'prefix' => 'https://www.facebook.com'
            ],
            'instagram' => [
                'prefix' => 'https://www.instagram.com'
            ]
        ];

        // Iterate links.
        foreach ($platformsArray as $platform => $row) {
            $preparedContents[] = [
                'id' => $platform,
                'icon' => null,
                'platform' => ucwords($platform),
                'url' => implode('/', [
                    $row['prefix'],
                    AcfElementBasicString::getPreparedElement(
                        $element['group_' . $platform],
                        'text_default'
                    ),
                    ''
                ])
            ];
        }

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared Tel.
     *
     * @param $element object
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedTel($element, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [
            'subType' => null,
            'target' => null,
            'type' => 'tel',
            'text' => !empty($element[0]['label'])
                ? $element[0]['label']
                : $element[0]['value'],
            'value' => $element[0]['value']
        ];

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared tel.
     *
     * @param $element object
     * @param $text string | null
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedTelGroup($element, $text, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = self::getPreparedTel(
            $element,
            $additionalParameters
        );

        // Return.
        return [
            'label' => $text,
            'item' => $preparedContents
        ];
    }

    /**
     * Return prepared text.
     *
     * @param $element object
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedText($element, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [
            'subType' => null,
            'target' => null,
            'type' => 'singleRowText',
            'text' => null,
            'value' => $element
        ];

        // Return.
        return $preparedContents;
    }

    /**
     * Return prepared text.
     *
     * @param $element object
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  array | null
     */
    public static function getPreparedTextFromArrayOfObjects($element, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [
            'subType' => null,
            'target' => null,
            'type' => 'singleRowText',
            'text' => null,
            'value' => null
        ];
        $valueParts = [];

        // Iterate element.
        foreach ($element as $row) {
            $valueParts[] = $row->post_title; // these would be simple strings.
        }

        // Update $preparedContents.
        $preparedContents['value'] = implode(', ', $valueParts);
        $preparedContents['value'] = strtolower($preparedContents['value']);
        $preparedContents['value'] = ucfirst($preparedContents['value']);

        // Return.
        return $preparedContents;
    }
}
