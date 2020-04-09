<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 09/04/2020
 * Time: 15:29
 */

namespace App\Exception;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormException extends HttpException
{
    /** @var FormInterface $form */
    private $form;

    /**
     * FormException constructor.
     * @param FormInterface $form
     * @param int $statusCode
     * @param string|null $message
     * @param \Throwable|null $previous
     * @param array $headers
     * @param int|null $code
     */
    public function __construct(
        FormInterface $form,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        string $message = null,
        \Throwable $previous = null,
        array $headers = [],
        ?int $code = 0
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
        $this->form =$form;
    }

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }
}