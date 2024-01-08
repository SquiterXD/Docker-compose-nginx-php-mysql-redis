<?php


namespace App\Dto\PD;


use App\Dto\AbstractDto;

class RequestHeaderDto extends AbstractDto
{
    public $attribute1;

    public function toArray(): array
    {
        return [
            'attribute1' => $this->attribute1,
        ];
    }

    protected function configureValidatorRules(): array
    {
        return [
            'attribute1' => 'required',
        ];
    }

    protected function from(array $data): bool
    {
        $this->attribute1 = $data['attribute1'];
        return true;
    }
}
