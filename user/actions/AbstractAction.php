<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

/**
 * An abstract action on which other more specific actions can be based
 * 
 * This class handles most of our request/response basics
 */
abstract class AbstractAction implements ResponderInterface
{
    /**
     * 
     * @var Response A PSR-7 request object
     */
    protected $request = NULL;


    /**
     * 
     * @var Response A PSR-7 response object
     */
    protected $response = NULL;


    /**
     * Modify the response with some commonly required information
     * 
     * @param int $status The status of the response, e.g. 200
     * @param string $content The content of the response
     * @param array $headers An optional array of additional headers
     * @return Response The modified response object with the requisite data
     */
    public function respond($status, $content, $headers = array())
    {
        $stream = $this->response->getBody();

        $stream->rewind();

        foreach ($headers as $name => $value) {
            $this->response = $this->response->withHeader($name, $value);
        }

        $headers['Content-Length'] = $stream->write((string) $content);

        return $this->response->withStatus($status);
    }


    /**
     * {@inheritDoc}
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

    
    /**
     * {@inheritDoc}
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
}