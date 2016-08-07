<?php

namespace DisputeSuite\Entities;

use DisputeSuite\PostTypes\Service as CPTService;

use Respect\Validation\Validator as v;

/**
 * The object representation of the CPT post in Wordpress.
 */
class Service extends AbstractEntity
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var float
     */
    private $monthlyFee;

    /**
     * @var float
     */
    private $setupFee;

    /**
     * @var boolean
     */
    private $hasCoclient;

    /**
     * @var string
     */
    protected static $postType = CPTService::SLUG;

    /**
     * @var array
     */
    protected static $customFields = [
        'label' => 'ds-service-label',
        'monthlyFee' => 'ds-service-monthly-fee',
        'setupFee' => 'ds-service-setup-fee',
        'hasCoclient' => 'ds-service-has-coclient'
    ];

    /**
     * @param array $params
     *
     * @throws \Respect\Validation\Exceptions\NestedValidationException
     */
    public function __construct(array $params)
    {
        $validators = [
            v::key('label', v::stringType()->notEmpty()),
            v::key('monthlyFee', v::floatVal()->min(0)),
            v::key('setupFee', v::floatVal()->min(0)),
            v::key('hasCoclient', v::oneOf(v::trueVal(), v::falseVal()))
        ];

        parent::__construct($params, $validators);

        $this->label = $params['label'];
        $this->monthlyFee = (float) $params['monthlyFee'];
        $this->setupFee = (float) $params['setupFee'];
        $this->hasCoclient = filter_var($params['hasCoclient'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return float
     */
    public function getMonthlyFee()
    {
        return $this->monthlyFee;
    }

    /**
     * @return float
     */
    public function getSetupFee()
    {
        return $this->setupFee;
    }

    /**
     * @return boolean
     */
    public function hasCoclient()
    {
        return $this->hasCoclient;
    }
}