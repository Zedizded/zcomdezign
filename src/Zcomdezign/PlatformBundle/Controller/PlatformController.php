<?php

namespace Zcomdezign\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlatformController extends Controller
{
    public function indexAction()
    {
        return $this->render('ZcomdezignPlatformBundle:Default:index.html.twig');
    }
}
