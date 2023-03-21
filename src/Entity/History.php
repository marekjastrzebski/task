<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\ExchangeController;
use App\Repository\HistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/exchange/values",
            controller: ExchangeController::class,
            denormalizationContext: ['groups' => ['write']],
            collectDenormalizationErrors: true,
            validationContext: [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true],
            validate: true
        ),
        new GetCollection(
            uriTemplate: "/exchange/values"
        )
    ]
)]
#[ApiFilter(DateFilter::class, properties: ['updateDate', 'createDate'])]
#[ApiFilter(OrderFilter::class, properties: ['firstIn', 'secondIn', 'createDate', 'updateDate'], arguments: ['orderParameterName' => 'order'])]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[SerializedName('first')]
    private ?int $firstIn = null;

    #[ORM\Column]
    #[Groups(['write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[SerializedName('second')]
    private ?int $secondIn = null;

    #[ORM\Column(nullable: true)]
    private ?int $firstOut = null;

    #[ORM\Column(nullable: true)]
    private ?int $secondOut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateDate = null;

    public function __construct()
    {
        $this->setCreateDate(new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstIn(): ?int
    {
        return $this->firstIn;
    }

    public function setFirstIn($firstIn): self
    {
        $this->firstIn = $firstIn;

        return $this;
    }

    public function getSecondIn(): ?int
    {
        return $this->secondIn;
    }

    public function setSecondIn($secondIn): self
    {
        $this->secondIn = $secondIn;

        return $this;
    }

    public function getFirstOut(): ?int
    {
        return $this->firstOut;
    }

    public function setFirstOut($firstOut): self
    {
        $this->firstOut = $firstOut;

        return $this;
    }

    public function getSecondOut(): ?int
    {
        return $this->secondOut;
    }

    public function setSecondOut($secondOut): self
    {
        $this->secondOut = $secondOut;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }
}
