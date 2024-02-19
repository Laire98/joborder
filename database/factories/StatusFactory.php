<?php

namespace Database\Factories;

use App\Models\StatusModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = StatusModel::class;

    public function definition(): array
    {
        return [
            'status_desc' => 'New',
            'created_at' => now(),
        ];
    }

    public function claim()
    {
        return $this->state(function (array $attributes) {
            return [
                'status_desc' => 'Claimed',
                'created_at' => now(),
            ];
        });
    }

    public function working()
    {
        return $this->state(function (array $attributes) {
            return [
                'status_desc' => 'Working',
                'created_at' => now(),
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status_desc' => 'Pending',
                'created_at' => now(),
            ];
        });
    }
}
