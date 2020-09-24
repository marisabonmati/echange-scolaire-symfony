<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="tags")
     */
    private $userTag;

    public function __construct()
    {
        $this->userTag = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUserTag(): Collection
    {
        return $this->userTag;
    }

    public function addUserTag(User $userTag): self
    {
        if (!$this->userTag->contains($userTag)) {
            $this->userTag[] = $userTag;
        }

        return $this;
    }

    public function removeUserTag(User $userTag): self
    {
        if ($this->userTag->contains($userTag)) {
            $this->userTag->removeElement($userTag);
        }

        return $this;
    }
}
