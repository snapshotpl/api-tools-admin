<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-admin for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-admin/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-admin/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Admin\Model;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\ApiTools\Rest\Exception\CreationException;

class ContentNegotiationResource extends AbstractResourceListener
{
    /**
     * @var DbAdapterModel
     */
    protected $model;

    public function __construct(ContentNegotiationModel $model)
    {
        $this->model = $model;
    }

    public function fetch($id)
    {
        $entity = $this->model->fetch($id);
        if (!$entity) {
            return new ApiProblem(404, 'Adapter not found');
        }
        return $entity;
    }

    public function fetchAll($params = array())
    {
        return $this->model->fetchAll();
    }

    public function create($data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }

        if (!isset($data['content_name'])) {
            throw new CreationException('Missing content_name', 422);
        }

        $name = $data['content_name'];
        unset($data['content_name']);

        return $this->model->create($name, $data);
    }

    public function patch($id, $data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }

        if (!is_array($data)) {
            return new ApiProblem(400, 'Invalid data provided for update');
        }

        if (empty($data)) {
            return new ApiProblem(400, 'No data provided for update');
        }

        return $this->model->update($id, $data);
    }

    public function delete($id)
    {
        $this->model->remove($id);
        return true;
    }
}