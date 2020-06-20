<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\GameTilesDto;
use App\Http\Requests\CreateGameRequest;
use App\Http\Requests\CreateMoveRequest;
use App\Repositories\GameRepositoryInterface;
use App\Services\GameCreatorService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\LazyCollection;
use Symfony\Component\HttpFoundation\Response;

class GamesController extends Controller
{
    /**
     * @param string $id
     * @param GameRepositoryInterface $repository
     * @param ResponseFactory $responseFactory
     * @param CreateMoveRequest $request
     *
     * @return Response
     */
    public function solve(
        string $id,
        GameRepositoryInterface $repository,
        ResponseFactory $responseFactory,
        CreateMoveRequest $request
    ): Response
    {
        try {
            $game = $repository->findActiveById($id);
        } catch (ModelNotFoundException | QueryException $e) {
            return $responseFactory->json(['error' => 'There is no such game'], Response::HTTP_BAD_REQUEST);
        }

        $data = $request->validated();
        $collection = new LazyCollection($data['moves']);
        $tiles = $collection->map(
            function (array $tiles) {
                return new GameTilesDto(...$tiles);
            }
        );

        try {
            $game->finish(...$tiles);
        } catch (\Throwable $e) {
            return $responseFactory->json(['error' => 'Something went wrong'], Response::HTTP_BAD_REQUEST);
        }

        return $responseFactory->noContent();
    }

    /**
     * @param CreateGameRequest $request
     * @param Authenticatable|\App\User $authenticatable
     * @param GameCreatorService $gameCreatorService
     * @param ResponseFactory $responseFactory
     *
     * @return Response
     */
    public function create(
        CreateGameRequest $request,
        Authenticatable $authenticatable,
        GameCreatorService $gameCreatorService,
        ResponseFactory $responseFactory
    ): Response
    {
        $data = $request->validated();
        $tiles = $data['tiles'] ?? '';
        $user = $authenticatable->getModel();
        try {
            $game = $gameCreatorService->create($user, $tiles);
        } catch (\Throwable $e) {
            return $responseFactory->json(['error' => 'Something went wrong'], Response::HTTP_BAD_REQUEST);
        }

        return $responseFactory->json($game, Response::HTTP_CREATED);
    }
}
