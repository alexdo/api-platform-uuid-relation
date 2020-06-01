<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * This is a dummy entity. Remove it!
 *
 * @ApiResource
 * @ORM\Entity
 */
class Greeter
{
    /**
     * @var int
     * @ApiProperty(identifier=false)
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var UuidInterface
     * @ApiProperty(identifier=true)
     * @ORM\Column(type="uuid", unique=true)
     */
    private $uuid;

    /**
     * @var string A nice person
     *
     * @ORM\Column
     * @Assert\NotBlank
     */
    public $greeterName = '';

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Greeting", mappedBy="greeters", fetch="EXTRA_LAZY")
     * @Assert\Valid()
     *
     * @var Collection<Greeting>
     */
    private $greetings;
    /**
     * Greeters constructor.
     */
    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->greetings = new ArrayCollection();
    }


    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @param UuidInterface $uuid
     * @return Greeter
     */
    public function setUuid(UuidInterface $uuid): Greeter
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getGreeterName(): string
    {
        return $this->greeterName;
    }

    /**
     * @param string $greeterName
     * @return Greeter
     */
    public function setGreeterName(string $greeterName): Greeter
    {
        $this->greeterName = $greeterName;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getGreetings(): Collection
    {
        return $this->greetings;
    }

    /**
     * @param Collection $greetings
     * @return Greeter
     */
    public function setGreetings(Collection $greetings): Greeter
    {
        $this->greetings = $greetings;
        return $this;
    }

    public function addGreeting(Greeting $greeting): self
    {
        if (!$this->greetings->contains($greeting)) {
            $this->greetings[] = $greeting;
            $greeting->addGreeter($this);
        }

        return $this;
    }

}
