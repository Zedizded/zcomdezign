<?php

namespace Zcomdezign\PlatformBundle\Controller;


use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class ProfileController extends BaseController
{
    
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ZcomdezignPlatformBundle:Article')->findAll();
        $comments = $em->getRepository('ZcomdezignPlatformBundle:Comment')->findBy(array('warning' => '1'));
        

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'articles' => $articles,
            'comments' => $comments            
        ));
    }

} 
