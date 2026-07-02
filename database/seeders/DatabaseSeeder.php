<?php

namespace Database\Seeders;

use App\Models\User;
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

        // สร้างสินค้าเริ่มต้น
        if (\App\Models\Product::count() === 0) {
            $defaultProducts = [
                // Coffee - Special (55.-)
                ['name' => 'Caramel Macchiato', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'คาราเมล มัคคิอาโต้', 'is_available' => true],
                ['name' => 'White Choc Macchiato', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'ไวท์ช็อก มัคคิอาโต้', 'is_available' => true],
                ['name' => 'Salted Caramel Latte', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'ซอลท์เท็ดคาราเมล ลาเต้', 'is_available' => true],
                ['name' => 'Banchong Signature', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'บรรจง ซิกเนเจอร์', 'is_available' => true],
                ['name' => 'Popcorn Koff', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'ป๊อปคอร์น คอฟฟ์', 'is_available' => true],
                ['name' => 'Coconut Latte', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'โคโคนัท ลาเต้', 'is_available' => true],
                ['name' => 'Vanilla Honey Latte', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'วานิลลา ฮันนี่ ลาเต้', 'is_available' => true],
                ['name' => 'Tiramisu Cloud', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'ทีรามิสุ คลาวด์', 'is_available' => true],
                ['name' => 'Peanut Butter Latte', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'พีนัทบัตเตอร์ ลาเต้', 'is_available' => true],
                ['name' => 'Toffee Coffee Nut', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'ทอฟฟี่ คอฟฟี่ นัท', 'is_available' => true],
                ['name' => 'Butterscotch Latte', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'บัตเตอร์สก็อตช์ ลาเต้', 'is_available' => true],
                ['name' => 'La Vie en Rose', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'ลา วี ออง โรส', 'is_available' => true],
                ['name' => 'Butterfly Effect', 'category' => 'coffee', 'subcategory' => 'Special', 'price' => 55.00, 'description' => 'บัตเตอร์ฟลาย เอฟเฟกต์', 'is_available' => true],
                
                // Coffee - Black (50.-)
                ['name' => 'Espresso Shot', 'category' => 'coffee', 'subcategory' => 'Black', 'price' => 50.00, 'description' => 'เอสเปรสโซ่ ช็อต', 'is_available' => true],
                ['name' => 'Americano', 'category' => 'coffee', 'subcategory' => 'Black', 'price' => 50.00, 'description' => 'อเมริกาโน่', 'is_available' => true],
                ['name' => 'Black Orange', 'category' => 'coffee', 'subcategory' => 'Black', 'price' => 50.00, 'description' => 'อเมริกาโน่ส้ม', 'is_available' => true],
                ['name' => 'Black Yuzu', 'category' => 'coffee', 'subcategory' => 'Black', 'price' => 50.00, 'description' => 'อเมริกาโน่ยูซุ', 'is_available' => true],
                ['name' => 'Black Peach', 'category' => 'coffee', 'subcategory' => 'Black', 'price' => 50.00, 'description' => 'อเมริกาโน่พีช', 'is_available' => true],
                ['name' => 'Black Apple', 'category' => 'coffee', 'subcategory' => 'Black', 'price' => 50.00, 'description' => 'อเมริกาโน่แอปเปิ้ล', 'is_available' => true],
                ['name' => 'Black Lychee', 'category' => 'coffee', 'subcategory' => 'Black', 'price' => 50.00, 'description' => 'อเมริกาโน่ลิ้นจี่', 'is_available' => true],
                ['name' => 'Black Pineapple', 'category' => 'coffee', 'subcategory' => 'Black', 'price' => 50.00, 'description' => 'อเมริกาโน่สับปะรด', 'is_available' => true],
                ['name' => 'Black Cherry', 'category' => 'coffee', 'subcategory' => 'Black', 'price' => 50.00, 'description' => 'อเมริกาโน่เชอร์รี่', 'is_available' => true],

                // Coffee - White (50.-)
                ['name' => 'Latte', 'category' => 'coffee', 'subcategory' => 'White', 'price' => 50.00, 'description' => 'ลาเต้', 'is_available' => true],
                ['name' => 'Es Yen', 'category' => 'coffee', 'subcategory' => 'White', 'price' => 50.00, 'description' => 'เอสเย็น', 'is_available' => true],
                ['name' => 'Cappuccino', 'category' => 'coffee', 'subcategory' => 'White', 'price' => 50.00, 'description' => 'คาปูชิโน่', 'is_available' => true],
                ['name' => 'Mocha', 'category' => 'coffee', 'subcategory' => 'White', 'price' => 50.00, 'description' => 'มอคค่า', 'is_available' => true],

                // Coffee - Milk (50.-)
                ['name' => 'Caramel', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมคาราเมล', 'is_available' => true],
                ['name' => 'White Chocolate', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมไวท์ช็อกโกแลต', 'is_available' => true],
                ['name' => 'Honey', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมน้ำผึ้ง', 'is_available' => true],
                ['name' => 'Vanilla', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมวานิลลา', 'is_available' => true],
                ['name' => 'Strawberry', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมสตรอว์เบอร์รี่', 'is_available' => true],
                ['name' => 'Rose', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมกุหลาบ', 'is_available' => true],
                ['name' => 'Pinky', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมชมพู', 'is_available' => true],
                ['name' => 'Mint', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมมิ้นท์', 'is_available' => true],
                ['name' => 'Butterfly Pea', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมอัญชัน', 'is_available' => true],
                ['name' => 'Hazelnut', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมเฮเซลนัท', 'is_available' => true],
                ['name' => 'Sweet Potato', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมมันม่วง', 'is_available' => true],
                ['name' => 'Salted Caramel', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมซอลท์เท็ดคาราเมล', 'is_available' => true],
                ['name' => 'Butterscotch', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมบัตเตอร์สก็อต', 'is_available' => true],
                ['name' => 'Tiramisu', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมทีรามิสุ', 'is_available' => true],
                ['name' => 'Toffee Nut', 'category' => 'coffee', 'subcategory' => 'Milk', 'price' => 50.00, 'description' => 'นมทอฟฟี่นัท', 'is_available' => true],

                // Non-Coffee - Cocoa
                ['name' => 'Cocoa', 'category' => 'noncoffee', 'subcategory' => 'Cocoa', 'price' => 50.00, 'description' => 'โกโก้', 'is_available' => true],
                ['name' => 'Blackout Cocoa', 'category' => 'noncoffee', 'subcategory' => 'Cocoa', 'price' => 50.00, 'description' => 'โกโก้ดาร์ก', 'is_available' => true],
                ['name' => 'Cocoa Mint', 'category' => 'noncoffee', 'subcategory' => 'Cocoa', 'price' => 50.00, 'description' => 'โกโก้มิ้นท์', 'is_available' => true],
                ['name' => 'Cocoa Banana', 'category' => 'noncoffee', 'subcategory' => 'Cocoa', 'price' => 50.00, 'description' => 'โกโก้กล้วย', 'is_available' => true],

                // Non-Coffee - Tea
                ['name' => 'Thai Green Tea', 'category' => 'noncoffee', 'subcategory' => 'Tea', 'price' => 50.00, 'description' => 'ชาไทย', 'is_available' => true],
                ['name' => 'Matcha (Latte / Pure)', 'category' => 'noncoffee', 'subcategory' => 'Tea', 'price' => 50.00, 'description' => 'ชาเขียวมัทฉะ', 'is_available' => true],
                ['name' => 'Peach Tea', 'category' => 'noncoffee', 'subcategory' => 'Tea', 'price' => 50.00, 'description' => 'ชาพีช', 'is_available' => true],
                ['name' => 'Apple Tea', 'category' => 'noncoffee', 'subcategory' => 'Tea', 'price' => 50.00, 'description' => 'ชาแอปเปิ้ล', 'is_available' => true],
                ['name' => 'Lemon Tea', 'category' => 'noncoffee', 'subcategory' => 'Tea', 'price' => 50.00, 'description' => 'ชามะนาว', 'is_available' => true],
                ['name' => 'Premium Matcha (Latte / Pure)', 'category' => 'noncoffee', 'subcategory' => 'Tea', 'price' => 65.00, 'description' => 'ชาเขียวมัทฉะพรีเมียม', 'is_available' => true],

                // Non-Coffee - Refreshing
                ['name' => 'Sunny Passion', 'category' => 'noncoffee', 'subcategory' => 'Refreshing', 'price' => 50.00, 'description' => 'เสาวรส + ส้ม', 'is_available' => true],
                ['name' => 'Summer Berry', 'category' => 'noncoffee', 'subcategory' => 'Refreshing', 'price' => 50.00, 'description' => 'สตรอว์เบอร์รี่ + ส้ม', 'is_available' => true],
                ['name' => 'Perfect Sunday', 'category' => 'noncoffee', 'subcategory' => 'Refreshing', 'price' => 50.00, 'description' => 'ลิ้นจี่ + องุ่นเคียวโฮ', 'is_available' => true],
                ['name' => 'Cherry Blossom', 'category' => 'noncoffee', 'subcategory' => 'Refreshing', 'price' => 50.00, 'description' => 'ซากุระ + สตรอว์เบอร์รี่ + ลิ้นจี่', 'is_available' => true],
                ['name' => 'PPAP', 'category' => 'noncoffee', 'subcategory' => 'Refreshing', 'price' => 50.00, 'description' => 'แอปเปิ้ล + พีช', 'is_available' => true],
                ['name' => 'Momo Midori', 'category' => 'noncoffee', 'subcategory' => 'Refreshing', 'price' => 50.00, 'description' => 'เมลอน + พีช', 'is_available' => true],
                ['name' => 'Sakura Spring', 'category' => 'noncoffee', 'subcategory' => 'Refreshing', 'price' => 50.00, 'description' => 'องุ่นเคียวโฮ + ซากุระ', 'is_available' => true],
            ];

            foreach ($defaultProducts as $product) {
                \App\Models\Product::create($product);
            }
        }
    }
}
