<?php

namespace Zcomdezign\PlatformBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="zcomdezign_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="text", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="text", length=255)
     */
    private $lastName;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="zcomdezignMember", type="boolean")
     */
    private $zcomdezignMember;
    
    /**
     * @ORM\OneToMany(targetEntity="Zcomdezign\PlatformBundle\Entity\Article", mappedBy="user")
     */
    private $articles;
 
    /**
     * @ORM\OneToMany(targetEntity="Zcomdezign\PlatformBundle\Entity\Comment", mappedBy="user")
     */
    private $comments;
    
    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->articles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->roles[] = 'ROLE_USER';
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * Set zcomdezignMember
     *
     * @param boolean $zcomdezignMember
     *
     * @return User
     */
    public function setZcomdezignMember($zcomdezignMember)
    {
        $this->zcomdezignMember = $zcomdezignMember;

        return $this;
    }

    /**
     * Get zcomdezignMember
     *
     * @return boolean
     */
    public function getZcomdezignMember()
    {
        return $this->zcomdezignMember;
    }
    
    /**
     * Add article
     *
     * @param \Zcomdezign\PlatformBundle\Entity\Article $article
     *
     * @return User
     */
    public function addArticle(\Zcomdezign\PlatformBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \Zcomdezign\PlatformBundle\Entity\Article $article
     */
    public function removeArticle(\Zcomdezign\PlatformBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Add comment
     *
     * @param \Zcomdezign\PlatformBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\Zcomdezign\PlatformBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Zcomdezign\PlatformBundle\Entity\Comment $comment
     */
    public function removeComment(\Zcomdezign\PlatformBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
