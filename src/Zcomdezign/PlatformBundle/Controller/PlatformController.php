<?php

namespace Zcomdezign\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zcomdezign\PlatformBundle\Entity\User;
use Zcomdezign\PlatformBundle\Entity\Article;
use Zcomdezign\PlatformBundle\Entity\ArticlePicture;
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


				$em = $this->getDoctrine()->getManager();
                
                $article->setUser($this->getUser());
 				$em->persist($article);
                
				$articlePicture = $article->getArticlePicture();
				if ($articlePicture !== null)
				{
					$articlePicture->setAlt($article->getTitle());
					$articlePicture->setRandom(rand());
					$em->persist($articlePicture);
				}
                
				$em->flush();
                
            $request->getSession()->getFlashBag()->add('info', "L'article a bien été enregistré.");
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
	public function editionAction(Request $request, Article $article, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$form = $this->get('form.factory')->create(ArticleType::class, $article);

			if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

				$em = $this->getDoctrine()->getManager();
                $articlePicture = $article->getArticlePicture();

				if ($articlePicture !== null)
				{
					$articlePicture->setRandom(rand());
					$articlePicture->setAlt($article->getTitle());
					$em->persist($articlePicture);
				}
				$em->flush();
                
            $request->getSession()->getFlashBag()->add('info', "L'article a bien été enregistré.");
			}

        return $this->render('ZcomdezignPlatformBundle:Default:edition.html.twig', array(
				'form' => $form->createView(),
                'article' => $article
            ));
		}
		return $this->redirectToRoute('zcomdezign_platform_homepage');
	}
    
    /**
     * @Route("/blog/article/{id}", name="zcomdezign_platform_article")
     */
	public function articleAction(Request $request, Article $article, $id)
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

		$comments = $em->getRepository('ZcomdezignPlatformBundle:Comment')->findBY(array('article' => $article), array('id' => 'desc'));
        
        return $this->render('ZcomdezignPlatformBundle:Default:article.html.twig', array(
        
            'form' => $form->createView(),
			'article' => $article,
			'comments' => $comments
 			));
        
	}
    
	/**
     * @Route("/blog/comment/{id}", name="zcomdezign_platform_signalComment")
     */
	public function signalCommentAction(Request $request, Comment $comment, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$comment->setWarning(true);
		$em->flush();

		$request->getSession()->getFlashBag()->add('info', 'Le commentaire a bien été signalé.');

		return $this->redirectToRoute('zcomdezign_platform_article', array('id' => $comment->getArticle()->getId()));
    
	}
    
    /**
     * @Route("/blog/suppression/{id}", name="zcomdezign_platform_suppression")
     */
	public function suppressionAction(Request $request, Article $article, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$em = $this->getDoctrine()->getManager();

			$em->remove($article);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimé.");

			return $this->redirectToRoute('fos_user_profile_show');
		}
		return $this->redirectToRoute('zcomdezign_platform_homepage');

	}

	/**
     * @Route("/blog/commentValidation/{id}", name="zcomdezign_platform_commentValidation")
     */
	public function commentValidationAction(Request $request, Comment $comment, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$em = $this->getDoctrine()->getManager();

			$comment->setWarning(false);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', "Le commentaire a bien été validé.");

			return $this->redirectToRoute('fos_user_profile_show');
		}

		return $this->redirectToRoute('zcomdezign_platform_homepage');

	}

	/**
     * @Route("/blog/commentSuppression/{id}", name="zcomdezign_platform_commentSuppression")
     */
	public function commentSuppressionAction(Request $request, Comment $comment, $id)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$em = $this->getDoctrine()->getManager();

			$em->remove($comment);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', "Le commentaire a bien été supprimé.");

			return $this->redirectToRoute('fos_user_profile_show');
		}

		return $this->redirectToRoute('zcomdezign_platform_homepage');

	}
    
    /**
     * @Route("/blog/pictureSuppression/{id}/{articleId}", name="zcomdezign_platform_pictureSuppression")
     */
	public function pictureSuppressionAction(Request $request, ArticlePicture $articlePicture, $id, $articleId)
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			
			$em = $this->getDoctrine()->getManager();

			$em->remove($articlePicture);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', "L'image a bien été supprimée.");

			return $this->redirectToRoute('zcomdezign_platform_edition',  array('id' => $articleId));
		}

		return $this->redirectToRoute('zcomdezign_platform_homepage');

	}
    
}
