<?php

namespace DisputeSuite\Entities;

use DisputeSuite\PostTypes\Step as CPTStep;

/**
 * The object representation of the CPT post in Wordpress.
 */
class Step extends AbstractEntity
{
    /**
     * @var string
     */
    protected static $postType = CPTStep::SLUG;

    /**
     * @param array $params
     *
     * @throws \Respect\Validation\Exceptions\NestedValidationException
     */
    public function __construct(array $params)
    {
        parent::__construct($params);
    }
}