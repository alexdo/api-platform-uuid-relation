<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
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
 * @ApiFilter(SearchFilter::class, properties={"greeters": "exact"})
 */
class Greeting
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
    public $name = '';

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Greeter", inversedBy="greetings", cascade={"persist"}, orphanRemoval=true, fetch="EXTRA_LAZY")
     * @ORM\JoinTable("greeting_greeters")
     * @Assert\Valid()
     *
     * @var Collection<Greeter>
     */
    private $greeters;

    /**
     * Greeting constructor.
     */
    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->greeters = new ArrayCollection();
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
     * @return Greeting
     */
    public function setUuid(UuidInterface $uuid): Greeting
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Greeting
     */
    public function setName(string $name): Greeting
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getGreeters(): Collection
    {
        return $this->greeters;
    }

    /**
     * @param Collection $greeters
     * @return Greeting
     */
    public function setGreeters(Collection $greeters): Greeting
    {
        $this->greeters = $greeters;
        return $this;
    }

    public function addGreeter(Greeter $greeter): self
    {
        if (!$this->greeters->contains($greeter)) {
            $this->greeters[] = $greeter;
            $greeter->addGreeting($this);
        }

        return $this;
    }


}
