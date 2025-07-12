<?php

namespace App\EventListener;

use App\Core\Exception\NotFoundException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: 'kernel.exception', priority: 0)]
class NotFoundExceptionEventListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof NotFoundException) {
            return;
        }

        $event->setResponse(
            new JsonResponse(
                    [
                        'message' => $exception->getMessage(),
                    ],
                Response::HTTP_NOT_FOUND
            )
        );
    }
}
