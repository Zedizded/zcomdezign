<?php

namespace Zcomdezign\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zcomdezign\PlatformBundle\Entity\Article;
use Zcomdezign\PlatformBundle\Entity\User;
use Zcomdezign\PlatformBundle\Form\ArticleType;

class PlatformController extends Controller
{
    public function indexAction()
	{
		return $this->render('ZcomdezignPlatformBundle:Default:index.html.twig');
	}

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
}
