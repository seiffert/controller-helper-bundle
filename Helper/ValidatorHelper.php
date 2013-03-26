<?php

namespace Seiffert\ControllerHelperBundle\Helper;

use Seiffert\ControllerHelperBundle\Exception\MissingDependencyException;
use Seiffert\HelperBundle\HelperInterface;
use Symfony\Component\Validator\ValidatorInterface;

class ValidatorHelper implements HelperInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator = null)
    {
        $this->validator = $validator;
    }

    /**
     * @return string[]|array
     */
    public static function getHelperMethodNames()
    {
        return array('validate');
    }

    /**
     * @param mixed $data
     * @throws MissingDependencyException
     */
    public function validate($data)
    {
        if (!$this->validator) {
            throw new MissingDependencyException('No validator present.');
        }

        return $this->validator->validate($data);
    }
}
