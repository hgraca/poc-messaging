<?php

declare(strict_types=1);

namespace App\Controller;

use PocMessaging\Protobuf\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class EchoController extends AbstractController
{
    public function index(Request $request): Response
    {
        $out = new Message();
        $out->setContent(strtoupper($request->getContent() . ' from the PHP HTTP server.'));

        return new JsonResponse([$out->getContent(), $out->getBigNumber(), $out->getSmallNumber()]);
    }
}
