<?php
namespace Jmondi\Gut\DomainModel\Entity\Type;

class TypeDetail implements \JsonSerializable
{
    /** @var AbstractType */
    private $type;
    /** @var string */
    private $slug;
    /** @var string */
    private $title;
    /** @var null|string */
    private $description;

    public function __construct(
        AbstractType $type,
        string $slug,
        string $title,
        ?string $description = null
    ) {
        $this->type = $type;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
    }

    public function jsonSerialize(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    public function getType(): AbstractType
    {
        return $this->type;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
