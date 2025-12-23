<?php

namespace Tests\Feature;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicineTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_medicines_index(): void
    {
        $response = $this->get('/medicines');

        $response->assertStatus(200);
        $response->assertViewIs('medicines.index');
    }

    public function test_can_view_medicine_details(): void
    {
        $medicine = Medicine::factory()->create();

        $response = $this->get("/medicines/{$medicine->id}");

        $response->assertStatus(200);
        $response->assertViewIs('medicines.show');
        $response->assertViewHas('medicine', $medicine);
    }

    public function test_authenticated_user_can_create_medicine(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/medicines/create');
        
        $response->assertStatus(200);
        $response->assertViewIs('medicines.create');
    }

    public function test_unauthenticated_user_cannot_create_medicine(): void
    {
        $response = $this->get('/medicines/create');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_store_medicine(): void
    {
        $user = User::factory()->create();
        
        $medicineData = [
            'name' => 'Тестовое лекарство',
            'description' => 'Описание тестового лекарства',
            'price' => 100.50,
            'quantity' => 10,
            'category' => 'Тестовая категория',
            'manufacturer' => 'Тестовый производитель',
            'expiry_date' => now()->addYear()->format('Y-m-d'),
        ];

        $response = $this->actingAs($user)->post('/medicines', $medicineData);

        $response->assertRedirect('/medicines');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('medicines', [
            'name' => 'Тестовое лекарство',
            'price' => 100.50,
        ]);
    }

    public function test_authenticated_user_can_edit_medicine(): void
    {
        $user = User::factory()->create();
        $medicine = Medicine::factory()->create();

        $response = $this->actingAs($user)->get("/medicines/{$medicine->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('medicines.edit');
        $response->assertViewHas('medicine', $medicine);
    }

    public function test_authenticated_user_can_update_medicine(): void
    {
        $user = User::factory()->create();
        $medicine = Medicine::factory()->create([
            'name' => 'Старое название',
            'price' => 50.00,
        ]);

        $updateData = [
            'name' => 'Новое название',
            'description' => $medicine->description,
            'price' => 75.00,
            'quantity' => $medicine->quantity,
            'category' => $medicine->category,
            'manufacturer' => $medicine->manufacturer,
            'expiry_date' => $medicine->expiry_date?->format('Y-m-d'),
        ];

        $response = $this->actingAs($user)->put("/medicines/{$medicine->id}", $updateData);

        $response->assertRedirect('/medicines');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('medicines', [
            'id' => $medicine->id,
            'name' => 'Новое название',
            'price' => 75.00,
        ]);
    }

    public function test_authenticated_user_can_delete_medicine(): void
    {
        $user = User::factory()->create();
        $medicine = Medicine::factory()->create();

        $response = $this->actingAs($user)->delete("/medicines/{$medicine->id}");

        $response->assertRedirect('/medicines');
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('medicines', [
            'id' => $medicine->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_delete_medicine(): void
    {
        $medicine = Medicine::factory()->create();

        $response = $this->delete("/medicines/{$medicine->id}");

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('medicines', [
            'id' => $medicine->id,
        ]);
    }

    public function test_medicine_validation_requires_name(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/medicines', [
            'price' => 100,
            'quantity' => 10,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_medicine_validation_requires_price(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/medicines', [
            'name' => 'Тестовое лекарство',
            'quantity' => 10,
        ]);

        $response->assertSessionHasErrors(['price']);
    }

    public function test_medicine_validation_rejects_expired_date(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/medicines', [
            'name' => 'Тестовое лекарство',
            'price' => 100,
            'quantity' => 10,
            'expiry_date' => now()->subDay()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors(['expiry_date']);
    }
}
