<?php

namespace Drupal\custom_service\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * provide a 'Custom' block
 * 
 * @Block(
 *  id = "custom_service",
 *  admin_label = @Translation("Services"),
 *  category = @Translation("Custom Block example")
 * )
 */
class CustomBlock extends BlockBase
{
    /**
     * {@inheritDoc}
     */

    public function build()
    {

        $data = \Drupal::service('custom_service.dbinsert')->getData();
        return [
            '#theme' => 'custom_service',
            '#data' => $data,
        ];
    }
}