<?php

namespace DisputeSuite;

use Respect\Validation\Validator as v;

/**
 * Manages the PHP Session.
 */
class SessionManager
{
    /**
     * Initializes the object and hooks the required actions.
     */
    public function __construct()
    {
        Loader::addAction('init', [$this, 'startSession'], 0);
        Loader::addAction(['wp_login', 'wp_logout'], [$this, 'endSession'], 0);
    }

    /**
     * Starts a new PHP session, if possible.
     */
    public function startSession()
    {
        if(!session_id()) {
            session_start();
        }

        if (!v::key('dispute-suite')->validate($_SESSION)) {
            $_SESSION['dispute-suite'] = null;
        }
    }

    /**
     * Destroys the current PHP session.
     */
    public function endSession()
    {
        session_destroy();
    }
}