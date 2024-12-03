<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TalkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Survos\CoreBundle\Entity\RouteParametersInterface;
use Survos\CoreBundle\Entity\RouteParametersTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TalkRepository::class)]
#[ORM\UniqueConstraint(fields: ['code'])]
#[UniqueEntity(['code'])]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['talk.read', 'rp', 'talk.details']]),
        new GetCollection(name: self::MEILI_ROUTE)],
    normalizationContext: ['groups' => ['talk.read', 'rp']]
)]
class Talk implements RouteParametersInterface, \Stringable
{
    const MEILI_ROUTE='meili_talk';
    use RouteParametersTrait;

    public const UNIQUE_IDENTIFIERS = ['talkId' => 'id'];
    #[ORM\Column]
    #[ORM\GeneratedValue()]
    #[Groups(['talk.read'])]
    #[ORM\Id]
    private ?int $id = null;

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    #[ORM\Column(length: 255)]
    #[Groups(['talk.read'])]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'talks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: Reaction::class, mappedBy: 'talk', orphanRemoval: true)]
    #[ORM\OrderBy(["createdAt" => "DESC"])]
    #[Groups(['talk.details'])]
    private Collection $reactions;

    #[ORM\Column(length: 255)]
    #[Groups(['talk.read'])]
    private ?string $code = null;

    #[ORM\Column( nullable: true, options: ['jsonb' => true])]
    private ?array $data = null;

    public function __construct()
    {
        $this->reactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Reaction>
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reaction $reaction): static
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions->add($reaction);
            $reaction->setTalk($this);
        }

        return $this;
    }

    public function removeReaction(Reaction $reaction): static
    {
        if ($this->reactions->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getTalk() === $this) {
                $reaction->setTalk(null);
            }
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getUniqueIdentifiers(): array
    {
        return ['talkId' => $this->getCode()];
    }

    public function __toString()
    {
        return $this->getCode();
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): static
    {
        $this->data = $data;

        return $this;
    }


}
