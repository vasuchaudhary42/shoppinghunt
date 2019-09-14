<?php
namespace App\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AjaxException extends \Exception
{
    const UNAUTHORIZED = 'Authentication Required!';
    const BAD_REQUEST  = 'Credentials not found!';
    const USER_NOT_FOUND = 'User not found!';
    const UNSUCCESSFULLY_LOGIN = 'Unsuccessfully Login!';
    const INVALID_CREDENTIALS = 'Invalid credentials found!';
    const INVALID_TOKEN= 'Invalid Token!';
    const DOMAIN_NOT_FOUND = 'Domain not found';
    private $errorCode = Response::HTTP_BAD_REQUEST;
    private $status = false;
    private $response = null;
    private $errors = [];

    private  static $ajaxException = null;

    public static function init(string $message = '', int $errorCode = 400, bool $status = false, array $errors = []){
        self::$ajaxException = isset(self::$ajaxException) ? self::$ajaxException : new AjaxException();

        self::$ajaxException->setErrors($errors);
        self::$ajaxException->setStatus($status);
        self::$ajaxException->setMessage($message);
        self::$ajaxException->setErrorCode($errorCode);

        return self::$ajaxException;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setErrorCode(int $errorCode): self
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function setStatus(bool $status): self {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): bool {
        return $this->status;
    }

    public function getResponse(): JsonResponse
    {
        return isset($this->response) ? $this->response : new JsonResponse([
            'success' => $this->status,
            'message' => $this->message,
            'errors'  => $this->errors
        ],$this->errorCode);
    }

    public function setResponse(JsonResponse $response): self
    {
        $this->response = $response;
        return $this;
    }

    public function sendExceptionResponse(callable $callback = null)
    {
        $this->getResponse()->send();
        if(isset($callback) && is_callable($callback)){
            call_user_func($callback);
        }
    }

    public function sendExceptionResponseAndExit(callable $callback = null){
        $this->sendExceptionResponse($callback);
        die;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}