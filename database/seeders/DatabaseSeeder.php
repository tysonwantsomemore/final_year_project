<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::create([
            'full_name' => 'Beestyle Admin',
            'email' => 'admin@beestyle.vn',
            'password_hash' => Hash::make('admin123'),
            'phone' => '0909123456',
            'role' => 'Admin',
        ]);

        // Seed Customer User
        User::create([
            'full_name' => 'Nguyễn Khách Hàng',
            'email' => 'customer@beestyle.vn',
            'password_hash' => Hash::make('customer123'),
            'phone' => '0909876543',
            'role' => 'Customer',
        ]);

        // 2. Seed Categories
        $categoriesData = [
            ['name' => 'Áo Nam & Nữ', 'slug' => 'shirt'],
            ['name' => 'Quần Jeans & Tây', 'slug' => 'pants'],
            ['name' => 'Váy Đầm Dạo Phố', 'slug' => 'dress'],
            ['name' => 'Phụ Kiện Cao Cấp', 'slug' => 'accessories'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::create($cat);
        }

        // 3. Seed Vouchers
        Voucher::create([
            'code' => 'BEESTYLE30',
            'discount_percent' => 30.00,
            'max_discount_amount' => 100000.00,
            'min_order_value' => 200000.00,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'usage_limit' => 1000,
        ]);

        // 4. Seed Products
        $productsData = [
            [
                'category_slug' => 'shirt',
                'name' => 'Áo thun Oversized Cotton Premium',
                'price' => 350000,
                'old_price' => 450000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80',
                'tag' => 'Mới',
                'description' => 'Chất liệu 100% cotton tự nhiên tuyển chọn, dệt mật độ cao giúp đứng dáng áo nhưng cực thoáng mát, thấm hút mồ hôi hiệu quả. Kiểu dáng phom rộng hiện đại dễ dàng phối đồ với quần jeans hoặc quần shorts.',
                'rating' => 4.8,
                'sizes' => 'S, M, L, XL',
                'colors' => 'Trắng, Đen, Xám'
            ],
            [
                'category_slug' => 'dress',
                'name' => 'Váy midi Linen dịu dàng phong cách Pháp',
                'price' => 690000,
                'old_price' => null,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600&auto=format&fit=crop&q=80',
                'tag' => 'Hot',
                'description' => 'Đầm thiết kế dáng xòe cổ vuông thanh lịch, chi tiết chiết eo tinh tế giúp nâng dáng thon gọn. Chất liệu sợi lanh (linen) tự nhiên nhập khẩu siêu nhẹ và thoáng mát thích hợp cho những ngày đi biển hoặc dạo phố cuối tuần.',
                'rating' => 4.9,
                'sizes' => 'S, M, L',
                'colors' => 'Be, Xanh Bơ, Hồng nhạt'
            ],
            [
                'category_slug' => 'pants',
                'name' => 'Quần Jeans Slim-fit Classic Xanh Đậm',
                'price' => 520000,
                'old_price' => 650000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=600&auto=format&fit=crop&q=80',
                'tag' => 'Bán Chạy',
                'description' => 'Dáng quần slim-fit ôm nhẹ khoe đôi chân thon gọn nhưng co giãn cực tốt nhờ sự kết hợp giữa sợi denim và spandex cao cấp. Thiết kế cổ điển 5 túi, đường may vô cùng chắc chắn và tinh tế.',
                'rating' => 4.7,
                'sizes' => '29, 30, 31, 32',
                'colors' => 'Xanh Đậm, Xanh Sáng, Đen'
            ],
            [
                'category_slug' => 'shirt',
                'name' => 'Áo sơ mi Lụa Ý Basic thanh lịch công sở',
                'price' => 450000,
                'old_price' => null,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1603252109303-2751441dd157?w=600&auto=format&fit=crop&q=80',
                'tag' => 'Mới',
                'description' => 'Áo sơ mi được thiết kế phom đứng nhẹ nhàng, chất vải dệt lụa bóng mờ cao cấp của Ý hạn chế tối đa nếp nhăn và cực nhẹ da. Một chiếc áo thích hợp cho ngày làm việc công sở lẫn dạo phố sang chảnh.',
                'rating' => 4.6,
                'sizes' => 'M, L, XL',
                'colors' => 'Trắng, Xanh Navy, Đen'
            ],
            [
                'category_slug' => 'shirt',
                'name' => 'Áo khoác Bomber Jacket Gió 2 Lớp',
                'price' => 750000,
                'old_price' => 950000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&auto=format&fit=crop&q=80',
                'tag' => 'Giảm 20%',
                'description' => 'Chiếc khoác bomber đậm chất đường phố năng động sở hữu lớp vải ngoài chống gió và nước nhẹ, lớp lót trong lưới thông hơi tạo cảm giác mát mẻ. Khóa kéo đồng cao cấp siêu mượt, đường bo chun tay dày dặn ôm sát cổ tay.',
                'rating' => 4.9,
                'sizes' => 'M, L, XL, XXL',
                'colors' => 'Đen, Xanh Rêu'
            ],
            [
                'category_slug' => 'dress',
                'name' => 'Chân váy xếp ly dáng lửng trẻ trung',
                'price' => 380000,
                'old_price' => 480000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=600&auto=format&fit=crop&q=80',
                'tag' => 'Sale',
                'description' => 'Chân váy dáng xòe xếp nếp ly to đều đặn tinh tế theo phong cách Preppy năng động. Bên trong được may lót lớp quần bảo hộ thun cotton mềm chống hở, mang lại sự thoải mái tự tin khi di chuyển, hoạt động ngoài trời.',
                'rating' => 4.5,
                'sizes' => 'S, M, L',
                'colors' => 'Kem, Đen'
            ],
            [
                'category_slug' => 'accessories',
                'name' => 'Túi đeo vai Canvas Tote trơn rộng rãi',
                'price' => 250000,
                'old_price' => null,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=600&auto=format&fit=crop&q=80',
                'tag' => 'Yêu Thích',
                'description' => 'Được sản xuất thủ công từ chất vải thô mộc canvas organic siêu dày và chịu lực tốt. Ngăn chứa rộng rãi chứa vừa tài liệu A4, iPad, laptop cỡ nhỏ, thiết kế có cúc bấm kim loại và ngăn khóa phụ tiện dụng.',
                'rating' => 4.7,
                'sizes' => 'Free Size',
                'colors' => 'Nâu hạt dẻ, Kem sữa'
            ],
            [
                'category_slug' => 'accessories',
                'name' => 'Sandal quai da ngang đế bệt êm chân',
                'price' => 320000,
                'old_price' => 400000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=600&auto=format&fit=crop&q=80',
                'tag' => 'Bán Chạy',
                'description' => 'Mẫu giày xăng đan quai mảnh với chất da nhân tạo siêu mềm mịn không để lại vết tấy đỏ trên bàn chân. Phần đế kếp đúc cao su nhẹ cao cấp chống trượt, cho bạn sải bước vững chãi trên mọi địa hình trơn trượt.',
                'rating' => 4.6,
                'sizes' => '36, 37, 38, 39, 40',
                'colors' => 'Đen nhám, Kem sữa'
            ],
        ];

        $products = [];
        foreach ($productsData as $prod) {
            $catSlug = $prod['category_slug'];
            unset($prod['category_slug']);
            $prod['category_id'] = $categories[$catSlug]->id;
            $prod['stock'] = rand(20, 120);

            // Generate default variant_data JSON
            $sizesArr = array_map('trim', explode(',', $prod['sizes'] ?? 'Free Size'));
            $colorsArr = array_map('trim', explode(',', $prod['colors'] ?? 'Mặc định'));
            
            $variantColors = [];
            $mockColorImages = [
                'Trắng' => 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?w=600&auto=format&fit=crop&q=80',
                'Đen' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=600&auto=format&fit=crop&q=80',
                'Xám' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=600&auto=format&fit=crop&q=80',
                'Be' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600&auto=format&fit=crop&q=80',
                'Xanh Bơ' => 'https://images.unsplash.com/photo-1618244972963-dbee1a7edc95?w=600&auto=format&fit=crop&q=80',
                'Hồng nhạt' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600&auto=format&fit=crop&q=80',
                'Xanh Đậm' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=600&auto=format&fit=crop&q=80',
                'Xanh Sáng' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=600&auto=format&fit=crop&q=80',
                'Xanh Navy' => 'https://images.unsplash.com/photo-1603252109303-2751441dd157?w=600&auto=format&fit=crop&q=80',
                'Xanh Rêu' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&auto=format&fit=crop&q=80',
                'Kem' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=600&auto=format&fit=crop&q=80',
                'Nâu hạt dẻ' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=600&auto=format&fit=crop&q=80',
                'Kem sữa' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=600&auto=format&fit=crop&q=80'
            ];

            foreach ($colorsArr as $i => $color) {
                $img = $mockColorImages[$color] ?? $prod['thumbnail_url'];
                $variantColors[$color] = [
                    'image' => $img,
                    'price_offset' => $i * 10000
                ];
            }

            $variantSizes = [];
            foreach ($sizesArr as $i => $size) {
                $variantSizes[$size] = [
                    'price_offset' => $i * 15000
                ];
            }

            $prod['variant_data'] = json_encode([
                'colors' => $variantColors,
                'sizes' => $variantSizes
            ], JSON_UNESCAPED_UNICODE);

            $products[] = Product::create($prod);
        }

        // 5. Seed Reviews
        $reviewsData = [
            [
                'product_index' => 0, // 'Áo thun Oversized Cotton Premium'
                'customer_name' => 'Nguyễn Kiều Trang',
                'rating' => 5,
                'comment' => 'Áo siêu đẹp luôn, chất vải mát lịm, mặc sướng cực kì, shop gói hàng cẩn thận 10/10.'
            ],
            [
                'product_index' => 0,
                'customer_name' => 'Trần Minh Quân',
                'rating' => 4,
                'comment' => 'Áo mặc phom đẹp, rộng rãi thoải mái. Chỉ thừa hơi nhiều tí nhưng cắt đi là ok.'
            ],
            [
                'product_index' => 1, // 'Váy midi Linen dịu dàng phong cách Pháp'
                'customer_name' => 'Lê Thùy Dương',
                'rating' => 5,
                'comment' => 'Đầm linen siêu ưng ý nha mọi người, cổ vuông sâu vừa phải mặc rất tôn xương quai xanh.'
            ],
            [
                'product_index' => 2, // 'Quần Jeans Slim-fit Classic Xanh Đậm'
                'customer_name' => 'Hoàng Anh',
                'rating' => 5,
                'comment' => 'Quần jeans co giãn thoải mái, đi xe máy cả ngày không bị bó gối khó chịu. Ưng lắm shop ơi.'
            ],
        ];

        foreach ($reviewsData as $rev) {
            $prodIndex = $rev['product_index'];
            unset($rev['product_index']);
            $rev['product_id'] = $products[$prodIndex]->id;
            Review::create($rev);
        }

        // 6. Seed Fake Orders and Order Items
        $names = [
            'Nguyễn Văn Nam', 'Trần Thị Mai', 'Phạm Minh Đức', 'Lê Hoàng Yến', 'Hoàng Trung Kiên', 
            'Vũ Tuyết Băng', 'Đặng Ngọc Sơn', 'Bùi Phương Thảo', 'Đỗ Gia Bảo', 'Ngô Khánh Linh', 
            'Phan Thanh Hải', 'Lương Thu Trang', 'Dương Quốc Anh', 'Tống Khánh Huyền', 'Trịnh Quốc Bảo', 
            'Đinh Công Mạnh', 'Lý Mỹ Tâm', 'Vương Đình Phong', 'Nguyễn Bích Thủy', 'Trần Huy Hoàng'
        ];

        $addresses = [
            '12/3 Đường Lê Lợi, Quận 1, TP. HCM', '45 Hàng Ngang, Quận Hoàn Kiếm, Hà Nội', 
            '102 Nguyễn Văn Linh, Quận Thanh Khê, Đà Nẵng', '78 Trần Hưng Đạo, Ninh Kiều, Cần Thơ', 
            '12 Bùi Thị Xuân, Đà Lạt, Lâm Đồng', '256 Lê Hồng Phong, Vũng Tàu', 
            '89 Nguyễn Huệ, Quy Nhơn, Bình Định', '15 Quang Trung, Hồng Bàng, Hải Phòng', 
            '55 Hùng Vương, Nha Trang, Khánh Hòa', '34 Phan Đình Phùng, TP. Vinh, Nghệ An'
        ];

        $voucher = Voucher::where('code', 'BEESTYLE30')->first();

        // Seed 25 orders spanning the last 6 months (180 days)
        for ($i = 0; $i < 25; $i++) {
            $daysAgo = rand(1, 180);
            $createdAt = now()->subDays($daysAgo)->subHours(rand(1, 23))->subMinutes(rand(1, 59));
            
            // Choose status based on how old the order is
            if ($daysAgo > 7) {
                $status = rand(1, 100) <= 85 ? 'Completed' : 'Cancelled';
            } else {
                $statuses = ['Completed', 'Shipping', 'Processing', 'Pending', 'Cancelled'];
                // Give Completed and Processing higher probabilities
                $weights = [40, 20, 20, 10, 10]; 
                $r = rand(1, 100);
                $sum = 0;
                $status = 'Completed';
                foreach ($weights as $index => $w) {
                    $sum += $w;
                    if ($r <= $sum) {
                        $status = $statuses[$index];
                        break;
                    }
                }
            }

            $customerName = $names[array_rand($names)];
            $customerPhone = '09' . rand(10000000, 99999999);
            $customerAddress = $addresses[array_rand($addresses)];
            $paymentMethod = rand(1, 100) <= 70 ? 'cod' : 'bank';
            
            // Create Order first with temp total
            $order = Order::create([
                'status' => $status,
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'customer_address' => $customerAddress,
                'customer_note' => rand(0, 1) ? 'Giao hàng nhanh giúp mình, cảm ơn shop!' : null,
                'payment_method' => $paymentMethod,
                'total_amount' => 0,
                'shipping_fee' => 0,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Add 1 to 3 items
            $itemCount = rand(1, 3);
            $selectedProducts = array_rand($products, $itemCount);
            if (!is_array($selectedProducts)) {
                $selectedProducts = [$selectedProducts];
            }

            $subtotal = 0;
            foreach ($selectedProducts as $prodKey) {
                $product = $products[$prodKey];
                
                // Pick random size from product's sizes
                $prodSizes = array_map('trim', explode(',', $product->sizes));
                $selectedSize = $prodSizes[array_rand($prodSizes)];

                // Pick random color from product's colors
                $prodColors = array_map('trim', explode(',', $product->colors));
                $selectedColor = $prodColors[array_rand($prodColors)];

                $qty = rand(1, 2);
                $price = $product->price;
                $itemTotal = $price * $qty;
                $subtotal += $itemTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $price,
                    'quantity' => $qty,
                    'size' => $selectedSize,
                    'color' => $selectedColor,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }

            // Apply voucher BEESTYLE30 occasionally if min order value matches
            $discount = 0;
            $appliedVoucherId = null;
            if ($voucher && $subtotal >= $voucher->min_order_value && rand(1, 100) <= 40) {
                $discount = ($subtotal * $voucher->discount_percent) / 100;
                if ($discount > $voucher->max_discount_amount) {
                    $discount = $voucher->max_discount_amount;
                }
                $appliedVoucherId = $voucher->id;
            }

            $paymentStatus = 'Unpaid';
            if ($paymentMethod === 'bank' || $status === 'Completed' || $status === 'Shipping') {
                $paymentStatus = 'Paid';
            }

            $order->total_amount = max(0, $subtotal - $discount);
            $order->voucher_id = $appliedVoucherId;
            $order->payment_status = $paymentStatus;
            $order->save();
        }
    }
}
