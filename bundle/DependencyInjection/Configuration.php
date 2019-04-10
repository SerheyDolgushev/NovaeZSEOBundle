<?php
/**
 * NovaeZSEOBundle Configuration.
 *
 * @package   Novactive\Bundle\eZSEOBundle
 *
 * @author    Novactive <novaseobundle@novactive.com>
 * @copyright 2015 Novactive
 * @license   https://github.com/Novactive/NovaeZSEOBundle/blob/master/LICENSE MIT Licence
 */

namespace Novactive\Bundle\eZSEOBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SAConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends SAConfiguration
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('nova_ezseo');
        $systemNode  = $this->generateScopeBaseNode($rootNode);
        $systemNode
            ->scalarNode('custom_fallback_service')->defaultValue('~')->end()
            ->scalarNode('google_verification')->defaultValue('~')->end()
            ->scalarNode('google_gatracker')->defaultValue('~')->end()
            ->scalarNode('google_anonymizeIp')->defaultValue('~')->end()
            ->scalarNode('bing_verification')->defaultValue('~')->end()
            ->booleanNode('limit_to_rootlocation')->defaultValue('~')->end()
            ->scalarNode('fieldtype_metas_identifier')->defaultValue('metas')->end()
            ->arrayNode('fieldtype_metas')
                ->isRequired()
                ->prototype('array')
                    ->children()
                        ->scalarNode('label')->isRequired()->end()
                        ->scalarNode('default_pattern')->end()
                        ->scalarNode('icon')->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('default_metas')
                ->isRequired()
                    ->prototype('scalar')
                ->end()
            ->end()
            ->arrayNode('sitemap_excludes')
                ->children()
                    ->arrayNode('locations')
                        ->prototype('variable')->end()
                    ->end()
                    ->arrayNode('subtrees')
                        ->prototype('variable')->end()
                    ->end()
                    ->arrayNode('contentTypeIdentifiers')
                        ->prototype('variable')->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('default_links')
                ->prototype('array')
                    ->children()
                        ->arrayNode('href')->isRequired()
                            ->children()
                                ->integerNode('location_id')->end()
                                ->arrayNode('asset')
                                    ->beforeNormalization()
                                        ->ifString()
                                        ->then(
                                            function ($value) {
                                                return ['path' => $value];
                                            }
                                        )
                                    ->end()
                                    ->children()
                                        ->scalarNode('path')->isRequired()->end()
                                        ->scalarNode('package')->end()
                                    ->end()
                                ->end()
                                ->scalarNode('legacy_uri')->end()
                                ->scalarNode('route')->end()
                            ->end()
                        ->end()
                        ->scalarNode('title')->end()
                        ->scalarNode('type')->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('robots_disallow')
                ->prototype('scalar')
            ->end()
            ->end();

        return $treeBuilder;
    }
}