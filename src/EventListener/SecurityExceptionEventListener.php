<?php

namespace App\EventListener;


use App\Core\Exception\SecurityException;
use App\Core\Validation\ValidationFailedException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: 'kernel.exception', priority: 0)]
class SecurityExceptionEventListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof SecurityException) {
            return;
        }

        $event->setResponse(
            new JsonResponse(
                    [
                        'message' => 'Access denied',
                    ],
                Response::HTTP_FORBIDDEN
            )
        );
    }
}
