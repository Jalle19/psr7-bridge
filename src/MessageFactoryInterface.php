<?php

namespace Icicle\Psr7Bridge;

use Icicle\Http\Message\Request as IcicleRequest;
use Icicle\Http\Message\Response as IcicleResponse;
use Icicle\Http\Message\Uri as IcicleUri;

interface MessageFactoryInterface
{
    /**
     * @param IcicleUri $icicleUri
     *
     * @return \Psr\Http\Message\UriInterface
     */
    public function createUri(IcicleUri $icicleUri);

    /**
     * @param IcicleRequest $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function createRequest(IcicleRequest $request);

    /**
     * @param \Icicle\Http\Message\Response $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createResponse(IcicleResponse $response);
}
