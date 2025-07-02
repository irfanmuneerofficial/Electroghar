<?php

namespace Theme\Electroghar\Http\Requests;

use Botble\Support\Http\Requests\Request;

class SendDownloadAppLinksRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }
}
