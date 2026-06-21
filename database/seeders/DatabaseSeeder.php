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
                'name' => 'แอดมิน ร้านบารจง',
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
                // Coffee
                ['name' => 'Signature Latte', 'category' => 'coffee', 'price' => 75.00, 'description' => 'ลาเต้สูตรพิเศษของร้าน นุ่มละมุน หอมกลิ่นนม', 'is_available' => true],
                ['name' => 'Cold Brew', 'category' => 'coffee', 'price' => 85.00, 'description' => 'กาแฟสกัดเย็น 18 ชั่วโมง เข้มข้น สดชื่น', 'is_available' => true],
                ['name' => 'Double Espresso', 'category' => 'coffee', 'price' => 65.00, 'description' => 'เอสเปรสโซ่คู่ เข้มข้น ตื่นตัวได้ทันที', 'is_available' => true],
                ['name' => 'Caramel Macchiato', 'category' => 'coffee', 'price' => 90.00, 'description' => 'คาราเมลหอมหวาน ผสมลาเต้ ราดซอสคาราเมล', 'is_available' => true],
                
                // Non-Coffee
                ['name' => 'Matcha Latte', 'category' => 'noncoffee', 'price' => 80.00, 'description' => 'ชาเขียวญี่ปุ่นแท้ ผสมนมสดสูตรเข้มข้น', 'is_available' => true],
                ['name' => 'ชาไทยนมสด', 'category' => 'noncoffee', 'price' => 65.00, 'description' => 'ชาไทยสูตรต้นตำรับ หอมเครื่องเทศ หวานมัน', 'is_available' => true],
                ['name' => 'Fruit Soda', 'category' => 'noncoffee', 'price' => 70.00, 'description' => 'โซดาผลไม้สดสดชื่น หลายรสชาติให้เลือก', 'is_available' => true],
                ['name' => 'Hot Chocolate', 'category' => 'noncoffee', 'price' => 75.00, 'description' => 'ช็อกโกแลตเบลเยี่ยมแท้ เข้มข้น หอมหวาน', 'is_available' => true],

                // Bakery
                ['name' => 'Butter Croissant', 'category' => 'bakery', 'price' => 55.00, 'description' => 'ครัวซองค์เนยแท้ อบสด กรอบนอก นุ่มใน', 'is_available' => true],
                ['name' => 'Banana Muffin', 'category' => 'bakery', 'price' => 45.00, 'description' => 'มัฟฟินกล้วยหอม นุ่ม หอมหวาน', 'is_available' => true],
                ['name' => 'Classic Scones', 'category' => 'bakery', 'price' => 60.00, 'description' => 'สโคนสูตรอังกฤษ เสิร์ฟพร้อมแยมและครีม', 'is_available' => true],
                ['name' => 'Cinnamon Roll', 'category' => 'bakery', 'price' => 65.00, 'description' => 'ซินนาบอนสูตรพิเศษ อบสด หอมอบเชย', 'is_available' => true],

                // Food
                ['name' => 'Brunch Set', 'category' => 'food', 'price' => 150.00, 'description' => 'ไข่ ขนมปัง เบคอน สลัด ครบในจานเดียว', 'is_available' => true],
                ['name' => 'Club Sandwich', 'category' => 'food', 'price' => 120.00, 'description' => 'แซนวิชหน้าไก่ ชีส มะเขือเทศ เสิร์ฟพร้อมมันฝรั่ง', 'is_available' => true],
                ['name' => 'Creamy Pasta', 'category' => 'food', 'price' => 140.00, 'description' => 'พาสต้าซอสครีม ไก่ย่าง เห็ด หอมกรุ่น', 'is_available' => true],
                ['name' => 'ข้าวหน้าไก่ย่าง', 'category' => 'food', 'price' => 110.00, 'description' => 'ข้าวหน้าไก่ย่างสมุนไพร ราดซอสพิเศษ เสิร์ฟร้อน', 'is_available' => true],
            ];

            foreach ($defaultProducts as $product) {
                \App\Models\Product::create($product);
            }
        }
    }
}
