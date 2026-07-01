<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Bali', 'Yogyakarta', 'Semarang', 'Makassar', 'Palembang', 'Malang'];
        $genders = ['male', 'female'];
        $year = date('Y');

        return [
            'ticket_code' => sprintf('AGX-%s-%06d', $year, $this->faker->unique()->numberBetween(1, 999999)),
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '08' . $this->faker->numerify('##########'),
            'gender' => $this->faker->randomElement($genders),
            'birth_date' => $this->faker->dateTimeBetween('1970-01-01', '2005-12-31'),
            'address' => $this->faker->address(),
            'city' => $this->faker->randomElement($cities),
            'identity_number' => $this->faker->numerify('##############'),
            'emergency_contact' => $this->faker->name(),
            'emergency_phone' => '08' . $this->faker->numerify('##########'),
            'status' => $this->faker->randomElement(['unused', 'unused', 'unused', 'checked_in']),
            'checked_in_at' => $this->faker->optional(0.3)->dateTimeBetween('-7 days', 'now'),
        ];
    }

    /**
     * Indicate that the ticket is checked in.
     */
    public function checkedIn(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);
    }

    /**
     * Indicate that the ticket is unused.
     */
    public function unused(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'unused',
            'checked_in_at' => null,
        ]);
    }
}