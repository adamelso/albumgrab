<?php

namespace Albumgrab\DependencyInjection\Compiler;

use Symfony\Component\Console\Command\Command;
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

            $fqcn = $container->getParameterBag()->resolveValue($definition->getClass());
            $r = new \ReflectionClass($fqcn);
            if (!$r->isSubclassOf(Command::class)) {
                throw new \InvalidArgumentException(sprintf('The service "%s" tagged "console.command" must be a subclass of "%s".', $id, Command::class));
            }
            $container->setAlias('console.command.'.strtolower(str_replace('\\', '_', $fqcn)), $id);
        }

        $container->setParameter('console.command.ids', array_keys($commandServices));
    }
}
