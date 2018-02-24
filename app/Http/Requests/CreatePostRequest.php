<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use Gate;
use App\Reply;
use App\Rules\SpamFree;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Reply);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', new SpamFree]
        ];
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException('You Are Replying Too Frequently');
    }


}
