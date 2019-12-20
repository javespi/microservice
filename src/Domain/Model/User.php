<?php

declare(strict_types=1);

namespace Domain\Model;

class User
{
    private string $id;

    private string $name;

    public array $attr = [];

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
