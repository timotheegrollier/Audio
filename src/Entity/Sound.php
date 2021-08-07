<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\SoundRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SoundRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Sound
{
    use Timestampable;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseignez un titre !")
     * @Assert\Length(min=3)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=3)
     *
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}