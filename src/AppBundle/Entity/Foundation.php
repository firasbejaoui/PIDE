<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Foundation
 *
 * @ORM\Table(name="foundation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FoundationRepository")
 * @Vich\Uploadable
 */
class Foundation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="noun", type="string", length=255)
     */
    private $noun;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FCategory")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="id")
     */

    private $categorie;

    /**
     * @Vich\UploadableField(mapping="logo_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    // ...

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set noun
     *
     * @param string $noun
     *
     * @return Foundation
     */
    public function setNoun($noun)
    {
        $this->noun = $noun;

        return $this;
    }

    /**
     * Get noun
     *
     * @return string
     */
    public function getNoun()
    {
        return $this->noun;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Foundation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    public function __toString()
    {
        return $this->noun;
    }


}

