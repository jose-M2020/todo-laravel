<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Jose Silva',
            'email' => 'jose@gmail.com',
            'password' => 'password'
        ]);

        $createdUser = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password'
        ]);

        $createdList = \App\Models\Todolist::factory()->create([
            'name' => 'Trip Planning',
            'user_id' => $createdUser->id,
            'description' => 'Plan the itinerary and logistics for the weekend trip.',
        ]);

        $createdTask = \App\Models\Task::factory()->create([
            'name' => 'Choose Destination',
            'todolist_id' => $createdList->id,
            'description' => 'Decide on the specific mountain destination for the weekend getaway.',
        ]);

        \App\Models\Step::factory()->create([
            'name' => 'Research Various Destinations',
            'task_id' => $createdTask->id,
            'description' => 'Explore different mountain destinations that match your interests and preferences (e.g., tranquil, scenic, activities available).',
        ]);
        \App\Models\Step::factory()->create([
            'name' => 'Gather Information from Travel Guides',
            'task_id' => $createdTask->id,
            'description' => 'Read travel guides and blogs about the shortlisted destinations to gather information about attractions, accommodations, and local culture.',
        ]);
        \App\Models\Step::factory()->create([
            'name' => 'Consider Travel Distance',
            'task_id' => $createdTask->id,
            'description' => 'Evaluate the distance and travel time from your location to each destination.',
        ]);
        \App\Models\Step::factory()->create([
            'name' => 'Check Accommodation Availability',
            'task_id' => $createdTask->id,
            'description' => 'Verify the availability of lodging options (e.g., cabins, lodges, or hotels) in each destination.',
        ]);
        \App\Models\Step::factory()->create([
            'name' => 'Explore Natural Wonders',
            'task_id' => $createdTask->id,
            'description' => 'Look for nearby natural wonders, hiking trails, and recreational opportunities.',
        ]);
        \App\Models\Step::factory()->create([
            'name' => 'Check for Local Events',
            'task_id' => $createdTask->id,
            'description' => 'Consider any unique events, festivals, or activities happening in the area during your planned weekend.',
        ]);
    }
}
