<?php

namespace Gesdinet\JWTRefreshTokenBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * CustomUserProviderCompilerPass.
 *
 * @deprecated no replacement
 */
final class CustomUserProviderCompilerPass implements CompilerPassInterface
{
    /**
     * @var bool
     */
    private $internalUse;

    /**
     * @param bool $internalUse Flag indicating the pass was created by an internal bundle call (used to suppress runtime deprecations)
     */
    public function __construct(bool $internalUse = false)
    {
        $this->internalUse = $internalUse;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $this->internalUse) {
            trigger_deprecation('gesdinet/jwt-refresh-token-bundle', '0.13', 'The "%s" class is deprecated.', self::class);
        }

        $customUserProvider = $container->getParameter('gesdinet_jwt_refresh_token.user_provider');
        if (!$customUserProvider) {
            return;
        }
        if (!$container->hasDefinition('gesdinet.jwtrefreshtoken.user_provider')) {
            return;
        }

        $definition = $container->getDefinition('gesdinet.jwtrefreshtoken.user_provider');

        $definition->addMethodCall(
            'setCustomUserProvider',
            [new Reference($customUserProvider, ContainerInterface::NULL_ON_INVALID_REFERENCE, false)]
        );
    }
}
