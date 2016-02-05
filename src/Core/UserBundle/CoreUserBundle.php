<?php

namespace Core\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreUserBundle extends Bundle
{
    /**
     * evenement symfony
     * Logged In
     */
    const USER_LOGGED_IN = 'security.interactive_login';

    /**
     * Logged In
     */
    const USER_SIGNED_UP = 'user_signed_up';

}
