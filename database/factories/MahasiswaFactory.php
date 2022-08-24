<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "mahasiswa_id" => $this->faker->id(),
            "mahasiswa_nama" => $this->faker->nama(),
            "mahasiswa_kelas" => $this->faker->kelas(),
            "mahasiswa_nrp" => $this->faker->nrp(),
        ];
    }
}
