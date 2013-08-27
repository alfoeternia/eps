<?php

namespace Eps\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EpsUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
