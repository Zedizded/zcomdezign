<?php

namespace Zcomdezign\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zcomdezign\PlatformBundle\Entity\Article;
use Zcomdezign\PlatformBundle\Entity\User;
use Zcomdezign\PlatformBundle\Form\ArticleType;

class PlatformController extends Controller
{	
	/**
     * @Route("/", name="zcomdezign_platform_homepage")
     */
    public function indexAction()
	{
		return $this->render('ZcomdezignPlatformBundle:Default:index.html.twig');
	}
    
    /**
     * @Route("/creation", name="zcomdezign_platform_creation")
     */
    public function creationAction(Request $request)
	{
		$article = new Article();
		$form   = $this->get('form.factory')->create(ArticleType::class, $article);

		if ($request->isMethod('POST')) {
			
			$form->handleRequest($request);

			if ($form->isValid()) {

				$article->setUser( $this->getUser());

				$em = $this->getDoctrine()->getManager();
				$em->persist($article);
				$em->flush();
			}
		}

		return $this->render('ZcomdezignPlatformBundle:Default:creation.html.twig', array(
			'form' => $form->createView(),
			));
	}
    
    /**
     * @Route("/edition/{id}", name="zcomdezign_platform_edition")
     */
	public function editionAction(Request $request,article $article, $id)
	{
		
		$form   = $this->get('form.factory')->create(ArticleType::class, $article);

		if ($request->isMethod('POST')) {
			
			$form->handleRequest($request);

			if ($form->isValid()) {

				$em = $this->getDoctrine()->getManager();
				$em->flush();
			}
		}

		return $this->render('ZcomdezignPlatformBundle:Default:edition.html.twig', array(
			'form' => $form->createView(),
			));
	}
}
