<?php

/**
 * @see       https://github.com/mezzio/mezzio-router for the canonical source repository
 * @copyright https://github.com/mezzio/mezzio-router/blob/master/COPYRIGHT.md
 * @license   https://github.com/mezzio/mezzio-router/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Mezzio\Router\Middleware;

use Mezzio\Router\Exception\MissingDependencyException;
use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;

/**
 * Create and return a RouteMiddleware instance.
 *
 * This factory depends on one other service:
 *
 * - Mezzio\Router\RouterInterface, which should resolve to
 *   a class implementing that interface.
 */
class RouteMiddlewareFactory
{
    /** @var string */
    private $routerServiceName;

    /**
     * Allow serialization
     */
    public static function __set_state(array $data): self
    {
        return new self(
            $data['routerServiceName'] ?? RouterInterface::class
        );
    }

    /**
     * Provide the name of the router service to use when creating the route
     * middleware.
     */
    public function __construct(string $routerServiceName = RouterInterface::class)
    {
        $this->routerServiceName = $routerServiceName;
    }

    /**
     * @throws MissingDependencyException If the RouterInterface service is
     *     missing.
     */
    public function __invoke(ContainerInterface $container): RouteMiddleware
    {
        if (!$container->has($this->routerServiceName)) {
            throw MissingDependencyException::dependencyForService(
                $this->routerServiceName,
                RouteMiddleware::class
            );
        }

        return new RouteMiddleware($container->get($this->routerServiceName));
    }
}
