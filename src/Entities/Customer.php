<?php

namespace DisputeSuite\Entities;

use Respect\Validation\Validator as v;

/**
 * A Dispute Suite Customer entity.
 */
class Customer
{
    /**
     * @const string
     */
    const PRIMARY = 'primary';

    /**
     * @const string
     */
    const SECONDARY = 'secondary';

    /**
     * @var int The Customer ID in Dispute Suite.
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $ssn;

    /**
     * @var \DateTime
     */
    private $dob;

    /**
     * @var int
     */
    private $recordTypeId;

    /**
     * @var int
     */
    private $statusId;

    /**
     * @var int
     */
    private $folderId;

    /**
     * @var int
     */
    private $salesRepId;

    /**
     * @var int
     */
    private $caseAgentId;

    /**
     * @var int
     */
    private $workflowId;

    /**
     * @var string
     */
    private $source;

    /**
     * @var boolean
     */
    private $emailsOptin;

    /**
     * Creates a new Customer.
     *
     * @param array $params
     *
     * @throws \Respect\Validation\Exceptions\NestedValidationException
     */
    public function __construct(array $params)
    {
        v::keySet(
            v::key('id', v::intVal(), false),
            v::key('firstName', v::stringType()->notEmpty()),
            v::key('lastName', v::stringType()->notEmpty()),
            v::key('email', v::email()),
            v::key('phone', v::phone()),
            v::key('address', v::arrayType()->length(2, 2, true)),
            v::key('city', v::stringType()->notEmpty()),
            v::key('state', v::stringType()->length(2, 2, true)),
            v::key('zip', v::postalCode('US')),
            v::key('ssn', v::intVal(), false),
            v::key('dob', v::date(), false),
            v::key('recordTypeId', v::intVal(), false),
            v::key('statusId', v::intVal(), false),
            v::key('folderId', v::intVal(), false),
            v::key('salesRepId', v::intVal(), false),
            v::key('caseAgentId', v::intVal(), false),
            v::key('workflowId', v::intVal(), false),
            v::key('emailsOptin', v::oneOf(v::trueVal(), v::falseVal()))
        )->assert($params);

        $this->id = (int) $params['id'];
        $this->firstName = $params['firstName'];
        $this->lastName = $params['lastName'];
        $this->email = $params['email'];
        $this->phone = $params['phone'];
        $this->address = $params['address'];
        $this->city = $params['city'];
        $this->state = $params['state'];
        $this->zip = $params['zip'];
        $this->ssn = $params['ssn'];
        $this->dob = $params['dob'];
        $this->recordTypeId = (int) $params['recordTypeId'];
        $this->statusId = (int) $params['statusId'];
        $this->folderId = (int) $params['folderId'];
        $this->salesRepId = (int) $params['salesRepId'];
        $this->caseAgentId = (int) $params['caseAgentId'];
        $this->workflowId = (int) $params['workflowId'];
        $this->source = 'Wordpress Plugin';
        $this->emailsOptin = filter_var($params['emailsOptin'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Checks if a customer/applicant type is supported.
     *
     * @param string $type
     *
     * @return boolean
     */
    public static function isSupportedType($type)
    {
        return v::in([self::PRIMARY, self::SECONDARY])->validate($type);
    }

    /**
     * Returns a mapping to associate form elements with entity's attributes.
     *
     * @return array
     */
    public static function formIntoEntityMap()
    {
        return [
            'first-name' => 'firstName',
            'last-name' => 'lastName',
            'email' => 'email',
            'phone' => 'phone',
            'addr1' => 'address',
            'addr2' => 'address',
            'city' => 'city',
            'state' => 'state',
            'zip' => 'zip'
        ];
    }
}