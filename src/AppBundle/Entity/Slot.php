<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="slot")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SlotRepository")
 * @Serializer\ExclusionPolicy("all")
 */

class Slot
{
    const STATUS_OPEN = 'OPEN';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_DECLINED = 'DECLINED';
    const STATUS_CANCELED = 'CANCELED';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     * @Assert\NotBlank(
     *      message="Bitte geben Sie einen Betreff an",
     *      groups={"Default"}
     * )
     * @Assert\Regex(
     *      pattern="/^(?=(?:.*?[a-zA-Z]){2})[a-zA-Z'\s-]{2,100}$/",
     *      message="Der Betreff entspricht nicht den Vorgaben",
     *      groups={"Default"}
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     * @Assert\NotBlank(
     *      message="Bitte geben Sie eine Dauer an",
     *      groups={"Default"}
     * )
     * @Assert\Range(
     *      min = 5,
     *      max = 180,
     *      minMessage = "Slot muss mind. {{ limit }} Minuten gehen",
     *      maxMessage = "Slot darf max. {{ limit }} Minuten gehen"
     * )
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime(
     *      format="d.m.Y",
     *      message="Europäisches Datum notwendig (d.m.Y)",
     *      groups={"Default"}
     * )
     * @Serializer\Expose
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=10000)
     * @Serializer\Expose
     * @Assert\Range(
     *      max = 10000,
     *      maxMessage = "Kommentar darf max. {{ limit }} Zeichen haben"
     * )
     */
    private $comment;

    /**
     * @ORM\Column(type="string")
     * @Serializer\Expose
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Meeting", inversedBy="slots")
     * many slots belong to one meeting
     */
    private $meeting;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="slots")
     * many slots belong to one student
     */
    private $student;


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getMeeting()
    {
        return $this->meeting;
    }

    public function setMeeting($meeting)
    {
        $this->meeting = $meeting;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent($student)
    {
        $this->student = $student;
    }
}
