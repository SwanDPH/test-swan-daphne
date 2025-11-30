<?php

namespace App\Entity;

use App\Repository\SignConfigRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Config\RuleConfigInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: SignConfigRepository::class)]
class SignConfig implements RuleConfigInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, SignRule>
     */
    #[ORM\OneToMany(targetEntity: SignRule::class, mappedBy: 'signConfig', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $signRules;

    public function __construct()
    {
        $this->signRules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getRules(): Collection
    {
        return $this->signRules;
    }

    /**
     * @return Collection<int, SignRule>
     */
    public function getSignRules(): Collection
    {
        return $this->signRules;
    }

    public function addRule(SignRule $signRule): static
    {
        if (!$this->signRules->contains($signRule)) {
            $this->signRules->add($signRule);
            $signRule->setSignConfig($this);
        }

        return $this;
    }

    public function addSignRule(SignRule $signRule): static
    {
        if (!$this->signRules->contains($signRule)) {
            $this->signRules->add($signRule);
            $signRule->setSignConfig($this);
        }

        return $this;
    }

    public function removeRule(SignRule $signRule): static
    {
        if ($this->signRules->removeElement($signRule)) {
            // set the owning side to null (unless already changed)
            if ($signRule->getSignConfig() === $this) {
                $signRule->setSignConfig(null);
            }
        }

        return $this;
    }

    public function removeSignRule(SignRule $signRule): static
    {
        if ($this->signRules->removeElement($signRule)) {
            // set the owning side to null (unless already changed)
            if ($signRule->getSignConfig() === $this) {
                $signRule->setSignConfig(null);
            }
        }

        return $this;
    }
}
