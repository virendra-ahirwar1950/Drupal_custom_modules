<?php
namespace Drupal\custom_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class CustomSearch extends FormBase
{

    public function getFormId()
    {
        return 'custom_search_form';
    }
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['full_name'] = [
            '#title' => 'Full Name',
            '#type' => 'textfield',
            '#required' => true,
            '#default_value' => 'Virendra Choudhary',
        ];
        $form['email'] = [
            '#title' => 'Email',
            '#type' => 'email',
            '#attributes' => [
                'placeholder' => 'Enter your Email',
            ],
            '#required' => true,
        ];
        $form['mobile'] = [
            '#title' => 'Mobile No.',
            '#type' => 'tel',
            '#required' => true,
            '#attributes' => [
                'placeholder' => 'Mobile Number',
            ],
        ];
        $form['image'] = [
            '#type' => 'file',
            '#title' => 'Upload Image',
        ];
        $form['address'] = [
            '#title' => 'Address',
            '#type' => 'textarea',
            '#attributes' => [
                'placeholder' => 'Enter Your permanent address ',
            ],
            '#required' => true,
        ];
        $form['city'] = [
            '#type' => 'select',
            '#title' => 'City',
            '#options' => [
                '' => '-select-',
                'india' => 'India',
                'america' => 'America',
                'france' => 'France',
                'russia' => 'Russia',
            ]
        ];
        $form['gender'] = [
            '#type' => 'radios',
            '#title' => 'Gender',
            '#options' => [
                'Male' => 'Male',
                'Female' => 'Female'
            ],
            '#default_value' => 'Male',

        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Submit',
        ];
        return $form;
    }
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if (strlen($form_state->getValue('mobile')) > 11) {
            $form_state->setErrorByName('mobile', $this->t('The phone number is too short. Please enter a full phone number.'));
        }
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $node = Node::create([
            'type' => 'article',
            'title' => $form_state->getValues()['full_name'],
            'field_image'=> $form_state->getValues()['image'],
            'body' => $form_state->getValues()['address'],
        ]);
        $node->save();
    }
}