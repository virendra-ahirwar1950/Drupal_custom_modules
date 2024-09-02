<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

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
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => 'Name',
            '#required' => TRUE,
        ];

        $form['email'] = [
            '#type' => 'email',
            '#title' => 'Email',
            '#required' => TRUE,
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
        $connection = Database::getConnection();
        $connection->insert('custom_form')
            ->fields([
                'name' => $form_state->getValue('name'),
                'email' => $form_state->getValue('email'),
            ])
            ->execute();
       
    }

    public function ajaxSubmitCallback(array &$form, FormStateInterface $form_state)
    {
        $response = new \Drupal\Core\Ajax\AjaxResponse();

        if ($form_state->getErrors()) {
            $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#form-wrapper', $form));
        } else {

            $confirmation_message = '<div class="confirmation-popup"><h3 class="submit-text">Your Form is submitted successfully!</h3></div>';
            $response->addCommand(new \Drupal\Core\Ajax\OpenDialogCommand('#confirmation-dialog', 'Confirmation', $confirmation_message, ['width' => '400', 'height' => '300']));
            $response->addCommand(new \Drupal\Core\Ajax\InvokeCommand('input[name="name"]', 'val', ['']));
            $response->addCommand(new \Drupal\Core\Ajax\InvokeCommand('input[name="email"]', 'val', ['']));
        }

        return $response;
    }
}
