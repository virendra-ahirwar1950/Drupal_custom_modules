<?php

namespace Drupal\custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Sample: Simple Block' block.
 *
 * @Block(
 *   id = "sample_simple_block",
 *   admin_label = @Translation("Block: My Block")
 * )
 */
class TheCustomBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        return [
            '#theme' => 'custom_block',
            '#custom_data' => ['age' => '31', 'DOB' => '2 May 2000'],
            '#custom_string' => 'Hello Block!',
        ];
    }

}