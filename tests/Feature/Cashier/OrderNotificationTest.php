<?php

namespace Tests\Feature\Cashier;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class OrderNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_poll_returns_only_new_unpaid_orders_after_the_cursor(): void
    {
        $cashier = $this->userWithRole('cashier');
        $newOrder = $this->createOrder('new', 'unpaid', 12500);
        $this->createOrder('new', 'paid', 7000);
        $this->createOrder('cancelled', 'unpaid', 5000);
        $lastOrder = $this->createOrder('preparing', 'unpaid', 8000);

        $response = $this->actingAs($cashier)
            ->getJson(route('cashier.orders.notifications', ['after_id' => 0]));

        $response->assertOk()
            ->assertJsonPath('latest_id', $lastOrder->id)
            ->assertJsonPath('pending_count', 2)
            ->assertJsonCount(1, 'orders')
            ->assertJsonPath('orders.0.id', $newOrder->id)
            ->assertJsonPath('orders.0.order_number', $newOrder->order_number)
            ->assertJsonPath('orders.0.order_type', 'takeaway')
            ->assertJsonStructure([
                'latest_id',
                'pending_count',
                'pending_total',
                'orders' => [
                    '*' => [
                        'id',
                        'order_number',
                        'customer_name',
                        'table_number',
                        'order_type',
                        'requested_payment_method',
                        'total',
                        'ordered_at',
                        'detail_url',
                    ],
                ],
            ]);
        $this->assertEquals(20500, (float) $response->json('pending_total'));

        $this->getJson(route('cashier.orders.notifications', ['after_id' => $lastOrder->id]))
            ->assertOk()
            ->assertJsonCount(0, 'orders');
    }

    public function test_poll_requires_the_cashier_role(): void
    {
        $owner = $this->userWithRole('owner');

        $this->actingAs($owner)
            ->getJson(route('cashier.orders.notifications', ['after_id' => 0]))
            ->assertForbidden();
    }

    public function test_poll_requires_authentication(): void
    {
        $this->getJson(route('cashier.orders.notifications', ['after_id' => 0]))
            ->assertUnauthorized();
    }

    private function userWithRole(string $roleName): User
    {
        $role = Role::create([
            'name' => $roleName,
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create([
            'is_active' => true,
        ]);
        $user->assignRole($role);

        return $user;
    }

    private function createOrder(string $status, string $paymentStatus, int $total): Order
    {
        return Order::create([
            'order_number' => 'RB-TEST-' . uniqid(),
            'customer_name' => 'Test Customer',
            'order_type' => 'takeaway',
            'status' => $status,
            'payment_status' => $paymentStatus,
            'subtotal' => $total,
            'tax' => 0,
            'discount' => 0,
            'total' => $total,
            'ordered_at' => now(),
        ]);
    }
}
