<?php

namespace Seiffert\ControllerHelperBundle\Helper;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface ControllerHelperInterface
{
    /**
     * @return ObjectManager
     */
    public function getEntityManager();

    /**
     * @param mixed $entity
     */
    public function persist($entity);

    /**
     * @param mixed $entity
     */
    public function flush($entity = null);

    /**
     * @param string $entity
     * @return ObjectRepository
     */
    public function getRepository($entity);

    /**
     * @param string $type
     * @param string $message
     */
    public function addFlashMessage($type, $message);

    /**
     * @param FormTypeInterface $type
     * @param mixed $data
     * @param array $options
     * @return FormInterface
     */
    public function createForm(FormTypeInterface $type, $data = null, array $options = array());

    /**
     * @param string $route
     * @param array $parameters
     * @param string $referenceType
     * @return string
     */
    public function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH);

    /**
     * @return UserInterface
     */
    public function getCurrentUser();

    /**
     * @param mixed $attributes
     * @param mixed $object
     * @return bool
     */
    public function isGranted($attributes, $object = null);

    /**
     * @param string $template
     * @param array $arguments
     * @param Response $response
     * @return Response
     */
    public function render($template, $arguments = array(), Response $response = null);

    /**
     * @param string $template
     * @param array $arguments
     * @return string
     */
    public function renderView($template, $arguments = array());

    /**
     * @param string $template
     * @param array $arguments
     * @param StreamedResponse $response
     * @return StreamedResponse
     */
    public function stream($template, $arguments = array(), StreamedResponse $response = null);

    /**
     * @param mixed $data
     */
    public function validate($data);
}
