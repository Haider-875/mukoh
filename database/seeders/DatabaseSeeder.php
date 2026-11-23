<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@mukohtires.com'],
            [
                'name' => 'Mukoh Admin',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Also create a demo client account for testing
        User::updateOrCreate(
            ['email' => 'hadihnd0@gmail.com'],
            [
                'name' => 'Haider Ali',
                'password' => Hash::make('password123'),
                'is_admin' => true,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Categories
        $catPassenger = Category::updateOrCreate(
            ['slug' => 'passenger'],
            [
                'name' => 'Passenger',
                'description' => 'Everyday tires for sedans, coupes and compact cars.',
                'icon' => 'assets/icons/passenger.svg',
                'count_label' => '50+ options',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $catSuv = Category::updateOrCreate(
            ['slug' => 'suv'],
            [
                'name' => 'SUV & Truck',
                'description' => 'Road-ready options for crossovers, SUVs and light trucks.',
                'icon' => 'assets/icons/suv.svg',
                'count_label' => '40+ options',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        $catPerf = Category::updateOrCreate(
            ['slug' => 'performance'],
            [
                'name' => 'Performance',
                'description' => 'Grip-focused fitments for sporty and high-performance driving.',
                'icon' => 'assets/icons/performance.svg',
                'count_label' => '25+ options',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        $catTerrain = Category::updateOrCreate(
            ['slug' => 'terrain'],
            [
                'name' => 'All-Terrain',
                'description' => 'Rugged tread choices for mixed road and off-road use.',
                'icon' => 'assets/icons/all-terrain.svg',
                'count_label' => '30+ options',
                'sort_order' => 4,
                'is_active' => true,
            ]
        );

        // 3. Featured Tires (Homepage 3 Cards)
        Product::updateOrCreate(
            ['slug' => 'quality-used-tires'],
            [
                'category_id' => $catPassenger->id,
                'category_slug' => 'passenger',
                'name' => 'Quality Used Tires',
                'brand' => 'VARIOUS BRANDS',
                'condition' => 'used',
                'badge' => 'BEST VALUE',
                'size' => 'Multiple Sizes Available',
                'price' => 40.00,
                'price_unit' => '/ea',
                'description' => 'Thoroughly inspected, dependable pre-owned tires offering practical everyday value for cars and crossovers.',
                'features' => ['Thoroughly inspected', 'Multiple sizes available', 'Practical everyday value'],
                'image' => 'https://images.unsplash.com/photo-1657638004697-0bc1dc350269?auto=format&fit=crop&w=4096&q=90',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'all-season-performance'],
            [
                'category_id' => $catPerf->id,
                'category_slug' => 'performance',
                'name' => 'All Season Performance',
                'brand' => 'ALL SEASON',
                'condition' => 'new',
                'badge' => 'PREMIUM',
                'size' => '205/55R16',
                'price' => 89.00,
                'price_unit' => '/ea',
                'description' => 'Engineered for confident year-round grip, quiet highway cruising, and smooth road feel in wet and dry conditions.',
                'features' => ['All weather traction', 'Comfort minded road feel', 'Low road noise options'],
                'image' => 'https://images.unsplash.com/photo-1760689033990-2462d7ab40d0?auto=format&fit=crop&w=4096&q=90',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'all-terrain-suv'],
            [
                'category_id' => $catTerrain->id,
                'category_slug' => 'terrain',
                'name' => 'All Terrain SUV',
                'brand' => 'ALL TERRAIN',
                'condition' => 'new',
                'badge' => 'SUV / TRUCK',
                'size' => '265/70R17',
                'price' => 129.00,
                'price_unit' => '/ea',
                'description' => 'Durable internal construction and aggressive tread presence for tough mixed road and trail performance.',
                'features' => ['Durable construction', 'Confident mixed road use', 'Enhanced tread presence'],
                'image' => 'https://images.unsplash.com/photo-1772508774964-781e9e0e395f?auto=format&fit=crop&w=4096&q=90',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        // 4. Tires Inventory (12 items matching the Tires page)
        $tiresInventory = [
            [
                'name' => 'Economy All-Season',
                'slug' => 'economy-all-season',
                'brand' => 'Cooper',
                'condition' => 'used',
                'category_slug' => 'passenger',
                'category_id' => $catPassenger->id,
                'size' => '195/65R15',
                'price' => 40.00,
                'features' => ['Good Tread Life', 'Budget Friendly'],
                'sort_order' => 10,
            ],
            [
                'name' => 'Premium Touring',
                'slug' => 'premium-touring',
                'brand' => 'Continental',
                'condition' => 'used',
                'category_slug' => 'passenger',
                'category_id' => $catPassenger->id,
                'size' => '225/50R17',
                'price' => 55.00,
                'features' => ['Good Condition', 'Quality Brand'],
                'sort_order' => 11,
            ],
            [
                'name' => 'Value All-Terrain',
                'slug' => 'value-all-terrain',
                'brand' => 'Cooper',
                'condition' => 'used',
                'category_slug' => 'terrain',
                'category_id' => $catTerrain->id,
                'size' => '255/70R16',
                'price' => 65.00,
                'features' => ['Inspected', 'Good Tread'],
                'sort_order' => 12,
            ],
            [
                'name' => 'Highway Touring Pro',
                'slug' => 'highway-touring-pro',
                'brand' => 'Goodyear',
                'condition' => 'new',
                'category_slug' => 'passenger',
                'category_id' => $catPassenger->id,
                'size' => '215/60R16',
                'price' => 79.00,
                'warranty' => '70K Mile Warranty',
                'features' => ['70K Mile Warranty', 'Fuel Efficient'],
                'sort_order' => 13,
            ],
            [
                'name' => 'All-Season Performance',
                'slug' => 'all-season-performance-michelin',
                'brand' => 'Michelin',
                'condition' => 'new',
                'category_slug' => 'passenger',
                'category_id' => $catPassenger->id,
                'size' => '205/55R16',
                'price' => 89.00,
                'warranty' => '65K Mile Warranty',
                'features' => ['65K Mile Warranty', 'All Weather'],
                'sort_order' => 14,
            ],
            [
                'name' => 'SUV Highway',
                'slug' => 'suv-highway',
                'brand' => 'Hankook',
                'condition' => 'new',
                'category_slug' => 'suv',
                'category_id' => $catSuv->id,
                'size' => '245/65R17',
                'price' => 119.00,
                'features' => ['Quiet Ride', 'Comfort Focused'],
                'sort_order' => 15,
            ],
            [
                'name' => 'Winter Ice',
                'slug' => 'winter-ice',
                'brand' => 'Bridgestone',
                'condition' => 'new',
                'category_slug' => 'passenger',
                'category_id' => $catPassenger->id,
                'size' => '205/55R16',
                'price' => 129.00,
                'features' => ['Snow & Ice', 'Winter Ready'],
                'sort_order' => 16,
            ],
            [
                'name' => 'Commercial Van',
                'slug' => 'commercial-van',
                'brand' => 'Firestone',
                'condition' => 'new',
                'category_slug' => 'suv',
                'category_id' => $catSuv->id,
                'size' => '235/65R16C',
                'price' => 139.00,
                'features' => ['Heavy Load', 'Long Lasting'],
                'sort_order' => 17,
            ],
            [
                'name' => 'All-Terrain AT3',
                'slug' => 'all-terrain-at3',
                'brand' => 'BFGoodrich',
                'condition' => 'new',
                'category_slug' => 'terrain',
                'category_id' => $catTerrain->id,
                'size' => '265/70R17',
                'price' => 159.00,
                'features' => ['Off-Road Ready', 'Durable Tread'],
                'sort_order' => 18,
            ],
            [
                'name' => 'Ultra High Performance',
                'slug' => 'ultra-high-performance',
                'brand' => 'Yokohama',
                'condition' => 'new',
                'category_slug' => 'performance',
                'category_id' => $catPerf->id,
                'size' => '235/40R18',
                'price' => 169.00,
                'features' => ['Track Inspired', 'Maximum Grip'],
                'sort_order' => 19,
            ],
            [
                'name' => 'Sport Performance',
                'slug' => 'sport-performance',
                'brand' => 'Pirelli',
                'condition' => 'new',
                'category_slug' => 'performance',
                'category_id' => $catPerf->id,
                'size' => '225/45R18',
                'price' => 189.00,
                'features' => ['Enhanced Grip', 'High Speed Rated'],
                'sort_order' => 20,
            ],
            [
                'name' => 'Mud-Terrain KM3',
                'slug' => 'mud-terrain-km3',
                'brand' => 'BFGoodrich',
                'condition' => 'new',
                'category_slug' => 'terrain',
                'category_id' => $catTerrain->id,
                'size' => '285/70R17',
                'price' => 199.00,
                'features' => ['Extreme Off-Road', 'Self-Cleaning'],
                'sort_order' => 21,
            ],
        ];

        foreach ($tiresInventory as $tire) {
            Product::updateOrCreate(['slug' => $tire['slug']], array_merge($tire, ['is_active' => true]));
        }

        // 5. Services
        $services = [
            [
                'title' => 'New & Used Tires',
                'slug' => 'new-used-tires',
                'short_description' => 'Quality options for different vehicles and budgets.',
                'full_description' => 'Choose from quality new tires from recognized brands or inspected pre-owned tires for a more budget-conscious fit.',
                'price_starting_at' => '$45',
                'price_subtext' => 'Starting at',
                'features' => ['Popular brands and sizes', 'Inspected used options', 'Cars, trucks and SUVs', 'Competitive pricing'],
                'action_text' => 'Explore ↗',
                'action_link' => '/tires',
                'sort_order' => 1,
            ],
            [
                'title' => 'Tire Installation',
                'slug' => 'tire-installation',
                'short_description' => 'Professional mounting and precision wheel balancing.',
                'full_description' => 'Professional mounting and installation with careful fitment checks, proper torque and attention to valve and TPMS needs.',
                'price_starting_at' => '$20/tire',
                'price_subtext' => 'Starting at',
                'features' => ['Professional mounting', 'Proper torque procedure', 'Valve-stem service', 'TPMS support'],
                'action_text' => 'Book ↗',
                'action_link' => '/contact',
                'sort_order' => 2,
            ],
            [
                'title' => 'Wheel Balancing',
                'slug' => 'wheel-balancing',
                'short_description' => 'Precision computer-aided balancing to reduce vibration.',
                'full_description' => 'Precision balancing helps reduce unwanted vibration, supports even tire wear and contributes to a smoother ride.',
                'price_starting_at' => '$15/wheel',
                'price_subtext' => 'Starting at',
                'features' => ['Computer-aided balancing', 'Vibration reduction', 'Improved ride comfort', 'Helps extend tire life'],
                'action_text' => 'Book ↗',
                'action_link' => '/contact',
                'sort_order' => 3,
            ],
            [
                'title' => 'Tire Repair',
                'slug' => 'tire-repair',
                'short_description' => 'Puncture repair and service to help extend tire life.',
                'full_description' => 'Where a tire can be repaired safely, our technicians inspect the damage and apply a suitable puncture repair method.',
                'price_starting_at' => '$25',
                'price_subtext' => 'Starting at',
                'features' => ['Puncture repair', 'Patch and plug options', 'Safety check included', 'Quick turnaround'],
                'action_text' => 'Repair ↗',
                'action_link' => '/contact',
                'sort_order' => 4,
            ],
            [
                'title' => 'Tire Rotation',
                'slug' => 'tire-rotation',
                'short_description' => 'Regular rotation to ensure even wear across all 4 positions.',
                'full_description' => 'Regular rotation can help tires wear more evenly and support longer usable life across all four positions.',
                'price_starting_at' => '$30',
                'price_subtext' => 'Starting at',
                'features' => ['Promotes even wear', 'Includes visual inspection', 'Helps extend tire life', 'Recommended periodically'],
                'action_text' => 'Book ↗',
                'action_link' => '/contact',
                'sort_order' => 5,
            ],
            [
                'title' => 'Safety Inspection',
                'slug' => 'safety-inspection',
                'short_description' => 'A careful tire check focused on roadworthiness and wear.',
                'full_description' => 'A focused check of tread, sidewalls, inflation and general tire condition to help identify issues before your next trip.',
                'price_starting_at' => 'FREE',
                'price_subtext' => 'With service',
                'features' => ['Tread-depth check', 'Sidewall inspection', 'Inflation check', 'Service recommendations'],
                'action_text' => 'Inspect ↗',
                'action_link' => '/contact',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(['slug' => $srv['slug']], array_merge($srv, ['is_active' => true]));
        }

        // 6. Testimonials
        $testimonials = [
            [
                'author_name' => 'JAMES M.',
                'rating' => 5,
                'content' => 'Fast service, fair pricing and a team that gets you back on the road quickly.',
                'sort_order' => 1,
            ],
            [
                'author_name' => 'SARAH K.',
                'rating' => 5,
                'content' => 'Professional, knowledgeable service and practical help choosing the right tire.',
                'sort_order' => 2,
            ],
            [
                'author_name' => 'MICHAEL R.',
                'rating' => 5,
                'content' => 'A solid tire selection with straightforward advice for the budget I had in mind.',
                'sort_order' => 3,
            ],
            [
                'author_name' => 'DAVID L.',
                'rating' => 5,
                'content' => 'The service was quick, clear and easy from the first call through installation.',
                'sort_order' => 4,
            ],
            [
                'author_name' => 'MARIA T.',
                'rating' => 5,
                'content' => 'They explained the options clearly and helped me choose a tire that fit my budget.',
                'sort_order' => 5,
            ],
            [
                'author_name' => 'KEVIN B.',
                'rating' => 5,
                'content' => 'Clean work, good communication and a smooth experience from start to finish.',
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['author_name' => $t['author_name']], array_merge($t, ['is_active' => true]));
        }

        // 7. Website Settings
        $settings = [
            // General & Contact
            ['site_name', 'MUKOH TIRES LLC', 'general', 'text', 'Company Name'],
            ['site_tagline', 'Quality Tires You Can Trust', 'general', 'text', 'Site Tagline'],
            ['phone_display', '(240) 854-0273', 'contact', 'text', 'Display Phone Number'],
            ['phone_raw', '+12408540273', 'contact', 'text', 'Raw Phone URL'],
            ['email', 'mukohtires@gmail.com', 'contact', 'text', 'Contact Email'],
            ['address', '3415 Berwyn Ave, Baltimore, MD 21207', 'contact', 'textarea', 'Shop Street Address'],
            ['business_hours', 'Monday – Sunday: 8:00 AM – 7:30 PM', 'contact', 'text', 'Business Hours'],
            ['maps_directions_url', 'https://www.google.com/maps/dir/?api=1&destination=3415+Berwyn+Ave%2C+Baltimore%2C+MD+21207', 'contact', 'text', 'Google Maps Directions URL'],
            ['maps_embed_url', 'https://www.google.com/maps?q=3415%20Berwyn%20Ave%2C%20Baltimore%2C%20MD%2021207&output=embed', 'contact', 'text', 'Google Maps Embed URL'],

            // Hero Section
            ['hero_eyebrow', 'PROFESSIONAL TIRE SERVICES', 'hero', 'text', 'Hero Eyebrow Badge'],
            ['hero_title_line1', 'QUALITY.', 'hero', 'text', 'Hero Title Line 1'],
            ['hero_title_line2', 'TIRES.', 'hero', 'text', 'Hero Title Line 2'],
            ['hero_title_emphasis', 'YOU CAN TRUST.', 'hero', 'text', 'Hero Title Italic Emphasis'],
            ['hero_intro', 'Professional tire service built around safety, speed and honest value for every road you take.', 'hero', 'textarea', 'Hero Intro Description'],
            ['hero_kicker_1', 'NEW & USED TIRES', 'hero', 'text', 'Hero Kicker 1'],
            ['hero_kicker_2', 'INSTALLATION & BALANCING', 'hero', 'text', 'Hero Kicker 2'],
            ['hero_kicker_3', 'TIRE REPAIR & INSPECTION', 'hero', 'text', 'Hero Kicker 3'],
            ['hero_quick_title', 'Get back on the road.', 'hero', 'text', 'Hero Quick Card Title'],
            ['hero_quick_copy', 'New and used tires from practical everyday options to premium road ready setups.', 'hero', 'textarea', 'Hero Quick Card Description'],

            // Capability / Engineering Section
            ['cap_eyebrow', 'BUILT FROM THE INSIDE OUT', 'hero', 'text', 'Capability Eyebrow'],
            ['cap_title_line1', 'ENGINEERED FOR', 'hero', 'text', 'Capability Title Line 1'],
            ['cap_title_emphasis', 'EVERY ROAD.', 'hero', 'text', 'Capability Title Emphasis'],
            ['cap_intro', 'Every layer matters. Our tire selection is chosen for dependable grip, strong construction and confident everyday performance.', 'hero', 'textarea', 'Capability Intro Text'],
            ['cap_description', 'From budget friendly used tires to all season and all terrain options, Mukoh helps match the tire to your vehicle, driving style and budget.', 'hero', 'textarea', 'Capability Section Description'],

            // Stats
            ['stat_years', '15', 'about', 'text', 'Years of Experience'],
            ['stat_customers', '10', 'about', 'text', 'Happy Customers (K+)'],
            ['stat_brands', '50', 'about', 'text', 'Tire Brands'],
            ['stat_rating', '4.9', 'about', 'text', 'Customer Rating (/5)'],

            // Footer
            ['footer_about', 'Your trusted partner for quality tires and professional automotive services. Serving our community with excellence.', 'general', 'textarea', 'Footer About Text'],
            ['footer_credit', 'Designed By Azora Solution', 'general', 'text', 'Footer Designer Credit'],
            ['footer_credit_url', 'https://azorasolution.com', 'general', 'text', 'Footer Designer URL'],

            // 3D Experience Settings
            ['enable_3d_experience', '1', '3d', 'boolean', 'Enable 3D Experience'],
            ['threejs_render_quality', 'high', '3d', 'text', 'Three.js Render Quality (high/medium/low)'],
            ['threejs_auto_rotate', '1', '3d', 'boolean', 'Enable Interactive 3D Rotation'],
            ['threejs_antialiasing', '1', '3d', 'boolean', 'Enable MSAA Anti-Aliasing'],

            // Sound Effects Settings
            ['enable_sound_effects', '1', 'sound', 'boolean', 'Enable Website Sound Effects'],
            ['sound_volume', '0.4', 'sound', 'number', 'Master Sound Volume (0.0 to 1.0)'],

            // SEO Metadata
            ['meta_title', 'Mukoh Tires LLC | Quality Tires You Can Trust', 'seo', 'text', 'Default Meta Title'],
            ['meta_description', 'Mukoh Tires LLC quality new and used tires, installation, balancing, repair and inspections in Baltimore, MD.', 'seo', 'textarea', 'Default Meta Description'],
            ['meta_keywords', 'Mukoh tires, tire shop Baltimore, new tires, used tires, tire installation, wheel balancing, tire repair', 'seo', 'text', 'Default Meta Keywords'],
        ];

        foreach ($settings as [$key, $value, $group, $type, $label]) {
            WebsiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $group,
                    'type' => $type,
                    'label' => $label,
                ]
            );
        }

        // 8. Pages
        $pages = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'meta_title' => 'Mukoh Tires LLC | Quality Tires You Can Trust',
                'meta_description' => 'Mukoh Tires LLC quality new and used tires, installation, balancing, repair and inspections.',
            ],
            [
                'title' => 'Tires',
                'slug' => 'tires',
                'meta_title' => 'Tires | Mukoh Tires LLC',
                'meta_description' => 'Browse Mukoh Tires new and used tire inventory by vehicle category and condition.',
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'meta_title' => 'Services | Mukoh Tires LLC',
                'meta_description' => 'Tire installation, balancing, repair, rotation and safety inspection services from Mukoh Tires.',
            ],
            [
                'title' => 'About Us',
                'slug' => 'about',
                'meta_title' => 'About Us | Mukoh Tires LLC',
                'meta_description' => 'Learn about Mukoh Tires LLC - local tire service, expert technicians, and honest value in Baltimore, MD.',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'meta_title' => 'Contact | Mukoh Tires LLC',
                'meta_description' => 'Book a tire appointment or contact Mukoh Tires in Baltimore, Maryland.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'meta_title' => 'Privacy Policy | Mukoh Tires LLC',
                'meta_description' => 'Privacy Policy for Mukoh Tires LLC.',
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms',
                'meta_title' => 'Terms of Service | Mukoh Tires LLC',
                'meta_description' => 'Terms of Service for Mukoh Tires LLC.',
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], array_merge($p, ['is_active' => true]));
        }

        // 9. Sample Inquiries and Appointments for realistic initial dashboard
        Inquiry::updateOrCreate(
            ['email' => 'marcus.vance@example.com'],
            [
                'type' => 'quote',
                'name' => 'Marcus Vance',
                'phone' => '(410) 555-0192',
                'subject' => 'Quote for 4 All-Terrain Tires',
                'message' => 'Looking for a quote on a set of 4 BFGoodrich All-Terrain KO2 or similar for my 2021 Ford F-150. Size 275/65R18. When can you mount them?',
                'vehicle_info' => '2021 Ford F-150',
                'tire_size' => '275/65R18',
                'status' => 'contacted',
                'is_read' => true,
                'created_at' => now()->subDays(1),
            ]
        );

        Inquiry::updateOrCreate(
            ['email' => 'elena.rodriguez@example.com'],
            [
                'type' => 'contact',
                'name' => 'Elena Rodriguez',
                'phone' => '(240) 555-8834',
                'subject' => 'Tire repair check',
                'message' => 'I have a slow leak in my passenger rear tire. Can I drive in this afternoon for an inspection and repair?',
                'vehicle_info' => '2019 Honda Civic',
                'tire_size' => '215/55R16',
                'status' => 'pending',
                'is_read' => false,
                'created_at' => now()->subHours(3),
            ]
        );

        Inquiry::updateOrCreate(
            ['email' => 'darnell.washington@example.com'],
            [
                'type' => 'tire_inquiry',
                'name' => 'Darnell Washington',
                'phone' => '(443) 555-7201',
                'subject' => 'Used tires in stock',
                'message' => 'Do you have matching pairs of used Continental or Michelin in 225/45R17 with good tread?',
                'vehicle_info' => '2018 Toyota Camry',
                'tire_size' => '225/45R17',
                'status' => 'pending',
                'is_read' => false,
                'created_at' => now()->subMinutes(45),
            ]
        );

        Appointment::updateOrCreate(
            ['email' => 'brandon.hayes@example.com'],
            [
                'first_name' => 'Brandon',
                'last_name' => 'Hayes',
                'phone' => '(240) 782-9901',
                'service_name' => 'Tire Installation & Balancing',
                'vehicle_type' => 'SUV',
                'vehicle_year' => '2022',
                'vehicle_make' => 'Toyota',
                'vehicle_model' => 'RAV4',
                'tire_size' => '225/65R17',
                'preferred_date' => now()->addDays(2)->format('Y-m-d'),
                'preferred_time' => 'Morning',
                'message' => 'Purchasing 4 new tires, need mounting and road force balancing.',
                'status' => 'confirmed',
                'is_read' => true,
                'created_at' => now()->subDays(2),
            ]
        );

        Appointment::updateOrCreate(
            ['email' => 'chloe.bennett@example.com'],
            [
                'first_name' => 'Chloe',
                'last_name' => 'Bennett',
                'phone' => '(410) 902-3341',
                'service_name' => 'Safety Inspection & Tire Rotation',
                'vehicle_type' => 'Passenger Car',
                'vehicle_year' => '2020',
                'vehicle_make' => 'Subaru',
                'vehicle_model' => 'Outback',
                'tire_size' => '225/60R18',
                'preferred_date' => now()->addDays(1)->format('Y-m-d'),
                'preferred_time' => 'Afternoon',
                'message' => 'Pre-roadtrip inspection and rotation.',
                'status' => 'pending',
                'is_read' => false,
                'created_at' => now()->subHours(2),
            ]
        );
    }
}
