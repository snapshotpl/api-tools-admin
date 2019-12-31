<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-admin for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-admin/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-admin/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Admin\InputFilter;

use Laminas\InputFilter\InputFilter;

class DbAdapterInputFilter extends InputFilter
{
    public function init()
    {
        $this->add(array(
            'name' => 'adapter_name',
            'required' => true,
            'allow_empty' => false,
            'error_message' => 'Please provide a unique, non-empty name for your database connection',
        ));
        $this->add(array(
            'name' => 'database',
            'required' => true,
            'allow_empty' => false,
            'error_message' => 'Please provide the database name; for SQLite, this will be a filesystem path',
        ));
        $this->add(array(
            'name' => 'driver',
            'error_message' => 'Please provide a Database Adapter driver name available to Laminas',
        ));
        $this->add(array(
            'name' => 'username',
            'required' => false,
            'allow_empty' => true,
        ));
        $this->add(array(
            'name' => 'password',
            'required' => false,
            'allow_empty' => true,
        ));
        $this->add(array(
            'name' => 'hostname',
            'required' => false,
            'allow_empty' => true,
        ));
        $this->add(array(
            'name' => 'port',
            'required' => false,
            'allow_empty' => true,
            'validators' => array(
                array('name' => 'Digits')
            ),
            'error_message' => 'Please provide a valid port for accessing the database; must be an integer',
        ));
        $this->add(array(
            'name' => 'charset',
            'required' => false,
            'allow_empty' => true,
        ));
    }
}