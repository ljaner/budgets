<?php


namespace App\Infrastructure\Api\Budget;


use App\Application\UseCase\Budget\Create\CreateBudgetUseCase;
use App\Application\UseCase\Budget\Create\CreateBudgetUseCaseRequest;
use App\Application\UseCase\Budget\Get\GetBudgetUseCase;
use App\Application\UseCase\Budget\Get\GetBudgetUseCaseRequest;
use App\Application\UseCase\Budget\ListAll\ListAllBudgetUseCase;
use App\Application\UseCase\Budget\ListAll\ListAllBudgetUseCaseRequest;
use App\Application\UseCase\Budget\Publish\PublishBudgetUseCase;
use App\Application\UseCase\Budget\Publish\PublishBudgetUseCaseRequest;
use App\Application\UseCase\Budget\Update\UpdateBudgetUseCase;
use App\Application\UseCase\Budget\Update\UpdateBudgetUseCaseRequest;
use App\Domain\Exceptions\BudgetNotPending;
use App\Infrastructure\Api\ApiResponse;
use App\Infrastructure\Transformers\BudgetJsonTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("/budget")
*/
class BudgetApi extends AbstractController
{

    private $budgetTransformer;


    public function __construct(
        BudgetJsonTransformer $budgetTransformer
    )
    {
        $this->budgetTransformer = $budgetTransformer;
    }

    /**
     * @Route("/create", name="create_budget", methods={"POST"})
     * @param Request $request
     * @param CreateBudgetUseCase $createBudgetUseCase
     * @return JsonResponse
     */
    public function createBudgetsAction(Request $request,CreateBudgetUseCase $createBudgetUseCase): JsonResponse
    {
        try {
            $createBudgetUseCaseRequest  = new CreateBudgetUseCaseRequest(
                $request->get('description'),
                $request->get('category'),
                $request->get('subcategory'),
                $request->get('name'),
                $request->get('email'),
                $request->get('phone'),
                $request->get('address')
            );
            if($request->get('date')) $createBudgetUseCaseRequest->setDate($request->get('date'));
            return new JsonResponse(
                $this->sendApiResponse($this->budgetTransformer->transformWithUser($createBudgetUseCase->execute($createBudgetUseCaseRequest))),
                Response::HTTP_OK
            );
        }catch ( \InvalidArgumentException $exception) {
            return new JsonResponse(
                $this->sendApiResponse(null, "Invalid request", ['Email' => $exception->getMessage()]),
                Response::HTTP_BAD_REQUEST
            );
        }
        catch ( \Exception $exception) {
            return new JsonResponse(
                $this->sendApiResponse(null, $exception->getMessage()),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * @Route("/update", name="update_budget", methods={"PUT"})
     * @param Request $request
     * @param UpdateBudgetUseCase $updateBudgetCase
     * @return JsonResponse
     */
    public function updateBudgetsAction(Request $request, UpdateBudgetUseCase $updateBudgetCase): JsonResponse
    {
        try {
            $updateBudgetUseCaseRequest =new UpdateBudgetUseCaseRequest($request->get('id'));
            if($request->get('description')) $updateBudgetUseCaseRequest->setDescription($request->get('description'));
            if($request->get('date')) $updateBudgetUseCaseRequest->setDate($request->get('date'));
            if($request->get('category')) $updateBudgetUseCaseRequest->setCategory($request->get('category'));
            if($request->get('subcategory')) $updateBudgetUseCaseRequest->setSubCategory($request->get('subcategory'));
            return new JsonResponse(
                $this->sendApiResponse($this->budgetTransformer->transform($updateBudgetCase->execute($updateBudgetUseCaseRequest))),
                Response::HTTP_OK
            );
        }catch (BudgetNotPending| \Exception $exception) {
            return new JsonResponse(
                $this->sendApiResponse(null, $exception->getMessage(), ['error' => $exception->getMessage()]),
                Response::HTTP_FORBIDDEN
            );
        }
    }

    /**
     * @Route("/publish", name="publish_budget", methods={"POST"})
     * @param Request $request
     * @param PublishBudgetUseCase $publishBudgetCase
     * @return JsonResponse
     */
    public function publishBudgetsAction(Request $request, PublishBudgetUseCase $publishBudgetCase): JsonResponse
    {
        try {
            return new JsonResponse(
                $this->sendApiResponse($this->budgetTransformer->transform($publishBudgetCase->execute(new PublishBudgetUseCaseRequest($request->get('id')))))
                , Response::HTTP_OK
            );
        }catch (BudgetNotPending | \Exception $exception) {
            return new JsonResponse(
                $this->sendApiResponse(null, $exception->getMessage(),['error' => $exception->getMessage()]),
                Response::HTTP_FORBIDDEN
            );
        }
    }

    /**
     * @Route("/list", name="listall_budget", methods={"GET"})
     * @param Request $request
     * @param ListAllBudgetUseCase $listAllBudgetUseCase
     * @return JsonResponse
     */
    public function listAllBudgetsAction(Request $request, ListAllBudgetUseCase $listAllBudgetUseCase): JsonResponse
    {
        try {
            $listAllRequest = new ListAllBudgetUseCaseRequest();
            if($request->get('email')) {
                $listAllRequest->setEmail($request->get('email'));
            }
            return new JsonResponse(
                $this->sendApiResponse($this->budgetTransformer->transformsWithUser($listAllBudgetUseCase->execute($listAllRequest))),
                    Response::HTTP_OK
            );
        }catch (\Exception $exception) {
            return new JsonResponse(
                $this->sendApiResponse(null, $exception->getMessage(), ['error' => $exception->getMessage()]),
                Response::HTTP_BAD_REQUEST
            );
        }

    }

    /**
     * @Route("/{id}", name="get_budget", methods={"GET"})
     * @param Request $request
     * @param GetBudgetUseCase $getBudgetUseCase
     * @return JsonResponse
     */
    public function getBudgetAction(Request $request, GetBudgetUseCase $getBudgetUseCase): JsonResponse
    {
        try {
            return new JsonResponse(
                $this->sendApiResponse($this->budgetTransformer->transformWithUser($getBudgetUseCase->execute(new GetBudgetUseCaseRequest( $request->get('id'))))),
                Response::HTTP_OK
            );
        }catch (\Exception $exception) {
            return new JsonResponse(
                $this->sendApiResponse(null, $exception->getMessage(), ['error' => $exception->getMessage()]),
                Response::HTTP_NOT_FOUND
            );
        }
    }

    private function sendApiResponse($data = null, string $message = "", array $errors = [])
    {
        if ($data === null) {
            $data = [];
        }

        $response = [
            'message' => $message,
            'data'    => $data,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return $response;
    }

}