<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Color;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\ProductSizeGuide;
use App\Models\InventoryTransaction;
use App\Models\ProductTag;
use App\Models\ProductCollection;
use App\Models\ShippingMethod;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\PaymentTransaction;
use App\Models\OrderStatusHistory;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Roles
        $adminRole = Role::create(['name' => 'Admin', 'description' => 'Administrator with full system control.']);
        $customerRole = Role::create(['name' => 'Customer', 'description' => 'Standard retail customer.']);

        // 2. Seed Users
        $adminUser = User::create([
            'role_id' => $adminRole->id,
            'full_name' => 'Beestyle Admin',
            'email' => 'admin@beestyle.vn',
            'password_hash' => Hash::make('admin123'),
            'phone' => '0909123456',
            'status' => 'Active',
        ]);

        $customerUser = User::create([
            'role_id' => $customerRole->id,
            'full_name' => 'Nguyễn Khách Hàng',
            'email' => 'customer@beestyle.vn',
            'password_hash' => Hash::make('customer123'),
            'phone' => '0909876543',
            'status' => 'Active',
        ]);

        $names = [
            'Nguyễn Văn Nam', 'Trần Thị Mai', 'Phạm Minh Đức', 'Lê Hoàng Yến', 'Hoàng Trung Kiên', 
            'Vũ Tuyết Băng', 'Đặng Ngọc Sơn', 'Bùi Phương Thảo', 'Đỗ Gia Bảo', 'Ngô Khánh Linh', 
            'Phan Thanh Hải', 'Lương Thu Trang', 'Dương Quốc Anh', 'Tống Khánh Huyền', 'Trịnh Quốc Bảo', 
            'Đinh Công Mạnh', 'Lý Mỹ Tâm', 'Vương Đình Phong', 'Nguyễn Bích Thủy', 'Trần Huy Hoàng'
        ];

        $customerUsers = [$customerUser];
        foreach ($names as $name) {
            $customerUsers[] = User::create([
                'role_id' => $customerRole->id,
                'full_name' => $name,
                'email' => Str::slug($name, '') . '@gmail.com',
                'password_hash' => Hash::make('customer123'),
                'phone' => '09' . rand(10000000, 99999999),
                'status' => 'Active',
            ]);
        }

        // 3. Seed Addresses
        $provinces = ['Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng', 'Cần Thơ', 'Lâm Đồng'];
        $districts = ['Quận 1', 'Quận Cầu Giấy', 'Quận Hải Châu', 'Quận Ninh Kiều', 'TP. Đà Lạt'];
        $wards = ['Phường Bến Nghé', 'Phường Dịch Vọng', 'Phường Hòa Cường Bắc', 'Phường An Khánh', 'Phường 2'];
        $streets = ['12/3 Đường Lê Lợi', '45 Hàng Ngang', '102 Nguyễn Văn Linh', '78 Trần Hưng Đạo', '12 Bùi Thị Xuân'];

        foreach ($customerUsers as $user) {
            UserAddress::create([
                'user_id' => $user->id,
                'receiver_name' => $user->full_name,
                'receiver_phone' => $user->phone,
                'province' => $provinces[array_rand($provinces)],
                'district' => $districts[array_rand($districts)],
                'ward' => $wards[array_rand($wards)],
                'address_detail' => $streets[array_rand($streets)],
                'is_default' => true,
            ]);
        }

        // 4. Seed Colors & Sizes
        $colorsData = [
            ['name' => 'Trắng', 'hex_code' => '#FFFFFF'],
            ['name' => 'Đen', 'hex_code' => '#000000'],
            ['name' => 'Xám', 'hex_code' => '#808080'],
            ['name' => 'Be', 'hex_code' => '#F5F5DC'],
            ['name' => 'Xanh Bơ', 'hex_code' => '#568203'],
            ['name' => 'Hồng nhạt', 'hex_code' => '#FFB6C1'],
            ['name' => 'Xanh Đậm', 'hex_code' => '#00008B'],
            ['name' => 'Xanh Sáng', 'hex_code' => '#87CEEB'],
            ['name' => 'Xanh Navy', 'hex_code' => '#000080'],
            ['name' => 'Xanh Rêu', 'hex_code' => '#4F7942'],
            ['name' => 'Kem', 'hex_code' => '#FFFDD0'],
            ['name' => 'Nâu hạt dẻ', 'hex_code' => '#705335'],
            ['name' => 'Kem sữa', 'hex_code' => '#FFF7E6']
        ];
        $colors = [];
        foreach ($colorsData as $c) {
            $colors[$c['name']] = Color::create($c);
        }

        $sizesData = ['S', 'M', 'L', 'XL', 'XXL', '29', '30', '31', '32', '36', '37', '38', '39', '40', 'Free Size'];
        $sizes = [];
        foreach ($sizesData as $i => $s) {
            $sizes[$s] = Size::create(['name' => $s, 'sort_order' => $i]);
        }

        // 5. Seed Brands
        $brandsData = [
            ['name' => 'Beestyle', 'slug' => 'beestyle'],
            ['name' => 'Levi\'s', 'slug' => 'levis'],
            ['name' => 'Chanel', 'slug' => 'chanel'],
            ['name' => 'Uniqlo', 'slug' => 'uniqlo']
        ];
        $brands = [];
        foreach ($brandsData as $b) {
            $brands[$b['slug']] = Brand::create($b);
        }

        // 6. Seed Categories
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

        // 7. Seed Shipping Methods
        $shippingStandard = ShippingMethod::create([
            'code' => 'STANDARD',
            'name' => 'Giao Hàng Tiêu Chuẩn',
            'fee' => 20000.00,
            'estimated_days' => '3-5 ngày',
        ]);
        $shippingExpress = ShippingMethod::create([
            'code' => 'EXPRESS',
            'name' => 'Giao Hàng Hỏa Tốc (2H)',
            'fee' => 40000.00,
            'estimated_days' => '1-2 ngày',
        ]);

        // 8. Seed Vouchers
        $voucher1 = Voucher::create([
            'code' => 'BEESTYLE30',
            'name' => 'Giảm giá 30% cho khách hàng mới',
            'discount_type' => 'percent',
            'discount_value' => 30.00,
            'min_order_amount' => 200000.00,
            'max_discount_amount' => 100000.00,
            'usage_limit' => 1000,
            'usage_limit_per_user' => 1,
            'start_date' => now()->subDay(),
            'end_date' => now()->addYear(),
            'status' => 'Active',
        ]);

        $voucher2 = Voucher::create([
            'code' => 'BEESTYLE10',
            'name' => 'Giảm giá 10% trực tiếp đơn hàng',
            'discount_type' => 'percent',
            'discount_value' => 10.00,
            'min_order_amount' => 100000.00,
            'max_discount_amount' => 50000.00,
            'usage_limit' => 2000,
            'usage_limit_per_user' => 2,
            'start_date' => now()->subDay(),
            'end_date' => now()->addYear(),
            'status' => 'Active',
        ]);

        // 9. Seed Products & Variants
        $productsData = [
            [
                'category_slug' => 'shirt',
                'brand_slug' => 'beestyle',
                'name' => 'Áo thun Oversized Cotton Premium',
                'sku' => 'TSHIRT-OVS-COT',
                'price' => 350000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80',
                'description' => 'Chất liệu 100% cotton tự nhiên tuyển chọn, dệt mật độ cao giúp đứng dáng áo nhưng cực thoáng mát, thấm hút mồ hôi hiệu quả. Kiểu dáng phom rộng hiện đại dễ dàng phối đồ với quần jeans hoặc quần shorts.',
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Trắng', 'Đen', 'Xám']
            ],
            [
                'category_slug' => 'dress',
                'brand_slug' => 'beestyle',
                'name' => 'Váy midi Linen dịu dàng phong cách Pháp',
                'sku' => 'DRESS-MIDI-LINEN',
                'price' => 690000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600&auto=format&fit=crop&q=80',
                'description' => 'Đầm thiết kế dáng xòe cổ vuông thanh lịch, chi tiết chiết eo tinh tế giúp nâng dáng thon gọn. Chất liệu sợi lanh (linen) tự nhiên nhập khẩu siêu nhẹ và thoáng mát thích hợp cho những ngày đi biển hoặc dạo phố cuối tuần.',
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['Be', 'Xanh Bơ', 'Hồng nhạt']
            ],
            [
                'category_slug' => 'pants',
                'brand_slug' => 'levis',
                'name' => 'Quần Jeans Slim-fit Classic Xanh Đậm',
                'sku' => 'JEAN-SLIM-CLS',
                'price' => 520000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=600&auto=format&fit=crop&q=80',
                'description' => 'Dáng quần slim-fit ôm nhẹ khoe đôi chân thon gọn nhưng co giãn cực tốt nhờ sự kết hợp giữa sợi denim và spandex cao cấp. Thiết kế cổ điển 5 túi, đường may vô cùng chắc chắn và tinh tế.',
                'sizes' => ['29', '30', '31', '32'],
                'colors' => ['Xanh Đậm', 'Xanh Sáng', 'Đen']
            ],
            [
                'category_slug' => 'shirt',
                'brand_slug' => 'uniqlo',
                'name' => 'Áo sơ mi Lụa Ý Basic thanh lịch công sở',
                'sku' => 'SHIRT-SILK-ITALY',
                'price' => 450000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1603252109303-2751441dd157?w=600&auto=format&fit=crop&q=80',
                'description' => 'Áo sơ mi được thiết kế phom đứng nhẹ nhàng, chất vải dệt lụa bóng mờ cao cấp của Ý hạn chế tối đa nếp nhăn và cực nhẹ da. Một chiếc áo thích hợp cho ngày làm việc công sở lẫn dạo phố sang chảnh.',
                'sizes' => ['M', 'L', 'XL'],
                'colors' => ['Trắng', 'Xanh Navy', 'Đen']
            ],
            [
                'category_slug' => 'shirt',
                'brand_slug' => 'uniqlo',
                'name' => 'Áo khoác Bomber Jacket Gió 2 Lớp',
                'sku' => 'JACKET-BOMBER-WND',
                'price' => 750000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&auto=format&fit=crop&q=80',
                'description' => 'Chiếc khoác bomber đậm chất đường phố năng động sở hữu lớp vải ngoài chống gió và nước nhẹ, lớp lót trong lưới thông hơi tạo cảm giác mát mẻ. Khóa kéo đồng cao cấp siêu mượt, đường bo chun tay dày dặn ôm sát cổ tay.',
                'sizes' => ['M', 'L', 'XL', 'XXL'],
                'colors' => ['Đen', 'Xanh Rêu']
            ],
            [
                'category_slug' => 'dress',
                'brand_slug' => 'beestyle',
                'name' => 'Chân váy xếp ly dáng lửng trẻ trung',
                'sku' => 'SKIRT-PLEATED-PREPPY',
                'price' => 380000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=600&auto=format&fit=crop&q=80',
                'description' => 'Chân váy dáng xòe xếp nếp ly to đều đặn tinh tế theo phong cách Preppy năng động. Bên trong được may lót lớp quần bảo hộ thun cotton mềm chống hở, mang lại sự thoải mái tự tin khi di chuyển, hoạt động ngoài trời.',
                'sizes' => ['S', 'M', 'L'],
                'colors' => ['Kem', 'Đen']
            ],
            [
                'category_slug' => 'accessories',
                'brand_slug' => 'beestyle',
                'name' => 'Túi đeo vai Canvas Tote trơn rộng rãi',
                'sku' => 'ACC-TOTE-CANVAS',
                'price' => 250000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=600&auto=format&fit=crop&q=80',
                'description' => 'Được sản xuất thủ công từ chất vải thô mộc canvas organic siêu dày và chịu lực tốt. Ngăn chứa rộng rãi chứa vừa tài liệu A4, iPad, laptop cỡ nhỏ, thiết kế có cúc bấm kim loại và ngăn khóa phụ tiện dụng.',
                'sizes' => ['Free Size'],
                'colors' => ['Nâu hạt dẻ', 'Kem sữa']
            ],
            [
                'category_slug' => 'accessories',
                'brand_slug' => 'chanel',
                'name' => 'Sandal quai da ngang đế bệt êm chân',
                'sku' => 'ACC-SANDAL-LEATHER',
                'price' => 320000,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=600&auto=format&fit=crop&q=80',
                'description' => 'Mẫu giày xăng đan quai mảnh với chất da nhân tạo siêu mềm mịn không để lại vết tấy đỏ trên bàn chân. Phần đế kếp đúc cao su nhẹ cao cấp chống trượt, cho bạn sải bước vững chãi trên mọi địa hình trơn trượt.',
                'sizes' => ['36', '37', '38', '39', '40'],
                'colors' => ['Đen nhám', 'Kem sữa']
            ],
        ];

        $mockColorImages = [
            'Trắng' => 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?w=600&auto=format&fit=crop&q=80',
            'Đen' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=600&auto=format&fit=crop&q=80',
            'Đen nhám' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=600&auto=format&fit=crop&q=80',
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

        $products = [];
        $variants = [];

        foreach ($productsData as $pData) {
            $product = Product::create([
                'category_id' => $categories[$pData['category_slug']]->id,
                'brand_id' => $brands[$pData['brand_slug']]->id,
                'name' => $pData['name'],
                'slug' => Str::slug($pData['name']),
                'sku' => $pData['sku'],
                'short_description' => substr($pData['description'], 0, 100),
                'description' => $pData['description'],
                'base_price' => $pData['price'],
                'sale_price' => rand(1, 10) <= 3 ? $pData['price'] - 50000 : null,
                'gender' => 'Unisex',
                'status' => 'Active',
                'is_featured' => rand(0, 1) ? true : false,
                'published_at' => now(),
            ]);

            $products[] = $product;

            // Size Guide
            foreach ($pData['sizes'] as $szName) {
                ProductSizeGuide::create([
                    'product_id' => $product->id,
                    'size_id' => $sizes[$szName]->id,
                    'shoulder_cm' => rand(40, 52),
                    'chest_cm' => rand(90, 120),
                    'shirt_length_cm' => rand(65, 80),
                    'sleeve_length_cm' => rand(18, 65),
                    'height_min' => 150,
                    'height_max' => 185,
                    'weight_min' => 45,
                    'weight_max' => 85,
                ]);
            }

            // Variants, Primary Image & Color Images
            $primaryImageCreated = false;
            foreach ($pData['colors'] as $cIndex => $colName) {
                $colorModel = $colors[$colName] ?? Color::create(['name' => $colName, 'hex_code' => '#CCCCCC']);
                $imageUrl = $mockColorImages[$colName] ?? $pData['thumbnail_url'];

                // Add color-specific image
                ProductImage::create([
                    'product_id' => $product->id,
                    'color_id' => $colorModel->id,
                    'image_url' => $imageUrl,
                    'alt_text' => "{$product->name} màu {$colName}",
                    'is_primary' => !$primaryImageCreated,
                    'sort_order' => $cIndex,
                ]);
                if (!$primaryImageCreated) {
                    $primaryImageCreated = true;
                }

                foreach ($pData['sizes'] as $szName) {
                    $sizeModel = $sizes[$szName];
                    $vPriceOffset = $cIndex * 10000;
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'size_id' => $sizeModel->id,
                        'color_id' => $colorModel->id,
                        'sku' => "{$product->sku}-" . strtoupper(Str::slug($colName)) . "-{$szName}",
                        'price' => $product->base_price + $vPriceOffset,
                        'sale_price' => $product->sale_price ? $product->sale_price + $vPriceOffset : null,
                        'stock_quantity' => rand(50, 150),
                        'reserved_quantity' => 0,
                        'weight_gram' => rand(200, 500),
                        'status' => 'Active',
                    ]);

                    $variants[] = $variant;

                    // Log initial inventory
                    InventoryTransaction::create([
                        'product_variant_id' => $variant->id,
                        'type' => 'in',
                        'quantity' => $variant->stock_quantity,
                        'stock_before' => 0,
                        'stock_after' => $variant->stock_quantity,
                        'note' => 'Nhập kho hệ thống ban đầu',
                        'created_by' => $adminUser->id,
                    ]);
                }
            }
        }

        // 10. Seed Banners
        Banner::create([
            'title' => 'BST Hè 2026 rực rỡ',
            'image_url' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=1600&auto=format&fit=crop&q=80',
            'link_url' => '#/products?collection=bst-he-2026',
            'position' => 'home_slider',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        Banner::create([
            'title' => 'Ưu đãi thanh toán ngân hàng',
            'image_url' => 'https://images.unsplash.com/photo-1563013544-824ae1d704d3?w=1600&auto=format&fit=crop&q=80',
            'link_url' => '#/promotions',
            'position' => 'home_slider',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 11. Seed Settings
        Setting::create(['setting_key' => 'website_name', 'setting_value' => 'Beestyle E-Commerce', 'data_type' => 'string']);
        Setting::create(['setting_key' => 'hotline', 'setting_value' => '1900 1234', 'data_type' => 'string']);
        Setting::create(['setting_key' => 'address', 'setting_value' => '123 Đường Nguyễn Huệ, Quận 1, TP. HCM', 'data_type' => 'string']);

        // 12. Seed Blog Categories & Posts
        $blogCategory = BlogCategory::create(['name' => 'Xu hướng thời trang', 'slug' => 'trends']);
        BlogPost::create([
            'author_id' => $adminUser->id,
            'category_id' => $blogCategory->id,
            'title' => 'Mặc đẹp xuống phố Hè 2026',
            'slug' => 'mac-dep-xuong-pho-he-2026',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=600&auto=format&fit=crop&q=80',
            'content' => 'Thời trang mùa hè năm 2026 nổi bật với các thiết kế phom rộng oversized, gam màu tươi sáng ấm áp kết hợp chất liệu sợi tự nhiên thoáng mát...',
            'status' => 'Published',
            'published_at' => now(),
        ]);

        // 13. Seed Orders, Payments & Status Histories
        for ($i = 0; $i < 25; $i++) {
            $daysAgo = rand(1, 180);
            $createdAt = now()->subDays($daysAgo)->subHours(rand(1, 23))->subMinutes(rand(1, 59));
            $u = $customerUsers[array_rand($customerUsers)];
            $address = $u->addresses()->first();

            if ($daysAgo > 7) {
                $status = rand(1, 100) <= 85 ? 'Completed' : 'Cancelled';
            } else {
                $statuses = ['Completed', 'Shipping', 'Processing', 'Pending', 'Cancelled'];
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

            $paymentMethod = rand(1, 100) <= 70 ? 'cod' : 'bank';
            $shipping = rand(1, 100) <= 80 ? $shippingStandard : $shippingExpress;

            $order = Order::create([
                'user_id' => $u->id,
                'user_address_id' => $address ? $address->id : null,
                'shipping_method_id' => $shipping->id,
                'order_code' => 'ORD-' . strtoupper(Str::random(8)) . '-' . $i,
                'customer_name' => $u->full_name,
                'customer_phone' => $u->phone,
                'customer_email' => $u->email,
                'shipping_address_snapshot' => $address ? "{$address->receiver_name} - {$address->receiver_phone} | {$address->address_detail}, {$address->ward}, {$address->district}, {$address->province}" : 'N/A',
                'subtotal' => 0,
                'discount_amount' => 0,
                'shipping_fee' => $shipping->fee,
                'total_amount' => 0,
                'payment_method' => $paymentMethod,
                'payment_status' => 'Unpaid',
                'order_status' => $status,
                'note' => rand(0, 1) ? 'Vui lòng giao giờ hành chính' : null,
                'cancelled_reason' => $status === 'Cancelled' ? 'Khách hàng thay đổi ý định' : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Add Order Items
            $itemCount = rand(1, 3);
            $selectedVariants = (array) array_rand($variants, $itemCount);
            $subtotal = 0;

            foreach ($selectedVariants as $vKey) {
                $variant = $variants[$vKey];
                $prod = $variant->product;
                $qty = rand(1, 2);
                $vPrice = $variant->price;
                $vTotal = $vPrice * $qty;
                $subtotal += $vTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $prod->id,
                    'product_variant_id' => $variant->id,
                    'product_name_snapshot' => $prod->name,
                    'sku_snapshot' => $variant->sku,
                    'size_name_snapshot' => $variant->size->name,
                    'color_name_snapshot' => $variant->color->name,
                    'quantity' => $qty,
                    'price_at_purchase' => $vPrice,
                    'total_price' => $vTotal,
                    'created_at' => $createdAt,
                ]);

                // Reduce stock
                $variant->decrement('stock_quantity', $qty);
            }

            // Apply Voucher
            $discount = 0;
            $appliedVoucher = null;
            if ($subtotal >= 200000.00 && rand(1, 100) <= 40) {
                $appliedVoucher = $voucher1;
                $discount = ($subtotal * $voucher1->discount_value) / 100;
                if ($discount > $voucher1->max_discount_amount) {
                    $discount = $voucher1->max_discount_amount;
                }
            }

            $order->subtotal = $subtotal;
            $order->discount_amount = $discount;
            $order->total_amount = max(0, $subtotal - $discount + $shipping->fee);
            $order->voucher_id = $appliedVoucher ? $appliedVoucher->id : null;

            $paymentStatus = 'Unpaid';
            if ($paymentMethod === 'bank' || $status === 'Completed' || $status === 'Shipping') {
                $paymentStatus = 'Paid';
            }
            $order->payment_status = $paymentStatus;
            $order->save();

            // Voucher usages log
            if ($appliedVoucher) {
                VoucherUsage::create([
                    'voucher_id' => $appliedVoucher->id,
                    'user_id' => $u->id,
                    'order_id' => $order->id,
                    'discount_amount' => $discount,
                    'used_at' => $createdAt,
                ]);
                $appliedVoucher->increment('used_count');
            }

            // Shipments log
            Shipment::create([
                'order_id' => $order->id,
                'shipping_method_id' => $shipping->id,
                'carrier_name' => 'Beestyle Delivery',
                'tracking_code' => 'TRK-' . strtoupper(Str::random(10)),
                'shipping_status' => $status === 'Completed' ? 'Delivered' : ($status === 'Shipping' ? 'Shipped' : 'Pending'),
                'shipped_at' => $status === 'Completed' || $status === 'Shipping' ? $createdAt->addHour() : null,
                'delivered_at' => $status === 'Completed' ? $createdAt->addDays(2) : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Payment Transaction log
            if ($paymentStatus === 'Paid') {
                PaymentTransaction::create([
                    'order_id' => $order->id,
                    'method' => $paymentMethod,
                    'amount' => $order->total_amount,
                    'transaction_code' => 'TXN-' . strtoupper(Str::random(10)),
                    'status' => 'Success',
                    'paid_at' => $createdAt,
                    'created_at' => $createdAt,
                ]);
            }

            // Order status history
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'old_status' => 'None',
                'new_status' => 'Pending',
                'note' => 'Khách hàng khởi tạo đơn hàng thành công',
                'changed_by' => $u->id,
                'created_at' => $createdAt,
            ]);

            if ($status !== 'Pending') {
                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'old_status' => 'Pending',
                    'new_status' => $status,
                    'note' => 'Cập nhật trạng thái đơn hàng tự động',
                    'changed_by' => $adminUser->id,
                    'created_at' => $createdAt->addMinutes(30),
                ]);
            }

            // 14. Seed Reviews for completed orders occasionally
            if ($status === 'Completed' && rand(1, 100) <= 50) {
                $orderItem = $order->items()->first();
                if ($orderItem) {
                    $reviewComment = 'Sản phẩm chất lượng tuyệt vời, đường may sắc nét, giao hàng siêu nhanh!';
                    $review = Review::create([
                        'user_id' => $u->id,
                        'product_id' => $orderItem->product_id,
                        'order_item_id' => $orderItem->id,
                        'rating' => 5,
                        'comment' => $reviewComment,
                        'status' => 'Approved',
                    ]);

                    $imgUrl = $orderItem->product->images()->where('is_primary', true)->first()?->image_url 
                        ?? 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80';

                    ReviewImage::create([
                        'review_id' => $review->id,
                        'image_url' => $imgUrl,
                        'sort_order' => 1,
                    ]);
                }
            }
        }
    }
}
