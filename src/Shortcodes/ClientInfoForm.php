<?php

namespace DisputeSuite\Shortcodes;

use DisputeSuite\Entities\Customer;
use DisputeSuite\Template;

use Respect\Validation\Validator as v;

/**
 * A shortcode to display the client information form.
 *
 * Usage: [ds-client-info-form]
 */
class ClientInfoForm extends AbstractShortcode
{
    /**
     * Initializes the object, specifying the default attributes.
     */
    public function __construct()
    {
        $defaults = [
            'applicant' => 'primary',
            'privacy' => 'privacy-policy',
            'terms' => 'terms-of-use'
        ];
        parent::__construct('ds-client-info-form', [$this, 'doForm'], $defaults);
    }

    /**
     * Creates the form.
     *
     * @return string
     */
    public function doForm($atts)
    {
        if (!Customer::isSupportedType($atts['applicant'])) {
            return "<i><strong>ERROR:</strong> the applicant type '{$atts['applicant']}' is not valid for the shortcode [ds-client-info-form].</i>";
        }
        if (v::key('privacy', v::not(v::notEmpty()))->validate($atts)) {
            return "<i><strong>ERROR:</strong> the shortcode [ds-client-info-form] requires a link to the privacy policy.</i>";
        }
        if (v::key('terms', v::not(v::notEmpty()))->validate($atts)) {
            return "<i><strong>ERROR:</strong> the shortcode [ds-client-info-form] requires a link to the terms of use.</i>";
        }

        $data = $atts;

        return Template::getAsString('shortcode.ds-client-info-form', $data);
    }
}