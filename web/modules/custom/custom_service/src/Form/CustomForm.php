<?php

namespace Drupal\custom_service\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomForm extends FormBase
{
    protected $loaddata;

    /**
     * {@inheritdoc}
     */

     public function getFormId()
    {
        return 'custom_form';
    }

    public function __construct()
    {
        $this->loaddata = \Drupal::service('custom_service.dbinsert');
    }

    /**
     * {@inheritdoc}
     */

     public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => t('name'),
            '#required' => TRUE,
        ];

        $form['email'] = [
            '#type' => 'email',
            '#title' => t('Email ID'),
            '#required' => TRUE,
        ];
        
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#button_type' => 'primary',
        ];
        return $form;
    }
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $query = $this->loaddata->setData($form_state);
        \Drupal::messenger()->addMessage(t('Record has been saved'), 'status');
    }

}