<?php

namespace Seiffert\ControllerHelperBundle\Helper;

use Seiffert\ControllerHelperBundle\Exception\MissingDependencyException;
use Seiffert\HelperBundle\HelperInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

class FormHelper implements HelperInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory = null)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return string[]|array
     */
    public static function getHelperMethodNames()
    {
        return array('createForm');
    }

    /**
     * @param FormTypeInterface $type
     * @param mixed $data
     * @param array $options
     * @return FormInterface
     * @throws MissingDependencyException
     */
    public function createForm(FormTypeInterface $type, $data = null, array $options = array())
    {
        if (null === $this->formFactory) {
            throw new MissingDependencyException('No form factory present.');
        }

        return $this->formFactory->create($type, $data, $options);
    }
}
