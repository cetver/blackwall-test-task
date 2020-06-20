<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\GameTileRule;

class CreateGameRequest extends AbstractApiErrorRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tiles' => app()->get(GameTileRule::class),
        ];
    }
}
