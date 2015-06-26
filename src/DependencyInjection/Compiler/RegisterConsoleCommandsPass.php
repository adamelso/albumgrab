<?php

namespace Albumgrab\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Automatically registers console commands.
 */
class RegisterConsoleCommandsPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $commandServices = $container->findTaggedServiceIds('console.command');

        foreach ($commandServices as $id => $tags) {
            $definition = $container->getDefinition($id);

            if (!$definition->isPublic()) {
                throw new \InvalidArgumentException(sprintf('The service "%s" tagged "console.command" must be public.', $id));
            }

            if ($definition->isAbstract()) {
                throw new \InvalidArgumentException(sprintf('The service "%s" tagged "console.command" must not be abstract.', $id));
            }

            $class = $container->getParameterBag()->resolveValue($definition->getClass());
            $r = new \ReflectionClass($class);
            if (!$r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command')) {
                throw new \InvalidArgumentException(sprintf('The service "%s" tagged "console.command" must be a subclass of "Symfony\\Component\\Console\\Command\\Command".', $id));
            }
            $container->setAlias('console.command.'.strtolower(str_replace('\\', '_', $class)), $id);
        }

        $container->setParameter('console.command.ids', array_keys($commandServices));
    }
}
