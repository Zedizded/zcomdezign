<?php

namespace Zcomdezign\PlatformBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZcomdezignPlatformBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
