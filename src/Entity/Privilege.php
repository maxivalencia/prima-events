<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrivilegeRepository")
 */
class Privilege
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $privilege;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrivilege(): ?string
    {
        return $this->privilege;
    }

    public function setPrivilege(string $privilege): self
    {
        $this->privilege = $privilege;

        return $this;
    }
}
