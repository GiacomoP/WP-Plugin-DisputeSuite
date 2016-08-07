<?php

namespace DisputeSuite\Shortcodes;

use DisputeSuite\App;

use Respect\Validation\Validator as v;

/**
 * A shortcode to display services' information.
 *
 * Usage:
 *
 * - Print a specific service's title.<br>
 * [ds-service data="title" id="SERVICE_ID"]
 *
 * - Print the selected service's title.<br>
 * [ds-service data="title"]
 *
 * - Print the selected service's short label.<br>
 * [ds-service data="label"]
 *
 * - Print the selected service's setup fee.<br>
 * [ds-service data="setup-fee"]
 *
 * - Print the selected service's monthly fee.<br>
 * [ds-service data="monthly-fee"]
 */
class Service extends AbstractShortcode
{
    /**
     * Initializes the object, specifying the default attributes.
     */
    public function __construct()
    {
        $session = App::getSession();
        $services = App::getServices();

        if (v::key('serviceId', v::in($services))->validate($session)) {
            $id = $session['serviceId'];
        } else {
            $id = null;
        }

        $defaults = [
            'id' => $id,
            'data' => 'title'
        ];
        parent::__construct('ds-service', [$this, 'doService'], $defaults);
    }

    /**
     * Displays the service's information.
     *
     * @param array $atts
     *
     * @return string
     */
    public function doService($atts)
    {
        $services = App::getServices();

        if (v::key('id', v::nullType())->validate($atts)) {
            return '<i><strong>ERROR:</strong> [ds-service] failed to find a service ID in the user session.</i>';
        }
        if (!v::key($atts['id'])->validate($services)) {
            return "<i><strong>ERROR:</strong> the specified id '{$atts['id']}' for [ds-service] is not the id of a Service.</i>";
        }

        /** @var \DisputeSuite\Entities\Service */
        $service = $services[$atts['id']];

        switch ($atts['data']) {
            case 'title':
                $ret = $service->getTitle();
                break;
            case 'label':
                $ret = $service->getLabel();
                break;
            case 'monthly-fee':
                $ret = $service->getMonthlyFee();
                break;
            case 'setup-fee':
                $ret = $service->getSetupFee();
                break;
            default:
                $ret = "<i><strong>ERROR:</strong> the specified data '{$atts['data']}' for [ds-service] is not valid.</i>";
                break;
        }

        return $ret;
    }
}