<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MukohWebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_load_successfully(): void
    {
        $pages = [
            '/' => 'MUKOH',
            '/tires' => 'MUKOH',
            '/services' => 'MUKOH',
            '/about' => 'MUKOH',
            '/contact' => 'MUKOH',
            '/privacy' => 'Privacy',
            '/privacy-policy' => 'Privacy',
            '/terms' => 'Terms',
            '/terms-of-service' => 'Terms',
            '/sitemap.xml' => '</urlset>',
        ];

        foreach ($pages as $url => $expectedContent) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $response->assertSee($expectedContent, false);
        }
    }

    public function test_contact_form_submission_creates_inquiry_with_celebratory_response(): void
    {
        $payload = [
            'name' => 'Alexander Vance',
            'email' => 'alex.vance@example.com',
            'phone' => '+1 (555) 349-2041',
            'subject' => 'Tread Compound Inquiry',
            'message' => 'Interested in the thermal properties of the UltraGrip Sport compound for track day use.',
        ];

        $response = $this->postJson(route('inquiry.contact'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'title' => 'SUBMITTED!',
        ]);

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Alexander Vance',
            'email' => 'alex.vance@example.com',
            'type' => 'contact',
        ]);
    }

    public function test_quick_quote_submission_creates_quote_record(): void
    {
        $payload = [
            'name' => 'Samantha Cross',
            'email' => 'samantha@example.com',
            'phone' => '+1 (555) 789-0123',
            'vehicle_info' => '2024 Porsche Taycan 4S',
            'tire_size' => '245/45 R20',
            'message' => 'Looking for all-weather high-efficiency EV tires.',
        ];

        $response = $this->postJson(route('inquiry.quote'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'title' => 'SUBMITTED!',
        ]);

        $this->assertDatabaseHas('inquiries', [
            'name' => 'Samantha Cross',
            'type' => 'quote',
            'tire_size' => '245/45 R20',
        ]);
    }

    public function test_appointment_booking_submission(): void
    {
        $payload = [
            'first' => 'David',
            'last' => 'Miller',
            'email' => 'david.m@example.com',
            'phone' => '+1 (555) 901-2345',
            'service' => 'Laser Precision Wheel Alignment',
            'type' => 'SUV / Crossover',
            'year' => '2023',
            'make' => 'BMW',
            'model' => 'X5 M50i',
            'size' => '275/40 R21',
            'date' => date('Y-m-d', strtotime('+3 days')),
            'time' => '10:00 AM - 12:00 PM',
            'message' => 'Please perform 4-wheel alignment check after new tire installation.',
        ];

        $response = $this->postJson(route('contact.appointment'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'title' => 'SUBMITTED!',
        ]);

        $this->assertDatabaseHas('appointments', [
            'first_name' => 'David',
            'last_name' => 'Miller',
            'vehicle_make' => 'BMW',
            'vehicle_model' => 'X5 M50i',
        ]);
    }

    public function test_admin_guest_redirected_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $loginResponse = $this->post(route('login.submit'), [
            'email' => 'admin@mukohtires.com',
            'password' => 'admin123',
        ]);

        $loginResponse->assertRedirect(route('admin.dashboard'));

        $admin = User::where('email', 'admin@mukohtires.com')->first();
        $this->actingAs($admin);

        // Test Admin Dashboard & Sections
        $this->get(route('admin.dashboard'))->assertStatus(200)->assertSee('Dashboard');
        $this->get(route('admin.products.index'))->assertStatus(200)->assertSee('Product Catalog');
        $this->get(route('admin.services.index'))->assertStatus(200)->assertSee('Service Offerings');
        $this->get(route('admin.inquiries.index'))->assertStatus(200)->assertSee('Submissions List');
        $this->get(route('admin.appointments.index'))->assertStatus(200)->assertSee('Booking Requests');
        $this->get(route('admin.testimonials.index'))->assertStatus(200)->assertSee('Testimonials');
        $this->get(route('admin.content.index'))->assertStatus(200)->assertSee('Company Branding');
        $this->get(route('admin.settings.index'))->assertStatus(200)->assertSee('Profile Information');
    }

    public function test_admin_product_crud_flow(): void
    {
        $admin = User::where('email', 'admin@mukohtires.com')->first();
        $this->actingAs($admin);

        $category = Category::first();

        // 1. Create product
        $storeResponse = $this->post(route('admin.products.store'), [
            'name' => 'Test Apex Grip Pro',
            'brand' => 'MUKOH RACING',
            'size' => '255/35 R19',
            'category_id' => $category->id,
            'condition' => 'new',
            'badge' => 'High Grip',
            'price' => 289.99,
            'original_price' => 329.99,
            'price_unit' => '/ea',
            'description' => 'Maximum dry asphalt grip with dual-compound compound.',
            'features' => "Track tested\nHigh silica\nReinforced shoulder",
            'is_featured' => 1,
            'is_active' => 1,
        ]);

        $storeResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Test Apex Grip Pro',
            'brand' => 'MUKOH RACING',
            'price' => 289.99,
        ]);

        $product = Product::where('name', 'Test Apex Grip Pro')->first();

        // 2. Update product
        $updateResponse = $this->put(route('admin.products.update', $product), [
            'name' => 'Test Apex Grip Pro Updated',
            'brand' => 'MUKOH RACING',
            'size' => '255/35 R19',
            'category_id' => $category->id,
            'condition' => 'new',
            'badge' => 'Sale',
            'price' => 269.99,
            'is_active' => 1,
        ]);
        $updateResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Test Apex Grip Pro Updated',
            'price' => 269.99,
        ]);

        // 3. Toggle product status
        $this->patch(route('admin.products.toggle', $product));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_active' => 0,
        ]);

        // 4. Delete product
        $deleteResponse = $this->delete(route('admin.products.destroy', $product));
        $deleteResponse->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_inquiry_and_appointment_csv_exports(): void
    {
        $admin = User::where('email', 'admin@mukohtires.com')->first();
        $this->actingAs($admin);

        // Test Inquiry CSV export stream
        $inquiryExport = $this->get(route('admin.inquiries.export'));
        $inquiryExport->assertStatus(200);
        $inquiryExport->assertHeader('content-type', 'text/csv; charset=UTF-8');

        // Test Appointment CSV export stream
        $aptExport = $this->get(route('admin.appointments.export'));
        $aptExport->assertStatus(200);
        $aptExport->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
