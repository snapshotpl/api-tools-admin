<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-admin for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-admin/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-admin/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Admin\Controller;

use Laminas\ApiTools\Admin\Exception;
use Laminas\ApiTools\Admin\Model\VersioningModelFactory;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\View\ApiProblemModel;
use Laminas\Mvc\Controller\AbstractActionController;

class VersioningController extends AbstractActionController
{
    protected $modelFactory;

    public function __construct(VersioningModelFactory $modelFactory)
    {
        $this->modelFactory = $modelFactory;
    }

    public function versioningAction()
    {
        $request = $this->getRequest();

        $module = $this->bodyParam('module', false);
        if (!$module) {
            return new ApiProblemModel(
                new ApiProblem(422, 'Module parameter not provided', 'https://tools.ietf.org/html/rfc4918', 'Unprocessable Entity')
            );
        }

        $model = $this->modelFactory->factory($module);

        $version = $this->bodyParam('version', false);
        if (!$version) {
            try {
                $versions = $model->getModuleVersions($module);
            } catch (Exception\ExceptionInterface $ex) {
                return new ApiProblemModel(new ApiProblem(404, 'Module not found'));
            }
            if (!$versions) {
                return new ApiProblemModel(new ApiProblem(500, 'Module cannot be versioned'));
            }
            sort($versions);
            $version = array_pop($versions);
            $version += 1;
        }


        try {
            $result = $model->createVersion($module, $version);
        } catch (Exception\InvalidArgumentException $ex) {
            return new ApiProblemModel(
                new ApiProblem(422, 'Invalid module and/or version', 'https://tools.ietf.org/html/rfc4918', 'Unprocessable Entity')
            );
        }

        return array(
            'success' => true,
            'version' => $version,
        );
    }
}