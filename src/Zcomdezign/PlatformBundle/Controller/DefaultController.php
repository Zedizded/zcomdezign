<?php

namespace Zcomdezign\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ZcomdezignPlatformBundle:Default:index.html.twig');
    }
}
