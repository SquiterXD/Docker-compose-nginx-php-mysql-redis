<?php


namespace App\Dto\PD;


use App\Dto\AbstractDto;

class RequestLineDto extends AbstractDto
{
    public $name;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    protected function configureValidatorRules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    protected function from(array $data): bool
    {
        $this->name = $data['name'];
        return true;
    }
}
