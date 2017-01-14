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
     *      pattern="/^(?=(?:.*?[\u00C0-\u017Fa-zA-Z0-9]){2})[0-9\u00C0-\u017Fa-zA-Z'\s-]{2,100}$/",
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
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime(
     *      format="dd.MM.y HH:mm",
     *      message="Europäisches Datum notwendig (dd.MM.y HH:mm)",
     *      groups={"Default"}
     * )
     * @Serializer\Expose
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     * @Serializer\Expose
     * @Assert\Length(
     *      max = 10000,
     *      maxMessage = "Kommentar darf max. {{ limit }} Zeichen haben"
     * )
     */
    private $comment;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Expose
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Meeting", inversedBy="slots")
     * @Serializer\Expose
     * many slots belong to one meeting
     */
    private $meeting;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="slots")
     * @Serializer\Expose
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
