<?php

declare(strict_types=1);

namespace Mezzio\Router;

interface RouteInterface
{
    public function getPath(): string;

    public function getName(): string;

    public function getAllowedMethods(): ?array;

    public function allowsAnyMethod(): bool;

    public function getCallback();
}
