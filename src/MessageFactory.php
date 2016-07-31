<?php

namespace Icicle\Psr7Bridge;

use Icicle\Http\Message\Request as IcicleRequest;
use Icicle\Http\Message\Response as IcicleResponse;
use Icicle\Http\Message\Uri as IcicleUri;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri as PsrUri;
use Zend\Diactoros\Request as PsrRequest;
use Zend\Diactoros\Response as PsrResponse;

final class MessageFactory implements MessageFactoryInterface
{
    /**
     * @param IcicleUri $icicleUri
     * @return PsrUri
     */
    public function createUri(IcicleUri $icicleUri)
    {
        return new PsrUri($icicleUri->__toString());
    }

    /**
     * @param IcicleRequest $icicleRequest
     * @return PsrRequest
     */
    public function createRequest(IcicleRequest $icicleRequest)
    {
        $request = new PsrRequest(
            $this->createUri($icicleRequest->getUri()),
            $icicleRequest->getMethod(),
            new Stream($icicleRequest->getBody()),
            $icicleRequest->getHeaders()
        );

        $request = $request->withProtocolVersion($icicleRequest->getProtocolVersion());

        return $request;
    }

    public function createServerRequest(IcicleRequest $icicleRequest)
    {
        $body = new Stream($icicleRequest->getBody());

        // Parse the POST body for form submissions
        $parsedBody = null;

        if ($icicleRequest->getHeader('Content-Type') === 'application/x-www-form-urlencoded') {
            parse_str($body->getContents(), $parsedBody);
        }

        $request = new ServerRequest(
            [],
            [],
            $this->createUri($icicleRequest->getUri()),
            $icicleRequest->getMethod(),
            $body,
            $icicleRequest->getHeaders(),
            [],
            [],
            $parsedBody
        );

        $request = $request->withProtocolVersion($icicleRequest->getProtocolVersion());

        return $request;
    }

    public function createResponse(IcicleResponse $icicleResponse)
    {
        $response = new PsrResponse(
            new Stream($icicleResponse->getBody()),
            $icicleResponse->getStatusCode(),
            $icicleResponse->getHeaders()
        );

        $response = $response->withProtocolVersion($icicleResponse->getProtocolVersion());

        return $response;
    }
}
