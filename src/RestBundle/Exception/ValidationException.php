<?php

namespace Core\RestBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
class ValidationException extends HttpException
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $errorList;

    public function __construct(ConstraintViolationListInterface $errorList)
    {
        parent::__construct(400);
        $this->errorList = $errorList;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrorList()
    {
        return $this->errorList;
    }
}