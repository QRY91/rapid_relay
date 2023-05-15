<?php

namespace App\Entity;

use App\Repository\RelayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RelayRepository::class)]
class Relay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Discipline::class)]
    #[ORM\JoinTable(name: 'relay_discipline')]
    #[Assert\Count(
        min: 2,
        max: 4,
        minMessage: 'You must add at least two disciplines',
        maxMessage: 'You cannot add more than {{ limit }} disciplines',
    )]
    private Collection $disciplines;

    public function __construct()
    {
        $this->disciplines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Discipline>
     */
    public function getDisciplines(): Collection
    {
        return $this->disciplines;
    }

    public function addDiscipline(Discipline ...$discipline): void
    {
        foreach ($discipline as $discipline) {
            if (!$this->disciplines->contains($discipline)) {
                $this->disciplines->add($discipline);
            }
        }
    }

    public function removeDiscipline(Discipline $discipline): self
    {
        $this->disciplines->removeElement($discipline);

        return $this;
    }
}
