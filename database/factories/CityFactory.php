<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = [
            'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia', 'San Antonio', 'San Diego',
            'Dallas', 'San Jose', 'Austin', 'Jacksonville', 'Fort Worth', 'Columbus', 'Charlotte', 'San Francisco',
            'Indianapolis', 'Seattle', 'Denver', 'Washington', 'Boston', 'El Paso', 'Nashville', 'Detroit',
            'Oklahoma City', 'Portland', 'Las Vegas', 'Memphis', 'Louisville', 'Baltimore', 'Milwaukee', 'Albuquerque',
            'Tucson', 'Fresno', 'Sacramento', 'Mesa', 'Kansas City', 'Atlanta', 'Long Beach', 'Colorado Springs',
            'Raleigh', 'Miami', 'Virginia Beach', 'Omaha', 'Oakland', 'Minneapolis', 'Tulsa', 'Arlington',
            'Tampa', 'New Orleans', 'Wichita', 'Cleveland', 'Bakersfield', 'Aurora', 'Anaheim', 'Honolulu',
            'Santa Ana', 'Corpus Christi', 'Riverside', 'Lexington', 'Stockton', 'Henderson', 'Saint Paul',
            'St. Louis', 'Milwaukee', 'Portland', 'Orlando', 'Salt Lake City', 'Buffalo', 'Jersey City',
            'Chula Vista', 'Fort Wayne', 'Jersey City', 'Lubbock', 'Madison', 'Durham', 'Laredo', 'Irvine',
            'Winston-Salem', 'Glendale', 'Garland', 'Hialeah', 'Reno', 'Chesapeake', 'Gilbert', 'Baton Rouge',
            'Irving', 'Scottsdale', 'North Las Vegas', 'Fremont', 'Boise', 'Richmond', 'San Bernardino', 'Birmingham',
            'Spokane', 'Rochester', 'Des Moines', 'Modesto', 'Fayetteville', 'Tacoma', 'Oxnard', 'Fontana',
            'Columbus', 'Montgomery', 'Moreno Valley', 'Shreveport', 'Aurora', 'Yonkers', 'Akron', 'Huntington Beach',
            'Little Rock', 'Augusta', 'Amarillo', 'Glendale', 'Mobile', 'Grand Rapids', 'Salt Lake City', 'Tallahassee',
            'Huntsville', 'Grand Prairie', 'Knoxville', 'Worcester', 'Newport News', 'Brownsville', 'Overland Park',
            'Santa Clarita', 'Providence', 'Garden Grove', 'Chattanooga', 'Oceanside', 'Jackson', 'Fort Lauderdale',
            'Santa Rosa', 'Rancho Cucamonga', 'Port St. Lucie', 'Tempe', 'Ontario', 'Vancouver', 'Sioux Falls',
            'Springfield', 'Peoria', 'Pembroke Pines', 'Elk Grove', 'Rockford', 'Palmdale', 'Corona', 'Salinas',
            'Pomona', 'Pasadena', 'Joliet', 'Paterson', 'Kansas City', 'Torrance', 'Syracuse', 'Bridgeport',
            'Hayward', 'Fort Collins', 'Escondido', 'Lakewood', 'Naperville', 'Dayton', 'Hollywood', 'Sunnyvale',
            'Cary', 'Pasadena', 'Macon', 'Alexandria', 'Mesquite', 'Hampton', 'Palmdale', 'Orange', 'Savannah',
            'Fontana', 'Pomona', 'Hollywood', 'Killeen', 'Salinas', 'Pasadena', 'Naperville', 'Joliet', 'Paterson',
            'Kansas City', 'Torrance', 'Syracuse', 'Bridgeport', 'Hayward', 'Fort Collins', 'Escondido', 'Lakewood',
            'Naperville', 'Dayton', 'Hollywood', 'Sunnyvale', 'Cary', 'Pasadena', 'Macon', 'Alexandria', 'Mesquite',
            'Hampton', 'Palmdale', 'Orange', 'Savannah', 'Fontana', 'Pomona', 'Hollywood', 'Killeen', 'Salinas',
            'Pasadena', 'Naperville', 'Joliet', 'Paterson', 'Kansas City', 'Torrance', 'Syracuse', 'Bridgeport',
            'Hayward', 'Fort Collins', 'Escondido', 'Lakewood', 'Naperville', 'Dayton', 'Hollywood', 'Sunnyvale',
            'Cary', 'Pasadena', 'Macon', 'Alexandria', 'Mesquite', 'Hampton', 'Palmdale', 'Orange', 'Savannah'
        ];

        return [
            'name' => $this->faker->randomElement($cities),
            'country_id' => Country::factory(),
        ];
    }

    /**
     * Indicate that the city is in a specific country.
     */
    public function inCountry(Country $country): static
    {
        return $this->state(fn (array $attributes) => [
            'country_id' => $country->id,
        ]);
    }
}