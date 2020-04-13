<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 09/04/2020
 * Time: 14:04
 */

namespace App\Subscriber;


use App\Exception\FormException;
use App\Response\ApiResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{

    /** @var Serializer $serializer */
    private $serializer;

    /** @var LoggerInterface $logger */
    private $logger;

    public function __construct(SerializerInterface $serializer, LoggerInterface $logger)
    {
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }

    public function onKernelException(ExceptionEvent $event) {
        $throwable = $event->getThrowable();
        $this->logger->error($throwable);

        $statusCode = $throwable instanceof HttpExceptionInterface
            ? $throwable->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        $errors = [];

        $isSupportErrors = in_array(get_class($throwable), $this->supportErrorsException());
        if ($isSupportErrors) {
            try {
                $errors = $this->serializer->normalize($throwable);
            } catch (\Throwable $t) {
                $errors = [];
            }
        }

        $response = new ApiResponse($throwable->getMessage(), null, $errors, $statusCode);
        $event->setResponse($response);
    }

    /**
     * @return array
     */
    private function supportErrorsException() : array
    {
        return [
            FormException::class
        ];
    }
}