<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function updateEvent(Event $request): self
    {
        if ($request->name) {
            $this->name = $request->name;
        }

        if ($request->date) {
            $this->date = $request->date;
        }

        if ($request->description) {
            $this->description = $request->description;
        }

        return $this;
    }

    function setData(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'date') {
                $this->$key = (\DateTime::createFromFormat('Y-m-d', $value));
            } else {
                $this->$key = $value;
            }
        }
    }
}
