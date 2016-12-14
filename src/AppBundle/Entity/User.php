<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class User implements UserInterface
{
<<<<<<< HEAD
    const USERROLE_DEFAULT = 'ROLE_USER';
    const USERROLE_STUDENT = 'ROLE_STUDENT';
    const USERROLE_PROF = 'ROLE_PROF';
=======
    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_STUDENT = 'ROLE_STUDENT';
    const ROLE_PROF = 'ROLE_PROF';
>>>>>>> 73fdfb9c9c99bb11206b13bdf2447394c197b7a9

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
<<<<<<< HEAD
     * @ORM\Column(type="string")
=======
     * @ORM\Column(type="string", unique=true)
     * @Serializer\Expose
>>>>>>> 73fdfb9c9c99bb11206b13bdf2447394c197b7a9
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $usersurname;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Serializer\Expose
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
<<<<<<< HEAD
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="user")
     * one student belong to many slots
     */
    private $slot;

    /**
     * @ORM\OneToMany(targetEntity="Meeting", mappedBy="user")
     * one professor belong to many meetings
     */
    private $meeting;

    /**
     * @ORM\ManyToMany(targetEntity="Studycourse", mappedBy="user")
     * many user belong to many study courses
     */
    private $studycourse;

    /**
     * @ORM\Column(type="string")
     */
    private $userRoles;

    /**
     * @ORM\Column(type="string")
     */
    private $lectures;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    public function __construct()
    {
        $this->lectures = array();
        $this->userRole = array();
        $this->studycourse = array ();
    }

    public function getRoles()
    {
        $userRole = $this->userRoles;
        // we need to make sure to have at least one role
        $userRole[] = static::USERROLE_DEFAULT;
        return array_unique($userRole);
    }
=======
     * @ORM\Column(type="array")
     * @Serializer\Expose
     */
    private $roles;

    private $firstname;

    private $lastname;

    private $studyCourses;

    private $title;


    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = array();
    }

>>>>>>> 73fdfb9c9c99bb11206b13bdf2447394c197b7a9

    public function addRole($userRole)
    {
        $userRole = strtoupper($userRole);
        if ($userRole === static::USERROLE_DEFAULT) {
            return $this;
        }
        if (!in_array($userRole, $this->userRoles, true)) {
            $this->userRoles[] = $userRole;
        }
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getUserSurname()
    {
        return $this->userSurname;
    }
    public function setUserSurname($userSurname)
    {
        $this->userSurname = $userSurname;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getUserRole()
    {
        return $this->userRole;
    }
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;
    }

    public function getLecture()
    {
        return $this->lecture;
    }
    public function setLecture($lecture)
    {
        $this->lecture = $lecture;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
<<<<<<< HEAD
        $this->title = $title;
=======
        $roles = $this->roles;

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
>>>>>>> 73fdfb9c9c99bb11206b13bdf2447394c197b7a9
    }

    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }
}
