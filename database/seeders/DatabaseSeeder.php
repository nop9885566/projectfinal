<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // สร้างผู้ใช้เริ่มต้น
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'แอดมิน ร้านบรรจง',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        if (!User::where('email', 'staff@example.com')->exists()) {
            User::create([
                'name' => 'พนักงาน ร้านบารจง',
                'email' => 'staff@example.com',
                'password' => bcrypt('password'),
                'role' => 'staff',
            ]);
        }

        if (!User::where('email', 'customer@example.com')->exists()) {
            User::create([
                'name' => 'ลูกค้า ประจำ',
                'email' => 'customer@example.com',
                'password' => bcrypt('password'),
                'role' => 'customer',
            ]);
        }

        // สร้าง Categories
        $coffee    = Category::firstOrCreate(['slug' => 'coffee'],    ['name' => 'Coffee',     'emoji' => '☕', 'sort_order' => 1]);
        $noncoffee = Category::firstOrCreate(['slug' => 'noncoffee'], ['name' => 'Non-Coffee', 'emoji' => '🧋', 'sort_order' => 2]);
        $cake      = Category::firstOrCreate(['slug' => 'cake'],      ['name' => 'Cake',       'emoji' => '🍰', 'sort_order' => 3]);

        // สร้าง Subcategories
        $special    = Subcategory::firstOrCreate(['category_id' => $coffee->id,    'slug' => 'special'],    ['name' => 'Special',    'sort_order' => 1]);
        $black      = Subcategory::firstOrCreate(['category_id' => $coffee->id,    'slug' => 'black'],      ['name' => 'Black',      'sort_order' => 2]);
        $white      = Subcategory::firstOrCreate(['category_id' => $coffee->id,    'slug' => 'white'],      ['name' => 'White',      'sort_order' => 3]);
        $milk       = Subcategory::firstOrCreate(['category_id' => $noncoffee->id, 'slug' => 'milk'],       ['name' => 'Milk',       'sort_order' => 1]);
        $cocoa      = Subcategory::firstOrCreate(['category_id' => $noncoffee->id, 'slug' => 'cocoa'],      ['name' => 'Cocoa',      'sort_order' => 2]);
        $tea        = Subcategory::firstOrCreate(['category_id' => $noncoffee->id, 'slug' => 'tea'],        ['name' => 'Tea',        'sort_order' => 3]);
        $refreshing = Subcategory::firstOrCreate(['category_id' => $noncoffee->id, 'slug' => 'refreshing'], ['name' => 'Refreshing', 'sort_order' => 4]);

        // สร้างสินค้าเริ่มต้น
        if (\App\Models\Product::count() === 0) {
            $defaultProducts = [
                // Coffee - Special (55.-)
                ['name' => 'Caramel Macchiato',     'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'คาราเมล มัคคิอาโต้', 'is_available' => true],
                ['name' => 'White Choc Macchiato',  'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'ไวท์ช็อก มัคคิอาโต้', 'is_available' => true],
                ['name' => 'Salted Caramel Latte',  'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'ซอลท์เท็ดคาราเมล ลาเต้', 'is_available' => true],
                ['name' => 'Banchong Signature',    'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'บรรจง ซิกเนเจอร์', 'is_available' => true],
                ['name' => 'Popcorn Koff',          'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'ป๊อปคอร์น คอฟฟ์', 'is_available' => true],
                ['name' => 'Coconut Latte',         'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'โคโคนัท ลาเต้', 'is_available' => true],
                ['name' => 'Vanilla Honey Latte',   'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'วานิลลา ฮันนี่ ลาเต้', 'is_available' => true],
                ['name' => 'Tiramisu Cloud',        'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'ทีรามิสุ คลาวด์', 'is_available' => true],
                ['name' => 'Peanut Butter Latte',   'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'พีนัทบัตเตอร์ ลาเต้', 'is_available' => true],
                ['name' => 'Toffee Coffee Nut',     'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'ทอฟฟี่ คอฟฟี่ นัท', 'is_available' => true],
                ['name' => 'Butterscotch Latte',    'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'บัตเตอร์สก็อตช์ ลาเต้', 'is_available' => true],
                ['name' => 'La Vie en Rose',        'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'ลา วี ออง โรส', 'is_available' => true],
                ['name' => 'Butterfly Effect',      'category_id' => $coffee->id, 'subcategory_id' => $special->id, 'price' => 55.00, 'description' => 'บัตเตอร์ฟลาย เอฟเฟกต์', 'is_available' => true],

                // Coffee - Black (50.-)
                ['name' => 'Espresso Shot',  'category_id' => $coffee->id, 'subcategory_id' => $black->id, 'price' => 50.00, 'description' => 'เอสเปรสโซ่ ช็อต', 'is_available' => true],
                ['name' => 'Americano',      'category_id' => $coffee->id, 'subcategory_id' => $black->id, 'price' => 50.00, 'description' => 'อเมริกาโน่', 'is_available' => true],
                ['name' => 'Black Orange',   'category_id' => $coffee->id, 'subcategory_id' => $black->id, 'price' => 50.00, 'description' => 'อเมริกาโน่ส้ม', 'is_available' => true],
                ['name' => 'Black Yuzu',     'category_id' => $coffee->id, 'subcategory_id' => $black->id, 'price' => 50.00, 'description' => 'อเมริกาโน่ยูซุ', 'is_available' => true],
                ['name' => 'Black Peach',    'category_id' => $coffee->id, 'subcategory_id' => $black->id, 'price' => 50.00, 'description' => 'อเมริกาโน่พีช', 'is_available' => true],
                ['name' => 'Black Apple',    'category_id' => $coffee->id, 'subcategory_id' => $black->id, 'price' => 50.00, 'description' => 'อเมริกาโน่แอปเปิ้ล', 'is_available' => true],
                ['name' => 'Black Lychee',   'category_id' => $coffee->id, 'subcategory_id' => $black->id, 'price' => 50.00, 'description' => 'อเมริกาโน่ลิ้นจี่', 'is_available' => true],
                ['name' => 'Black Pineapple','category_id' => $coffee->id, 'subcategory_id' => $black->id, 'price' => 50.00, 'description' => 'อเมริกาโน่สับปะรด', 'is_available' => true],
                ['name' => 'Black Cherry',   'category_id' => $coffee->id, 'subcategory_id' => $black->id, 'price' => 50.00, 'description' => 'อเมริกาโน่เชอร์รี่', 'is_available' => true],

                // Coffee - White (50.-)
                ['name' => 'Latte',      'category_id' => $coffee->id, 'subcategory_id' => $white->id, 'price' => 50.00, 'description' => 'ลาเต้', 'is_available' => true],
                ['name' => 'Es Yen',     'category_id' => $coffee->id, 'subcategory_id' => $white->id, 'price' => 50.00, 'description' => 'เอสเย็น', 'is_available' => true],
                ['name' => 'Cappuccino', 'category_id' => $coffee->id, 'subcategory_id' => $white->id, 'price' => 50.00, 'description' => 'คาปูชิโน่', 'is_available' => true],
                ['name' => 'Mocha',      'category_id' => $coffee->id, 'subcategory_id' => $white->id, 'price' => 50.00, 'description' => 'มอคค่า', 'is_available' => true],

                // Non-Coffee - Milk (50.-)
                ['name' => 'Caramel',         'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมคาราเมล', 'is_available' => true],
                ['name' => 'White Chocolate', 'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมไวท์ช็อกโกแลต', 'is_available' => true],
                ['name' => 'Honey',           'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมน้ำผึ้ง', 'is_available' => true],
                ['name' => 'Vanilla',         'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมวานิลลา', 'is_available' => true],
                ['name' => 'Strawberry',      'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมสตรอว์เบอร์รี่', 'is_available' => true],
                ['name' => 'Rose',            'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมกุหลาบ', 'is_available' => true],
                ['name' => 'Pinky',           'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมชมพู', 'is_available' => true],
                ['name' => 'Mint',            'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมมิ้นท์', 'is_available' => true],
                ['name' => 'Butterfly Pea',   'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมอัญชัน', 'is_available' => true],
                ['name' => 'Hazelnut',        'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมเฮเซลนัท', 'is_available' => true],
                ['name' => 'Sweet Potato',    'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมมันม่วง', 'is_available' => true],
                ['name' => 'Salted Caramel',  'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมซอลท์เท็ดคาราเมล', 'is_available' => true],
                ['name' => 'Butterscotch',    'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมบัตเตอร์สก็อต', 'is_available' => true],
                ['name' => 'Tiramisu',        'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมทีรามิสุ', 'is_available' => true],
                ['name' => 'Toffee Nut',      'category_id' => $noncoffee->id, 'subcategory_id' => $milk->id, 'price' => 50.00, 'description' => 'นมทอฟฟี่นัท', 'is_available' => true],

                // Non-Coffee - Cocoa
                ['name' => 'Cocoa',          'category_id' => $noncoffee->id, 'subcategory_id' => $cocoa->id, 'price' => 50.00, 'description' => 'โกโก้', 'is_available' => true],
                ['name' => 'Blackout Cocoa', 'category_id' => $noncoffee->id, 'subcategory_id' => $cocoa->id, 'price' => 50.00, 'description' => 'โกโก้ดาร์ก', 'is_available' => true],
                ['name' => 'Cocoa Mint',     'category_id' => $noncoffee->id, 'subcategory_id' => $cocoa->id, 'price' => 50.00, 'description' => 'โกโก้มิ้นท์', 'is_available' => true],
                ['name' => 'Cocoa Banana',   'category_id' => $noncoffee->id, 'subcategory_id' => $cocoa->id, 'price' => 50.00, 'description' => 'โกโก้กล้วย', 'is_available' => true],

                // Non-Coffee - Tea
                ['name' => 'Thai Green Tea',              'category_id' => $noncoffee->id, 'subcategory_id' => $tea->id, 'price' => 50.00, 'description' => 'ชาไทย', 'is_available' => true],
                ['name' => 'Matcha (Latte / Pure)',       'category_id' => $noncoffee->id, 'subcategory_id' => $tea->id, 'price' => 50.00, 'description' => 'ชาเขียวมัทฉะ', 'is_available' => true],
                ['name' => 'Peach Tea',                   'category_id' => $noncoffee->id, 'subcategory_id' => $tea->id, 'price' => 50.00, 'description' => 'ชาพีช', 'is_available' => true],
                ['name' => 'Apple Tea',                   'category_id' => $noncoffee->id, 'subcategory_id' => $tea->id, 'price' => 50.00, 'description' => 'ชาแอปเปิ้ล', 'is_available' => true],
                ['name' => 'Lemon Tea',                   'category_id' => $noncoffee->id, 'subcategory_id' => $tea->id, 'price' => 50.00, 'description' => 'ชามะนาว', 'is_available' => true],
                ['name' => 'Premium Matcha (Latte / Pure)', 'category_id' => $noncoffee->id, 'subcategory_id' => $tea->id, 'price' => 65.00, 'description' => 'ชาเขียวมัทฉะพรีเมียม', 'is_available' => true],

                // Non-Coffee - Refreshing
                ['name' => 'Sunny Passion',  'category_id' => $noncoffee->id, 'subcategory_id' => $refreshing->id, 'price' => 50.00, 'description' => 'เสาวรส + ส้ม', 'is_available' => true],
                ['name' => 'Summer Berry',   'category_id' => $noncoffee->id, 'subcategory_id' => $refreshing->id, 'price' => 50.00, 'description' => 'สตรอว์เบอร์รี่ + ส้ม', 'is_available' => true],
                ['name' => 'Perfect Sunday', 'category_id' => $noncoffee->id, 'subcategory_id' => $refreshing->id, 'price' => 50.00, 'description' => 'ลิ้นจี่ + องุ่นเคียวโฮ', 'is_available' => true],
                ['name' => 'Cherry Blossom', 'category_id' => $noncoffee->id, 'subcategory_id' => $refreshing->id, 'price' => 50.00, 'description' => 'ซากุระ + สตรอว์เบอร์รี่ + ลิ้นจี่', 'is_available' => true],
                ['name' => 'PPAP',           'category_id' => $noncoffee->id, 'subcategory_id' => $refreshing->id, 'price' => 50.00, 'description' => 'แอปเปิ้ล + พีช', 'is_available' => true],
                ['name' => 'Momo Midori',    'category_id' => $noncoffee->id, 'subcategory_id' => $refreshing->id, 'price' => 50.00, 'description' => 'เมลอน + พีช', 'is_available' => true],
                ['name' => 'Sakura Spring',  'category_id' => $noncoffee->id, 'subcategory_id' => $refreshing->id, 'price' => 50.00, 'description' => 'องุ่นเคียวโฮ + ซากุระ', 'is_available' => true],
            ];

            foreach ($defaultProducts as $product) {
                \App\Models\Product::create($product);
            }
        }
    }
}
