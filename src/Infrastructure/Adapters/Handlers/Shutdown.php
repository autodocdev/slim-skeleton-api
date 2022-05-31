<?php

declare(strict_types=1);

namespace Infrastructure\Adapters\Handlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\ResponseEmitter;

use function error_get_last;
use function ob_clean;
use function ob_get_length;
use function sprintf;

use const E_USER_ERROR;
use const E_USER_NOTICE;
use const E_USER_WARNING;

class Shutdown
{
    private Request $request;

    private HttpError $errorHandler;

    private bool $displayErrorDetails;

    public function __construct(Request $request, HttpError $errorHandler, bool $displayErrorDetails)
    {
        $this->request = $request;
        $this->errorHandler = $errorHandler;
        $this->displayErrorDetails = $displayErrorDetails;
    }

    public function __invoke()
    {
        $error = error_get_last();
        if (!$error) {
            return;
        }
            $errorFile = $error['file'];
            $errorLine = $error['line'];
            $errorMessage = $error['message'];
            $errorType = $error['type'];
            $message = 'An error while processing your request. Please try again later.';

        if ($this->displayErrorDetails) {
            switch ($errorType) {
                case E_USER_ERROR:
                    $message = sprintf('FATAL ERROR: %s. ', $errorMessage);
                    $message .= sprintf('on line %s in file %s.', $errorLine, $errorFile);

                    break;
                case E_USER_WARNING:
                    $message = sprintf('WARNING: %s', $errorMessage);

                    break;
                case E_USER_NOTICE:
                    $message = sprintf('NOTICE: %s', $errorMessage);

                    break;
                default:
                    $message = sprintf('ERROR: %s', $errorMessage);
                    $message .= sprintf('on line %s in file %s.', $errorLine, $errorFile);

                    break;
            }
        }

        $exception = new HttpInternalServerErrorException($this->request, $message);
        $response = $this->errorHandler->__invoke(
            $this->request,
            $exception,
            $this->displayErrorDetails,
            false,
            false
        );

        if (ob_get_length()) {
            ob_clean();
        }

        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($response);
    }
}
