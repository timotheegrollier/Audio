<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SoundRepository;
use App\Entity\Traits\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SoundRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="sound_cover", fileNameProperty="imageName")
     * @Assert\Image(maxSize="5M", maxSizeMessage="Votre cover ne doit pas dépasser les {{ limit }} Mo")
     * @Assert\Image(mimeTypes={"image/jpeg","image/png","image/gif"},mimeTypesMessage="Votre cover n'est pas une image valide(jpg, png, gif)")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $soundName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="sounds", fileNameProperty="soundName")
     * 
     * 
     * @var File|null
     */
    private $soundFile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $download;


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

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    // UPLOAD IMAGE (GETTER / SETTER)

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTimeImmutable('now');
        }
    }



    public function getImageFile()
    {
        return $this->imageFile;
    }


    // UPLOAD SON (GETTER / SETTER)

    /**  
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $soundFile
     */
    public function setSoundFile(?File $soundFile = null): void
    {
        $this->soundFile = $soundFile;

        if (null !== $soundFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    public function getSoundFile(): ?File
    {
        return $this->soundFile;
    }



    public function getSoundName(): ?string
    {
        return $this->soundName;
    }

    public function setSoundName(?string $soundName): self
    {
        $this->soundName = $soundName;

        return $this;
    }

    public function getDownload(): ?bool
    {
        return $this->download;
    }

    public function setDownload(bool $download): self
    {
        $this->download = $download;

        return $this;
    }
}