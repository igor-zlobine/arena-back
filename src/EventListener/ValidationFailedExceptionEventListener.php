<?php

namespace App\EventListener;


use App\Core\Validation\ValidationFailedException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: 'kernel.exception', priority: 0)]
class ValidationFailedExceptionEventListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof ValidationFailedException) {
            return;
        }

        $event->setResponse(
            new JsonResponse(
                    $exception->getPayload()->toArray(),
                Response::HTTP_BAD_REQUEST
            )
        );
    }
}
