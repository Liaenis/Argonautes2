<?php

namespace App\Service;

use App\Entity\Argonaute;
use App\Repository\ServiceArgonauteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ServiceArgonauteRepository::class)
 */
class ServiceArgonaute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Argonaute::class, mappedBy="serviceArgonaute")
     */
    private $ListeArgonautes;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $paraEntityManager)
    {
        $this->ListeArgonautes = new ArrayCollection();
        $this->entityManager = $paraEntityManager;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Argonaute[]
     */
    public function getListeArgonautes(): Collection
    {
        return $this->ListeArgonautes;
    }

    public function addListeArgonaute(Argonaute $listeArgonaute): self
    {
        if (!$this->ListeArgonautes->contains($listeArgonaute)) {
            $this->ListeArgonautes[] = $listeArgonaute;
            $listeArgonaute->setServiceArgonaute($this);
        }
        return $this;
    }

    public function removeListeArgonaute(Argonaute $listeArgonaute): self
    {
        if ($this->ListeArgonautes->removeElement($listeArgonaute)) {
            // set the owning side to null (unless already changed)
            if ($listeArgonaute->getServiceArgonaute() === $this) {
                $listeArgonaute->setServiceArgonaute(null);
            }
        }
        return $this;
    }

    public function addArgonaute( Argonaute $paraArgonaute){
        $this->ListeArgonautes->add($paraArgonaute);
        $this->entityManager->persist($paraArgonaute);
        $this->entityManager->flush();
    } 

    public function removeArgonaute(Argonaute $paraArgonaute){
        $this->ListeArgonautes->removeElement($paraArgonaute);
        $this->entityManager->remove($paraArgonaute);
        $this->entityManager->flush();
    }

}