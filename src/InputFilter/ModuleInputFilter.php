<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-admin for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-admin/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-admin/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Admin\InputFilter;

use Laminas\InputFilter\InputFilter;

class ModuleInputFilter extends InputFilter
{
    public function init()
    {
        $this->add(array(
            'name' => 'name',
            'validators' => array(
                array(
                    'name' => 'Laminas\ApiTools\Admin\InputFilter\Validator\ModuleNameValidator',
                ),
            ),
            'error_message' => 'The API name must be a valid PHP namespace',
        ));
    }
}