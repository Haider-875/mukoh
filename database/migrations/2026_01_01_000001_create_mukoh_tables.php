<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update users table with admin flag and role if not existing
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_admin')->default(false)->after('password');
                $table->string('role')->default('user')->after('is_admin');
            });
        }

        // 2. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->text('icon_svg')->nullable();
            $table->string('count_label')->default('30+ options');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Products (Tires)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->enum('condition', ['new', 'used'])->default('new');
            $table->string('category_slug')->default('passenger');
            $table->string('badge')->nullable(); // e.g. "BEST VALUE", "PREMIUM", "SUV / TRUCK"
            $table->string('size')->nullable(); // e.g. "195/65R15"
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('price_unit')->default('/ea');
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // e.g. ["Good Tread Life", "Budget Friendly"]
            $table->string('image')->nullable();
            $table->string('warranty')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. Services
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->string('price_starting_at')->nullable(); // e.g. "$45", "$20/tire"
            $table->string('price_subtext')->default('Starting at'); // e.g. "Starting at", "With service"
            $table->json('features')->nullable();
            $table->text('icon_svg')->nullable();
            $table->string('image')->nullable();
            $table->string('action_text')->default('Book ↗');
            $table->string('action_link')->default('/contact');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Inquiries (Contact, Quote, Tire Inquiries)
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['contact', 'quote', 'tire_inquiry'])->default('contact');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('vehicle_info')->nullable();
            $table->string('tire_size')->nullable();
            $table->enum('status', ['pending', 'contacted', 'completed', 'cancelled'])->default('pending');
            $table->boolean('is_read')->default(false);
            $table->text('notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });

        // 6. Appointments
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('service_name')->nullable();
            $table->string('vehicle_type')->nullable(); // Passenger Car, SUV, Truck, Van
            $table->string('vehicle_year')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('tire_size')->nullable();
            $table->date('preferred_date');
            $table->string('preferred_time'); // Morning, Afternoon, Evening
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->boolean('is_read')->default(false);
            $table->text('notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });

        // 7. Testimonials
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('author_name'); // e.g. "JAMES M."
            $table->integer('rating')->default(5);
            $table->text('content');
            $table->string('vehicle_or_service')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 8. Website Settings (Key-Value Content Management)
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general'); // general, hero, contact, about, seo, 3d, sound
            $table->string('type')->default('text'); // text, textarea, boolean, image, number, json
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 9. Static Pages Metadata & Content
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('website_settings');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('services');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['is_admin', 'role']);
            });
        }
    }
};
