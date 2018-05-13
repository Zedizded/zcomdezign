<?php

namespace Zcomdezign\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zcomdezign\PlatformBundle\Entity\User;
use Zcomdezign\PlatformBundle\Entity\Article;
use Zcomdezign\PlatformBundle\Entity\Comment;
use Zcomdezign\PlatformBundle\Form\ArticleType;
use Zcomdezign\PlatformBundle\Form\CommentType;

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
     * @Route("/blog", name="zcomdezign_platform_blog")
     */
	public function blogAction()
	{
		$em = $this->getDoctrine()->getManager();

		$articles = $em->getRepository('ZcomdezignPlatformBundle:Article')->findAll();

		return $this->render('ZcomdezignPlatformBundle:Default:blog.html.twig', array(
			'articles' => $articles
			));
	}
    
    /**
     * @Route("/blog/creation", name="zcomdezign_platform_creation")
     */
    public function creationAction(Request $request)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            $article = new Article();
			$form = $this->get('form.factory')->create(ArticleType::class, $article);
            
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

				$article->setUser( $this->getUser());

				$em = $this->getDoctrine()->getManager();
				$em->persist($article);
				$em->flush();
                
            $request->getSession()->getFlashBag()->add('info', 'Votre article a bien été enregistrée.');
			}

		return $this->render('ZcomdezignPlatformBundle:Default:creation.html.twig', array(
				'form' => $form->createView()
				));
        }
        return $this->redirectToRoute('zcomdezign_platform_homepage');
    }
    
    
    /**
     * @Route("/blog/edition/{id}", name="zcomdezign_platform_edition")
     */
	public function editionAction(Request $request,article $article, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$form = $this->get('form.factory')->create(ArticleType::class, $article);

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

				$em = $this->getDoctrine()->getManager();
				$em->flush();
                
            $request->getSession()->getFlashBag()->add('info', 'Votre commentaire a bien été enregistrée.');
			}

        return $this->render('ZcomdezignPlatformBundle:Default:edition.html.twig', array(
				'form' => $form->createView()
				));
		}
		return $this->redirectToRoute('zcomdezign_platform_homepage');
	}
    
    /**
     * @Route("/blog/article/{id}", name="zcomdezign_platform_article")
     */
	public function articleAction(Request $request, article $article, $id)
	{

        $comment = new Comment();
		$form = $this->get('form.factory')->create(CommentType::class, $comment);

		$em = $this->getDoctrine()->getManager();

		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

			$comment->setUser($this->getUser());
			$comment->setArticle($article);
            
			$em->persist($comment);
			$em->flush();
			
			// Clears the form
			$comment = new Comment();
			$form = $this->get('form.factory')->create(CommentType::class, $comment);
		}

		$comments = $em->getRepository('ZcomdezignPlatformBundle:Comment')->findBY(array('article' => $article));
        
        return $this->render('ZcomdezignPlatformBundle:Default:article.html.twig', array(
        
            'form' => $form->createView(),
			'article' => $article,
			'comments' => $comments
 			));
	}
}
