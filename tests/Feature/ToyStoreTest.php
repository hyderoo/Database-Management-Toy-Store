<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Feature tests for the Toy Store domain (toys, customers, suppliers,
 * transactions) against the real database schema from dbtoystorekel20.sql.
 *
 * Each test runs inside a transaction that is rolled back afterwards,
 * so the seed data stays untouched.
 */
class ToyStoreTest extends TestCase
{
    use DatabaseTransactions;

    private function makeToy(int $id = 901, string $name = 'Test Kite', int $price = 5000, int $stock = 7): void
    {
        DB::table('toy')->insert([
            'toy_id' => $id, 'toy_name' => $name, 'price' => $price, 'stock' => $stock,
        ]);
    }

    private function makeCustomer(int $id = 901): void
    {
        DB::table('customer')->insert([
            'customer_id' => $id, 'customer_name' => 'Test Buyer',
            'email' => 'buyer@example.com', 'phone' => '08000000001',
        ]);
    }

    private function makeSupplier(int $id = 901): void
    {
        DB::table('supplier')->insert([
            'supplier_id' => $id, 'supplier_name' => 'Test Supplier',
            'contact_info' => '08000000002', 'alamat' => 'Test Street',
        ]);
    }

    public function test_toy_index_page_loads(): void
    {
        $this->makeToy();
        $response = $this->get('/toy');
        $response->assertStatus(200);
        $response->assertSee('Test Kite');
    }

    public function test_toy_store_creates_row_and_redirects(): void
    {
        $response = $this->post('/toystore', [
            'toy_id' => 910, 'toy_name' => 'Puzzle Block', 'price' => 12000, 'stock' => 3,
        ]);
        $response->assertRedirect(route('toy.index'));
        $this->assertDatabaseHas('toy', ['toy_id' => 910, 'toy_name' => 'Puzzle Block']);
    }

    public function test_toy_store_rejects_missing_fields(): void
    {
        $response = $this->post('/toystore', ['toy_name' => 'Incomplete']);
        $response->assertSessionHasErrors(['toy_id', 'price', 'stock']);
        $this->assertDatabaseMissing('toy', ['toy_name' => 'Incomplete']);
    }

    public function test_toy_search_filters_by_name(): void
    {
        $this->makeToy(911, 'Rubik Cube');
        $this->makeToy(912, 'Toy Drum');
        $response = $this->get('/toy/search?keyword=Rubik');
        $response->assertStatus(200);
        $response->assertSee('Rubik Cube');
        $response->assertDontSee('Toy Drum');
    }

    public function test_toy_update_changes_the_row(): void
    {
        $this->makeToy(913, 'Old Name');
        // The controller matches on the posted `id` field, not the URL id.
        $response = $this->post('/toy/update/913', [
            'id' => 913, 'toy_id' => 913, 'toy_name' => 'New Name', 'price' => 9900, 'stock' => 2,
        ]);
        $response->assertRedirect(route('toy.index'));
        $this->assertDatabaseHas('toy', ['toy_id' => 913, 'toy_name' => 'New Name', 'price' => 9900]);
    }

    public function test_toy_delete_removes_the_row(): void
    {
        $this->makeToy(914, 'Doomed Toy');
        $response = $this->post('/toy/delete/914');
        $this->assertDatabaseMissing('toy', ['toy_id' => 914]);
    }

    public function test_customer_index_page_loads(): void
    {
        $this->makeCustomer();
        $response = $this->get('/customer');
        $response->assertStatus(200);
        $response->assertSee('Test Buyer');
    }

    public function test_customer_store_creates_row(): void
    {
        $response = $this->post('/customer/store', [
            'customer_id' => 915, 'customer_name' => 'New Buyer',
            'email' => 'new@example.com', 'phone' => '08111111111',
        ]);
        $response->assertRedirect(route('customer.index'));
        $this->assertDatabaseHas('customer', ['customer_id' => 915, 'customer_name' => 'New Buyer']);
    }

    public function test_customer_soft_delete_restore_and_hard_delete(): void
    {
        $this->makeCustomer(916);

        $this->post('/customer/delete/916')->assertRedirect(route('customer.index'));
        $this->assertDatabaseMissing('customer', ['customer_id' => 916, 'deleted' => null]);

        $this->get('/customer/restore/916')->assertRedirect(route('customer.index'));
        $this->assertDatabaseHas('customer', ['customer_id' => 916, 'deleted' => null]);

        $this->post('/customer/restore/delete/916');
        $this->assertDatabaseMissing('customer', ['customer_id' => 916]);
    }

    public function test_soft_deleted_customers_appear_in_the_trash_view(): void
    {
        $this->makeCustomer(917);
        DB::table('customer')->where('customer_id', 917)->update(['deleted' => now()]);
        $response = $this->get('/customer/recent');
        $response->assertStatus(200);
        $response->assertSee('Test Buyer');
    }

    public function test_transaksi_store_creates_row(): void
    {
        $this->makeSupplier(920);
        $this->makeToy(920, 'Transaction Toy');
        $this->makeCustomer(920);

        $response = $this->post('/transaksi/store', [
            'transaksi_date' => '2026-10-18', 'total' => 55000,
            'supplier_id' => 920, 'toy_id' => 920, 'customer_id' => 920,
        ]);
        $response->assertRedirect(route('transaksi.index'));
        $this->assertDatabaseHas('transaksi', [
            'toy_id' => 920, 'customer_id' => 920, 'total' => 55000,
        ]);
    }

    public function test_transaksi_store_rejects_missing_fields(): void
    {
        $response = $this->post('/transaksi/store', ['total' => 1000]);
        $response->assertSessionHasErrors(['transaksi_date', 'supplier_id', 'toy_id', 'customer_id']);
    }
}
