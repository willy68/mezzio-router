<?php

/**
 * @see       https://github.com/mezzio/mezzio-router for the canonical source repository
 * @copyright https://github.com/mezzio/mezzio-router/blob/master/COPYRIGHT.md
 * @license   https://github.com/mezzio/mezzio-router/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Mezzio\Router\Middleware;

use Mezzio\Router\Exception\MissingDependencyException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Create and return an ImplicitOptionsMiddleware instance.
 *
 * This factory depends on one other service:
 *
 * - Psr\Http\Message\ResponseInterface, which should resolve to a callable
 *   that will produce an empty Psr\Http\Message\ResponseInterface instance.
 */
class ImplicitOptionsMiddlewareFactory
{
    /**
     * @throws MissingDependencyException If the Psr\Http\Message\ResponseInterface
     *     service is missing.
     */
    public function __invoke(ContainerInterface $container): ImplicitOptionsMiddleware
    {
        if (!$container->has(ResponseInterface::class)) {
            throw MissingDependencyException::dependencyForService(
                ResponseInterface::class,
                ImplicitOptionsMiddleware::class
            );
        }

        return new ImplicitOptionsMiddleware(
            $container->get(ResponseInterface::class)
        );
    }
}
