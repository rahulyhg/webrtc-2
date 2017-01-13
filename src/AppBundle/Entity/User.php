<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @Serializer\ExclusionPolicy("all")
 * @UniqueEntity("username", message="Username bereits vergeben", groups={"Create"})
 */
class User implements UserInterface
{
    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_STUDENT = 'ROLE_STUDENT';
    const ROLE_PROF = 'ROLE_PROF';
    const ROLE_ADMIN = 'ROLE_ADMIN';


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**

     * @ORM\Column(type="string", unique=true)
     * @Serializer\Expose
     * @Assert\NotBlank(
     *      message="Bitte geben Sie einen Username an",
     *      groups={"Default"}
     * )
     * @Assert\Regex(
     *      pattern="/^(?=(?:.*?[a-zA-Z]){2})[a-zA-Z'\s-]{2,100}$/",
     *      message="Der Username entspricht nicht den Vorgaben",
     *      groups={"Default"}
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     * @Assert\NotBlank(
     *      message="Bitte geben Sie einen Firstname an",
     *      groups={"Default"}
     * )
     * @Assert\Regex(
     *      pattern="/^(?=(?:.*?[a-zA-Z]){2})[a-zA-Z'\s-]{2,100}$/",
     *      message="Der Firstname entspricht nicht den Vorgaben",
     *      groups={"Default"}
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     * @Assert\NotBlank(
     *      message="Bitte geben Sie einen Lastname an",
     *      groups={"Default"}
     * )
     * @Assert\Regex(
     *      pattern="/^(?=(?:.*?[a-zA-Z]){2})[a-zA-Z'\s-]{2,100}$/",
     *      message="Der Lastname entspricht nicht den Vorgaben",
     *      groups={"Default"}
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     * @Serializer\Expose
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     * @Assert\Regex(
     *      pattern="/^(?=(?:.*?[a-zA-Z]){2})[a-zA-Z'\s-]{2,100}$/",
     *      message="Der Titel entspricht nicht den Vorgaben",
     *      groups={"Default"}
     * )
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="student")
     * one student belong to many slots
     */
    private $slots;

    /**
     * @ORM\OneToMany(targetEntity="Meeting", mappedBy="professor")
     * one professor belong to many meetings
     */
    private $meetings;

    /**
     * @ORM\ManyToMany(targetEntity="Studycourse", mappedBy="users")
     * @Serializer\Expose
     * many user belong to many study courses
     */
    private $studycourses;


    public function __construct()
    {
        $this->roles = array();
        $this->slots = new ArrayCollection();
        $this->meetings = new ArrayCollection();
        $this->studycourses = new ArrayCollection();
    }


    public function getRoles()
    {
        $roles = $this->roles;
        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;
        return array_unique($roles);
    }


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

    /**
     * {@inheritdoc}
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
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
    /*
    public function getUserSurname()
    {
        return $this->userSurname;
    }
    public function setUserSurname($userSurname)
    {
        $this->userSurname = $userSurname;
    }
    */

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;

    }


    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getSlots()
    {
        return $this->slots;
    }

    public function addSlot(Slot $slot)
    {
        if(!$this->slots->contains($slot))
        {
            $this->slots->add($slot);
        }
    }

    public function removeSlot(Slot $slot)
    {
        if($this->slots->contains($slot))
        {
            $this->slots->remove($slot);
        }
    }

    public function getMeetings()
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting)
    {
        if(!$this->meetings->contains($meeting))
        {
            $this->meetings->add($meeting);
        }
    }

    public function removeMeeting(Meeting $meeting)
    {
        if($this->meetings->contains($meeting))
        {
            $this->meetings->remove($meeting);
        }
    }

    public function getStudycourses()
    {
        return $this->studycourses;
    }

    public function addStudyCourse(Studycourse $studycourse)
    {
        if(!$this->studycourses->contains($studycourse))
        {
            $this->studycourses->add($studycourse);
        }
    }

    public function removeStudyCourse(Studycourse $studycourse)
    {
        if($this->studycourses->contains($studycourse))
        {
            $this->studycourses->remove($studycourse);
        }
    }
}
