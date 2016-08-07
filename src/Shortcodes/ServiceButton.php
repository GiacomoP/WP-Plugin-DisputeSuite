<?php

namespace DisputeSuite\Shortcodes;

use DisputeSuite\Template;
use DisputeSuite\Entities\Service as EService;

use Respect\Validation\Validator as v;

/**
 * A shortcode to display a button containing a service's information, with a
 * link to the first signup step.
 *
 * Usage:
 *
 * - Show a service's button.<br>
 * [ds-service-button id="SERVICE_ID"]
 */
class ServiceButton extends AbstractShortcode
{
    /**
     * Initializes the object, specifying the default attributes.
     */
    public function __construct()
    {
        $defaults = [
            'id' => ''
        ];
        parent::__construct('ds-service-button', [$this, 'doButton'], $defaults);
    }

    /**
     * Creates the button.
     *
     * @param array $atts
     *
     * @return string
     */
    public function doButton($atts)
    {
        $service = EService::fetchById($atts['id']);
        if (v::nullType()->validate($service)) {
            return "<i><strong>ERROR:</strong> could not find service with id: {$atts['id']}.</i>";
        } elseif ($service === false) {
            return "<i><strong>ERROR:</strong> service with id {$atts['id']} is not configured correctly.</i>";
        }

        return Template::getAsString('shortcode.ds-service-button', $service);
    }
}