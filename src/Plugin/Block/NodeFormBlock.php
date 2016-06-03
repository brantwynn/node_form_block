<?php

/**
 * @file
 * Contains \Drupal\node_form_block\Plugin\Block\NodeFormBlock.
 */

namespace Drupal\node_form_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Entity\EntityTypeManagerInterface;
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
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, FormBuilder $form_builder, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('form_builder'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $block = [];
    $node = $this->getContextValue('node');
    $block = [$this->entityTypeManager->getFormObject('node', 'default')->setEntity($node)];
    return $block;
  }

}
