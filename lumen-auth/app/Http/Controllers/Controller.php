<?php
namespace Jmondi\Auth\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Jmondi\Gut\DomainModel\Entity\Error\ErrorCollection;
use Jmondi\Gut\DomainModel\Entity\Error\ErrorDetail;
use Jmondi\Gut\Infrastructure\Lib\ApplicationCore;
use Jmondi\Gut\Infrastructure\Template\Assets\LaravelRouteUrl;
use Jmondi\Gut\Infrastructure\Template\Generators\AuthTemplateGenerator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const BAD_REQUEST_400 = 400;
    /** @var AuthTemplateGenerator */
    private $templateGenerator;
    /** @var null|ApplicationCore */
    private $applicationCore;

    public function __construct()
    {
        $this->templateGenerator = new AuthTemplateGenerator(
            new LaravelRouteUrl()
        );
    }

    protected function renderView(string $page, array $parameters = [])
    {
        return $this->templateGenerator->renderView($page, $parameters);
    }

    protected function getApplicationCore(): ApplicationCore
    {
        if ($this->applicationCore === null) {
            $this->applicationCore = app(ApplicationCore::class);
        }
        return $this->applicationCore;
    }

    /**
     * @param ErrorDetail[] $errorDetails
     * @param \Throwable|null $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonErrorCollection(
        array $errorDetails,
        int $status,
        \Throwable $e = null
    ) {
        return response()->json(
            new ErrorCollection($errorDetails),
            $status
        );
    }

    protected function jsonErrorMessage(
        string $title,
        string $details,
        int $status = 500,
        \Throwable $e = null
    ) {
        return response()->json(
            new ErrorDetail($details, $title, $status),
            $status
        );
    }

    protected function createValidationErrorResponse(ValidationException $e): \Illuminate\Http\JsonResponse
    {
        $errors = [];
        foreach (json_decode($e->response->getContent()) as $key => $error) {
            $errors[] = new ErrorDetail($error[0], $key, self::BAD_REQUEST_400);
        }
        return $this->jsonErrorCollection($errors, self::BAD_REQUEST_400);
    }
}

