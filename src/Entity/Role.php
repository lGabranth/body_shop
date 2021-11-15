<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $canRead;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $canWrite;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $canDelete;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $canUpdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCanRead(): bool
    {
        return $this->canRead;
    }

    public function setCanRead(bool $canRead): self
    {
        $this->canRead = $canRead;

        return $this;
    }

    public function getCanWrite(): bool
    {
        return $this->canWrite;
    }

    public function setCanWrite(bool $canWrite): self
    {
        $this->canWrite = $canWrite;

        return $this;
    }

    public function getCanDelete(): bool
    {
        return $this->canDelete;
    }

    public function setCanDelete(bool $canDelete): self
    {
        $this->canDelete = $canDelete;

        return $this;
    }

    public function getCanUpdate(): bool
    {
        return $this->canUpdate;
    }

    public function setCanUpdate(bool $canUpdate): self
    {
        $this->canUpdate = $canUpdate;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
		
		#[ArrayShape(['id' => "", 'name' => "string", 'canRead' => "bool", 'canWrite' => "bool", 'canUpdate' => "bool", 'canDelete' => "bool"])] public function toArray() : array {
			return [
				'id' => $this->id,
				'name' => $this->name,
				'canRead' => $this->canRead,
				'canWrite' => $this->canWrite,
				'canUpdate' => $this->canUpdate,
				'canDelete' => $this->canDelete,
			];
		}
}
