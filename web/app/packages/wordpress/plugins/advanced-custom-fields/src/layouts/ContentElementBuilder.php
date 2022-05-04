<?php
namespace Packages\Wordpress\Plugins\ACF\layouts;
// Basics.
use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;
// ACF Elements.
use Packages\Wordpress\Plugins\ACF\elements\BasicString as AcfElementBasicString;
class ContentElementBuilder
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
     * @param $elementMeta array
     * @param $additionalParameters array
     *
     * @since   1.0.0
     * @return  string
     */
    public static function getPreparedElement($elementMeta, $args, $context, $info, $additionalParameters = [])
    {
        // Basics.
        $preparedContents = [
            'id' => AcfFunctions::getLayoutIdByField(
                $elementMeta
            ),
            'heading' => null,
            'content' => null,
            'type' => 'content_element_builder'
        ];
        // Let's get element.
        $behaviorSettings = AcfFunctions::getLayoutObjectByField(
            $elementMeta,
            null,
            [
                'info' => $info
            ]
        );

        // Log this.
        /*do_action('logger', [
            'element' => $elementMeta,
            'info' => $info->path,
            'behaviorSettings' => $behaviorSettings
        ]);*/

        // Do we have any?
        if (ThemeFunctions::hasValidArrayContents($behaviorSettings)) {
            // Let's update heading.
            $preparedContents['heading'] = !empty($behaviorSettings['heading_default'])
                ? $behaviorSettings['heading_default']
                : null;
            // Let's update content.
            $preparedContents['content'] = !empty($behaviorSettings['content_long'])
                ? $behaviorSettings['content_long']
                : null;
        }
        // Return.
        return $preparedContents;
    }
}