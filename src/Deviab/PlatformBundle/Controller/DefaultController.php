<?php

namespace Deviab\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DeviabPlatformBundle:Default:index.html.twig', array('name' => $name));
    }
}
