<?php

namespace NeptuneVs\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NeptuneVsUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
