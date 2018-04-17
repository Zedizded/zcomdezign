<?php

namespace Zcomdezign\PlatformBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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
    
    public function __construct()
    {
        parent::__construct();
        
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
}
