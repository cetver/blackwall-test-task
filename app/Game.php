<?php declare(strict_types=1);

namespace App;

use App\Constants\BatchConstant;
use App\Dto\GameTilesDto;
use Illuminate\Database\Eloquent\Model;
use function iter\chunk;

/**
 * Class Game
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property string $id
 * @property string $user_id
 * @property array $tiles
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 * @property \DateTimeInterface $finished_at
 *
 * @see \App\Observers\GameObserver
 */
class Game extends Model
{
    /**
     * @inheritDoc
     */
    protected $table = 'games';
    /**
     * @inheritDoc
     */
    protected $keyType = 'string';
    /**
     * @inheritDoc
     */
    public $incrementing = false;
    /**
     * @inheritDoc
     */
    protected array $fillable = ['id', 'user_id', 'tiles'];
    /**
     * @inheritDoc
     */
    protected $hidden = ['user_id', 'created_at', 'updated_at', 'finished_at'];
    /**
     * @inheritDoc
     */
    protected array $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    /**
     * @param User $user
     * @param GameTilesDto $dto
     *
     * @return bool
     * @throws \Throwable
     */
    public function createFromDto(User $user, GameTilesDto $dto): bool
    {
        $this->user_id = $user->id;
        $this->tiles = $dto->getTiles();

        return $this->saveOrFail();
    }

    /**
     * @param GameTilesDto ...$tiles
     *
     * @return bool
     * @throws \Throwable
     */
    public function finish(GameTilesDto ...$tiles): bool
    {
        $connection = $this->getConnection();

        return $connection->transaction(
            function () use ($tiles, $connection) {
                foreach (chunk($tiles, BatchConstant::SIZE) as $moveTiles) {
                    $connection->beginTransaction();
                    foreach ($moveTiles as $moveTile) {
                        try {
                            $move = new Move();
                            $move->createFromDto($this, $moveTile);
                        } catch (\InvalidArgumentException $e) {
                            $connection->rollBack();
                            throw $e;
                        }
                    }
                    $connection->commit();
                }

                $this->finished_at = new \DateTimeImmutable();

                return $this->saveOrFail();
            }
        );
    }
}
