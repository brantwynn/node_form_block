<?php

namespace Drupal\node_form_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityFormBuilder;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'NodeFormBlock' block.
 *
 * @Block(
 *  id = "node_form_block",
 *  admin_label = @Translation("Edit node"),
 *  context = {
 *    "node" = @ContextDefinition("entity:node", label = @Translation("Node"))
 *  },
 *  category = @Translation("Forms")
 * )
 *
 */
class NodeFormBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity form builder.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilder
   */
  protected $entityFormBuilder;


  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityFormBuilder $entity_form_builder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityFormBuilder = $entity_form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = $this->getContextValue('node');
    return [$this->entityFormBuilder->getForm($node, 'edit')];
  }

}
