<?php

namespace Drupal\custom_service\services;

use Drupal\Core\Database\Connection;

class Db_insert
{
    public $database;
    public function __construct(Connection $database)
    {
        $this->database = $database;

    }

    public function setData($form_state)
    {
        $this->database->insert('customform')
            ->fields(
                array(
                    'mail' => $form_state->getValue('email'),
                    'name' => $form_state->getValue('name'),
                )
            )
            ->execute();
    }

    public function getData()
    {
        $query = $this->database->select('customform');
        $query->fields('customform');
        $result = $query->execute()->fetchAll();
        return $result;
    }
}
