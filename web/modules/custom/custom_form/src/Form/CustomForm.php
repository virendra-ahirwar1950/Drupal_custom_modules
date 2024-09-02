<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;

class CustomForm extends FormBase
{
    public function getFormId()
    {
        return 'custom_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
        $form['#attached']['library'][] = 'custom_form/custom_form_styles';

        $form['title'] = [
            '#type' => 'textfield',
            '#title' => 'Title',
            '#required' => TRUE,
        ];

        $form['body'] = [
            '#type' => 'textfield',
            '#title' => 'Body',
            '#required' => TRUE,
        ];

        $form['image'] = [
            '#type' => 'file',
            '#title' => 'Upload Image',
        ];

        $form['actions'] = [
            '#type' => 'submit',
            '#value' => 'Submit',
            '#ajax' => [
                'callback' => '::ajaxSubmitCallback',
                'wrapper' => 'form-wrapper',
                'event' => 'click',
            ],
        ];

        $form['#prefix'] = '<div id="form-wrapper">';
        $form['#suffix'] = '</div>';

        return $form;
    }

    /**
     * {@inheritdoc}
     */

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $node = Node::create([
            'type' => 'page',
            'title' => $form_state->getValues()['title'],
            'body' => $form_state->getValues()['body'],
        ]);
        $node->save();
        $node = Node::create([
            'type' => 'article',
            'title' => $form_state->getValues()['title'],
            'field_image' => $form_state->getValues()['image'],
            'body' => $form_state->getValues()['body'],
        ]);
        $node->save();
    }

    public function ajaxSubmitCallback(array &$form, FormStateInterface $form_state)
    {
        $response = new \Drupal\Core\Ajax\AjaxResponse();

        if ($form_state->getErrors()) {
            $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#form-wrapper', $form));
        } else {

            $confirmation_message = '<div class="confirmation-popup"><h3 class="submit-text">Node is created successfully!</h3></div>';
            $response->addCommand(new \Drupal\Core\Ajax\OpenDialogCommand('#confirmation-dialog', 'Confirmation', $confirmation_message, ['width' => '400', 'height' => '300']));
            $response->addCommand(new \Drupal\Core\Ajax\InvokeCommand('input[name="name"]', 'val', ['']));
            $response->addCommand(new \Drupal\Core\Ajax\InvokeCommand('input[name="email"]', 'val', ['']));
        }

        return $response;
    }
}
