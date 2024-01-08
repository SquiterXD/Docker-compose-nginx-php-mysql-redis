<?php

namespace App\Dto;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class AbstractDto extends \ArrayObject implements \JsonSerializable, DtoInterface, Arrayable, \ArrayAccess
{
    protected $dataReady = false;
    protected $data = [];

    /**
     * AbstractRequestDto constructor.
     * @param array $data
     * @throws ValidationException
     */
    public function __construct(array $data = [])
    {
        $this->bind($data);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function bind(array $data = [])
    {
        if (empty($data)) {
            $this->dataReady = false;
            return;
        }
        // We create a validator, with all the data we receive.
        // The rules come from the child class.
        $validator = Validator::make(
            $data,
            $this->configureValidatorRules()
        );

        // We now validate the data we receive, for this DTO.
        // If it fails we throw an exception.
        if (!$validator->validate()) {
            throw new ValidationException($validator, null, 'Error: ' . $validator->errors()->first());
        }

        // The data is valid.
        // Now we map it.
        if (!$this->from($data)) {
            throw new ValidationException($validator, null, 'The mapping failed');
        }

        $this->data = $data;
        $this->dataReady = true;
    }

    public function bindTo(Model $model): Model
    {
        foreach ($this->toArray() as $field => $val) {
            $model->$field = $val;
        }
        return $model;
    }

    public function ready(): bool
    {
        return $this->dataReady;
    }

    /* @return array */
    protected function configureValidatorRules(): array
    {
        return [];
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function from(array $data): bool
    {
        return false;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }


    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
