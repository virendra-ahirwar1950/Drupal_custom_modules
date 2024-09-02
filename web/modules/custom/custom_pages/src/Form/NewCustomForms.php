<?php
namespace Drupal\custom_pages\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class NewCustomForms extends FormBase
{

    public function getFormId()
    {
        return 'custom_new_form';
    }
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['search'] = [
            '#title' => 'search',
            '#type' => 'search',
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Submit',
        ];
        return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $query = \Drupal::entityQuery('node')
            ->condition('status', 1)
            ->accessCheck(true)
            ->sort('nid', 'ASC');
        $nids = $query->execute();
        foreach ($nids as $node) {
            $node = Node::load($node);
            $id = $node->id();
            $title = $node->getTitle();

            if ($form_state->getValues()['search'] == $title) {
                $rows[] = [
                    'id' => $id,
                    'title' => $title,
                ];
            }
        }
        return [
            'table' => [
                '#type' => 'table',
                '#rows' => $rows,
                '#empty' => $this->t('No content available.'),
            ],
        ];

    }
}