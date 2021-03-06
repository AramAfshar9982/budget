<?php

namespace App\Repositories;

use App\Models\Spending;
use Exception;

class SpendingRepository
{
    public function getValidationRules(): array
    {
        return [
            'tag_id' => 'nullable|exists:tags,id', // TODO CHECK IF TAG BELONGS TO USER
            'date' => 'required|date|date_format:Y-m-d',
            'description' => 'required|max:255',
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/'
        ];
    }

    public function create(
        int $spaceId,
        ?int $importId = null,
        ?int $tagId,
        string $date,
        string $description,
        int $amount
    ): Spending {
        return Spending::create([
            'space_id' => $spaceId,
            'import_id' => $importId,
            'tag_id' => $tagId,
            'happened_on' => $date,
            'description' => $description,
            'amount' => $amount
        ]);
    }

    public function update(int $spendingId, array $data): void
    {
        $spending = Spending::find($spendingId);

        if (!$spending) {
            throw new Exception('Could not find spending with ID ' . $spendingId);
        }

        $spending->fill($data)->save();
    }
}
