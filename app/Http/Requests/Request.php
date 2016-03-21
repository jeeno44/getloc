<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Предобработка массива входных данных запроса.
     *
     * @param array $input
     * @return array
     */
    protected function prepare(array $input)
    {
        return $input;
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->prepareInput();
        parent::validate();
    }

    /**
     * Подготавливаем данные запроса.
     */
    private function prepareInput()
    {
        $attributes = $this->all();
        $attributes = $this->prepare($attributes);
        $this->replace($attributes);
    }
}
