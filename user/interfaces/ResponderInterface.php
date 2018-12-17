<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

/**
 * A common responder interface
 */
interface ResponderInterface
{
    /**
     * Set the response on a responder
     * 
     * @param Response $response A PSR-7 Response object
     * @return object The object for method chaining
     */
    public function setResponse(Response $response);


    /**
     * Set the request the responder is responding to
     * 
     * @param Reequest $request A PSR-7 Request object
     * @return object The object for method chaining
     */
    public function setRequest(Request $request);
}