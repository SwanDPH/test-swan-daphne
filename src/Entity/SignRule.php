<?php

namespace App\Entity;

use App\Repository\SignRuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignRuleRepository::class)]
class SignRule extends AbstractRule
{
    #[ORM\ManyToOne(inversedBy: 'signRules')]
    private ?SignConfig $signConfig = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $optional = null;

    public function getSignConfig(): ?SignConfig
    {
        return $this->signConfig;
    }

    public function setSignConfig(?SignConfig $signConfig): static
    {
        $this->signConfig = $signConfig;

        return $this;
    }

    public function isOptional(): ?bool
    {
        return $this->optional;
    }

    public function setOptional(bool $optional): static
    {
        $this->optional = $optional;

        return $this;
    }
}
