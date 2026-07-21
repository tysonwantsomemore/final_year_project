<!doctype html>
<html lang="vi" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Beestyle - Thời Trang Cao Cấp &amp; Phong Cách</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&amp;family=DM+Sans:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
  <style>
    html, body { height: 100%; margin: 0; scroll-behavior: smooth; }
    .font-heading { font-family: 'Playfair Display', serif; }
    .font-body { font-family: 'DM Sans', sans-serif; }
    .product-card:hover .product-img { transform: scale(1.05); }
    .product-img { transition: transform 0.4s ease; }
    .nav-link { position: relative; }
    .nav-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: #c45e3a; transition: width 0.3s; }
    .nav-link:hover::after { width: 100%; }
    .active-nav-link::after { width: 100%; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp 0.6s ease forwards; }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #faf9f7; }
    ::-webkit-scrollbar-thumb { background: #e8e5e0; border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: #c45e3a; }
    /* Color Swatch active state animation */
    .color-swatch-active {
        box-shadow: 0 0 0 2px #ffffff, 0 0 0 4px #c45e3a;
        transform: scale(1.1);
    }
    /* Color Swatch active state animation */
    .color-swatch-active {
        box-shadow: 0 0 0 2px #ffffff, 0 0 0 4px #c45e3a;
        transform: scale(1.1);
    }
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full font-body bg-[#faf9f7] text-[#1a1a1a] flex flex-col overflow-x-hidden">

  <!-- Header -->
  <header class="sticky top-0 z-50 bg-[#faf9f7]/95 backdrop-blur-md border-b border-[#e8e5e0]">
   <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
    <a href="#/" id="brand-name" class="font-heading text-2xl font-bold tracking-tight text-[#1a1a1a] hover:text-[#c45e3a] transition flex items-center gap-2">
      <span class="text-3xl">🐝</span>Beestyle
    </a>
    
    <nav class="hidden md:flex gap-8 text-sm font-medium">
      <a href="#/" class="nav-link py-1 text-gray-700 hover:text-black transition" id="nav-home">Trang chủ</a> 
      <a href="#/shop" class="nav-link py-1 text-gray-700 hover:text-black transition" id="nav-shop">Cửa hàng</a> 
      <a href="#/orders" class="nav-link py-1 text-gray-700 hover:text-black transition" id="nav-orders">Đơn mua của tôi</a> 
      <a href="/admin" class="nav-link py-1 text-gray-700 hover:text-[#c45e3a] transition flex items-center gap-1 font-semibold text-[#c45e3a] hidden" id="nav-admin">
        <i data-lucide="shield-check" class="w-4 h-4"></i>Quản trị
      </a>
    </nav>
    
    <div class="flex items-center gap-3">
     <button class="relative p-2 hover:bg-[#e8e5e0] rounded-full transition" id="search-btn" title="Tìm kiếm">
       <i data-lucide="search" style="width:20px;height:20px;"></i>
     </button> 
     
     <a href="#/shop?wishlist=true" class="relative p-2 hover:bg-[#e8e5e0] rounded-full transition" id="wishlist-btn" title="Yêu thích">
       <i data-lucide="heart" style="width:20px;height:20px;" class="text-red-500 fill-transparent hover:fill-red-500 transition"></i>
       <span id="wishlist-count" class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold hidden">0</span>
     </a> 
     
     <button class="relative p-2 hover:bg-[#e8e5e0] rounded-full transition" id="cart-btn" title="Giỏ hàng"> 
       <i data-lucide="shopping-bag" style="width:20px;height:20px;"></i> 
       <span id="cart-count" class="absolute -top-0.5 -right-0.5 bg-[#c45e3a] text-white text-[10px] w-4.5 h-4.5 rounded-full flex items-center justify-center font-semibold">0</span> 
     </button> 

     <!-- Auth Button / Dropdown Container -->
     <div id="auth-header-container" class="relative z-50"></div>
     
     <button class="md:hidden p-2 hover:bg-[#e8e5e0] rounded-full transition" id="menu-btn" title="Menu">
       <i data-lucide="menu" style="width:20px;height:20px;"></i>
     </button>
    </div>
   </div>
   
   <!-- Mobile menu -->
   <div id="mobile-menu" class="hidden md:hidden border-t border-[#e8e5e0] bg-[#faf9f7] px-4 py-4 space-y-3 shadow-lg">
     <a href="#/" class="block text-sm font-medium py-2 border-b border-gray-100 hover:text-[#c45e3a]">Trang chủ</a> 
     <a href="#/shop" class="block text-sm font-medium py-2 border-b border-gray-100 hover:text-[#c45e3a]">Cửa hàng</a> 
     <a href="#/orders" class="block text-sm font-medium py-2 border-b border-gray-100 hover:text-[#c45e3a]">Đơn mua của tôi</a> 
     <a href="/admin" id="nav-admin-mobile" class="block text-sm font-semibold py-2 text-[#c45e3a] flex items-center gap-2 border-b border-gray-100 hidden">
        <i data-lucide="shield-check" class="w-4 h-4"></i>Quản trị Admin
      </a>
      <div id="mobile-auth-container" class="pt-2"></div>
    </div>
  </header>

  <!-- Search overlay -->
  <div id="search-overlay" class="hidden fixed inset-0 z-[60] bg-black/50 flex items-start justify-center pt-24 backdrop-blur-sm transition-all duration-300">
   <div class="bg-white rounded-2xl p-6 w-full max-w-xl mx-4 shadow-2xl scale-95 opacity-0 transition-all duration-300 transform" id="search-box">
    <div class="flex items-center gap-3 border-b border-[#e8e5e0] pb-4">
      <i data-lucide="search" style="width:22px;height:22px;color:#c45e3a;"></i> 
      <input type="text" placeholder="Tìm kiếm trang phục, phụ kiện..." class="flex-1 outline-none text-lg font-body placeholder-gray-400" id="search-input"> 
      <button id="close-search" class="p-1.5 hover:bg-gray-100 rounded-full transition"><i data-lucide="x" style="width:20px;height:20px;"></i></button>
    </div>
    <div class="mt-4">
      <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Từ khóa hot</p>
      <div class="flex flex-wrap gap-2" id="search-suggestions">
        <button onclick="quickSearch('Áo thun')" class="text-xs bg-[#f5f0ea] hover:bg-[#c45e3a] hover:text-white px-3 py-1.5 rounded-full text-gray-600 transition">Áo thun</button>
        <button onclick="quickSearch('Váy')" class="text-xs bg-[#f5f0ea] hover:bg-[#c45e3a] hover:text-white px-3 py-1.5 rounded-full text-gray-600 transition">Váy midi</button>
        <button onclick="quickSearch('Quần jeans')" class="text-xs bg-[#f5f0ea] hover:bg-[#c45e3a] hover:text-white px-3 py-1.5 rounded-full text-gray-600 transition">Quần jeans</button>
        <button onclick="quickSearch('Mới')" class="text-xs bg-[#f5f0ea] hover:bg-[#c45e3a] hover:text-white px-3 py-1.5 rounded-full text-gray-600 transition">Mới về</button>
      </div>
    </div>
    <div class="mt-4 border-t border-gray-100 pt-4 max-h-60 overflow-y-auto hidden" id="search-results-box">
      <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Kết quả tìm kiếm</p>
      <div id="search-results-list" class="space-y-2"></div>
    </div>
   </div>
  </div>

  <!-- Main Views Container -->
  <main class="flex-1">
    
    <!-- HOME VIEW -->
    <div id="home-view" class="page-view hidden">
      <!-- Hero Section -->
      <section class="relative overflow-hidden bg-gradient-to-br from-[#f5f0ea] via-[#faf9f7] to-[#e8dfd4] border-b border-[#e8e5e0]">
       <div class="max-w-7xl mx-auto px-4 py-16 md:py-24 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-6 text-center md:text-left z-10">
         <p class="text-xs uppercase tracking-[4px] text-[#c45e3a] font-bold">Bộ sưu tập thời thượng 2026</p>
         <h1 id="hero-title" class="font-heading text-4xl md:text-6xl font-bold leading-tight text-[#1a1a1a]">
           Nâng tầm<br><span class="text-[#c45e3a] italic">phong cách</span><br>của bạn
         </h1>
         <p id="hero-subtitle" class="text-gray-600 text-base md:text-lg max-w-lg mx-auto md:mx-0 font-light leading-relaxed">
           Thời trang cao cấp, tối giản nhưng đậm chất riêng. Hãy khám phá và tự tin tỏa sáng mỗi ngày cùng Beestyle.
         </p>
         <div class="flex flex-wrap justify-center md:justify-start gap-4">
           <a href="#/shop" class="bg-[#1a1a1a] text-white px-8 py-3.5 rounded-full font-medium hover:bg-[#c45e3a] transition shadow-lg shadow-[#1a1a1a]/10 hover:shadow-[#c45e3a]/20">Mua Ngay</a> 
           <a href="#/shop?tag=Mới" class="border-2 border-[#1a1a1a] px-8 py-3.5 rounded-full font-medium hover:bg-[#1a1a1a] hover:text-white transition">Hàng Mới Về</a>
         </div>
        </div>
        <div class="flex-1 flex justify-center relative w-full">
         <div class="absolute -top-10 -left-10 w-48 h-48 bg-[#c45e3a]/10 rounded-full blur-3xl"></div>
         <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-[#d4956b]/20 rounded-full blur-3xl"></div>
         <div class="w-72 h-96 md:w-96 md:h-[30rem] rounded-2xl overflow-hidden shadow-2xl relative border-4 border-white bg-white group">
          <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=600&auto=format&fit=crop&q=80" alt="Hero Fashion" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          <div class="absolute bottom-6 left-6 right-6 bg-white/95 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-gray-100 flex items-center justify-between">
            <div>
              <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Phong cách mùa xuân</p>
              <h4 class="font-heading font-bold text-gray-800 text-sm">BST Cotton &amp; Linen</h4>
            </div>
            <a href="#/shop" class="bg-[#1a1a1a] text-white p-2 rounded-full hover:bg-[#c45e3a] transition">
              <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
          </div>
         </div>
        </div>
       </div>
      </section>

      <!-- Categories Section -->
      <section class="max-w-7xl mx-auto px-4 py-16">
       <div class="text-center max-w-lg mx-auto mb-12">
         <h2 class="font-heading text-3xl font-bold mb-3">Danh Mục Nổi Bật</h2>
         <p class="text-gray-500 text-sm">Các thiết kế tinh tế được phân loại giúp bạn dễ dàng chọn lựa bộ trang phục phù hợp nhất</p>
       </div>
       <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <a href="#/shop?category=shirt" class="bg-[#f0ebe4] rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 cursor-pointer group flex flex-col items-center">
         <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-3xl group-hover:scale-110 transition-transform shadow-md">👕</div>
         <p class="font-semibold text-gray-800 mt-4 group-hover:text-[#c45e3a] transition">Áo Nam &amp; Nữ</p>
         <span class="text-xs text-gray-400 mt-1 font-medium hover:underline">Khám phá →</span>
        </a>
        <a href="#/shop?category=pants" class="bg-[#e4ecf0] rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 cursor-pointer group flex flex-col items-center">
         <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-3xl group-hover:scale-110 transition-transform shadow-md">👖</div>
         <p class="font-semibold text-gray-800 mt-4 group-hover:text-[#c45e3a] transition">Quần Jeans &amp; Tây</p>
         <span class="text-xs text-gray-400 mt-1 font-medium hover:underline">Khám phá →</span>
        </a>
        <a href="#/shop?category=dress" class="bg-[#f0e4ec] rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 cursor-pointer group flex flex-col items-center">
         <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-3xl group-hover:scale-110 transition-transform shadow-md">👗</div>
         <p class="font-semibold text-gray-800 mt-4 group-hover:text-[#c45e3a] transition">Váy Đầm Dạo Phố</p>
         <span class="text-xs text-gray-400 mt-1 font-medium hover:underline">Khám phá →</span>
        </a>
        <a href="#/shop?category=accessories" class="bg-[#ecf0e4] rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 cursor-pointer group flex flex-col items-center">
         <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-3xl group-hover:scale-110 transition-transform shadow-md">👜</div>
         <p class="font-semibold text-gray-800 mt-4 group-hover:text-[#c45e3a] transition">Phụ Kiện Cao Cấp</p>
         <span class="text-xs text-gray-400 mt-1 font-medium hover:underline">Khám phá →</span>
        </a>
       </div>
      </section>

      <!-- Promo Banner 1 -->
      <section class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-[#1a1a1a] rounded-3xl p-8 md:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
          <div class="absolute right-0 top-0 w-64 h-64 bg-[#c45e3a]/10 rounded-full blur-3xl"></div>
          <div class="z-10 text-center md:text-left">
            <span class="bg-[#c45e3a] text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Ưu Đãi Đặc Biệt</span>
            <h3 class="font-heading text-3xl md:text-4xl font-bold mt-3 mb-2">Giảm 30% khi thanh toán lần đầu</h3>
            <p class="text-gray-400 text-sm">Nhập mã ưu đãi tại màn hình thanh toán để được giảm trừ trực tiếp. Áp dụng cho giỏ hàng bất kỳ.</p>
            <div class="mt-4 flex items-center justify-center md:justify-start gap-2">
              <span class="text-xs text-gray-300">Mã code:</span>
              <span class="bg-white/10 text-[#d4956b] border border-white/20 px-3 py-1 rounded font-mono font-bold select-all">BEESTYLE30</span>
            </div>
          </div>
          <a href="#/shop" class="bg-white text-[#1a1a1a] px-8 py-4 rounded-full font-semibold hover:bg-[#c45e3a] hover:text-white transition z-10 whitespace-nowrap shadow-lg shadow-black/20">Mua Ngay Cửa Hàng</a>
        </div>
      </section>

      <!-- Featured Products -->
      <section class="max-w-7xl mx-auto px-4 py-16">
       <div class="flex items-center justify-between mb-10">
        <div>
          <h2 class="font-heading text-3xl font-bold text-gray-800">Sản Phẩm Nổi Bật</h2>
          <p class="text-gray-500 text-xs mt-1">Những sản phẩm được yêu thích và đánh giá tốt nhất trong tuần</p>
        </div>
        <a href="#/shop" class="text-sm font-semibold text-[#c45e3a] hover:underline flex items-center gap-1">Xem tất cả <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
       </div>
       <div class="grid grid-cols-2 md:grid-cols-4 gap-6" id="home-product-grid"></div>
      </section>

      <!-- Why Choose Us -->
      <section class="bg-[#f5f0ea]/50 border-t border-b border-[#e8e5e0] py-16 my-8">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center space-y-3">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-xl shadow mx-auto text-[#c45e3a]"><i data-lucide="truck" class="w-6 h-6"></i></div>
            <h4 class="font-semibold text-lg text-gray-800">Miễn Phí Vận Chuyển</h4>
            <p class="text-gray-500 text-sm max-w-xs mx-auto">Áp dụng cho mọi đơn hàng từ 500.000₫ trở lên trên phạm vi toàn quốc.</p>
          </div>
          <div class="text-center space-y-3">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-xl shadow mx-auto text-[#c45e3a]"><i data-lucide="refresh-cw" class="w-6 h-6"></i></div>
            <h4 class="font-semibold text-lg text-gray-800">Đổi Trả Dễ Dàng</h4>
            <p class="text-gray-500 text-sm max-w-xs mx-auto">Hỗ trợ đổi trả sản phẩm trong vòng 7 ngày nếu không vừa size hoặc có lỗi từ sản xuất.</p>
          </div>
          <div class="text-center space-y-3">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-xl shadow mx-auto text-[#c45e3a]"><i data-lucide="shield-check" class="w-6 h-6"></i></div>
            <h4 class="font-semibold text-lg text-gray-800">100% Chính Hãng</h4>
            <p class="text-gray-500 text-sm max-w-xs mx-auto">Cam kết mọi mặt hàng thời trang tại Beestyle đều do xưởng thiết kế và sản xuất tỉ mỉ.</p>
          </div>
        </div>
      </section>
    </div>

    <!-- SHOP VIEW -->
    <div id="shop-view" class="page-view hidden">
      <div class="bg-[#f0ebe4]/40 border-b border-[#e8e5e0] py-8 mb-8">
        <div class="max-w-7xl mx-auto px-4">
          <h1 class="font-heading text-3xl font-bold text-gray-800" id="shop-title">Cửa Hàng Thời Trang</h1>
          <p class="text-gray-500 text-sm mt-1" id="shop-subtitle">Khám phá các thiết kế chất lượng cao phù hợp với phong cách của bạn.</p>
        </div>
      </div>
      
      <div class="max-w-7xl mx-auto px-4 pb-16 flex flex-col md:flex-row gap-8">
        <!-- Sidebar filters -->
        <aside class="w-full md:w-64 shrink-0 space-y-6">
          <div class="bg-white rounded-2xl p-5 border border-[#e8e5e0] shadow-sm space-y-6">
            <!-- Search field inside sidebar (responsive) -->
            <div class="space-y-2">
              <h4 class="font-semibold text-sm text-gray-800">Tìm kiếm</h4>
              <div class="relative">
                <input type="text" id="shop-search-input" placeholder="Từ khóa..." class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-2.5"></i>
              </div>
            </div>
            
            <!-- Category Filter -->
            <div class="space-y-2">
              <h4 class="font-semibold text-sm text-gray-800">Danh mục sản phẩm</h4>
              <div class="space-y-1" id="category-filter-list">
                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-black cursor-pointer py-1">
                  <input type="radio" name="category" value="all" checked class="accent-[#c45e3a]"> Tất cả sản phẩm
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-black cursor-pointer py-1">
                  <input type="radio" name="category" value="shirt" class="accent-[#c45e3a]"> Áo Nam & Nữ
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-black cursor-pointer py-1">
                  <input type="radio" name="category" value="pants" class="accent-[#c45e3a]"> Quần Jeans & Tây
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-black cursor-pointer py-1">
                  <input type="radio" name="category" value="dress" class="accent-[#c45e3a]"> Váy Đầm Dạo Phố
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-black cursor-pointer py-1">
                  <input type="radio" name="category" value="accessories" class="accent-[#c45e3a]"> Phụ kiện
                </label>
              </div>
            </div>
            
            <!-- Price Range Filter -->
            <div class="space-y-2">
              <h4 class="font-semibold text-sm text-gray-800">Khoảng giá (₫)</h4>
              <div class="space-y-2">
                <input type="range" id="price-range" min="0" max="1500000" step="50000" value="1500000" class="w-full accent-[#c45e3a]">
                <div class="flex justify-between text-xs text-gray-500 font-semibold">
                  <span>0đ</span>
                  <span id="price-range-val">Dưới 1.500.000₫</span>
                </div>
              </div>
            </div>
            
            <!-- Tags/Badges filter -->
            <div class="space-y-2">
              <h4 class="font-semibold text-sm text-gray-800">Khác</h4>
              <div class="flex flex-wrap gap-2">
                <button id="filter-tag-new" class="text-xs bg-[#f5f0ea] hover:bg-[#c45e3a] hover:text-white px-2.5 py-1.5 rounded-lg text-gray-600 transition">Hàng Mới</button>
                <button id="filter-tag-sale" class="text-xs bg-[#f5f0ea] hover:bg-[#c45e3a] hover:text-white px-2.5 py-1.5 rounded-lg text-gray-600 transition">Khuyến Mại</button>
                <button id="filter-wishlist" class="text-xs bg-[#f5f0ea] hover:bg-red-500 hover:text-white px-2.5 py-1.5 rounded-lg text-gray-600 transition flex items-center gap-1">
                  <i data-lucide="heart" class="w-3 h-3 text-red-500 fill-current"></i>Đang Thích
                </button>
              </div>
            </div>
            
            <button id="reset-filters" class="w-full text-center py-2 text-xs font-semibold border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-black rounded-xl transition">Xóa bộ lọc</button>
          </div>
        </aside>
        
        <!-- Products list & sorting -->
        <div class="flex-1 space-y-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 rounded-2xl border border-[#e8e5e0] shadow-sm">
            <p class="text-sm text-gray-500 font-medium" id="product-count-text">Hiển thị 0 sản phẩm</p>
            <div class="flex items-center gap-2 text-sm">
              <span class="text-gray-400 font-medium">Sắp xếp:</span>
              <select id="sort-select" class="border border-gray-200 rounded-xl px-3 py-1.5 outline-none focus:border-[#c45e3a] transition bg-white text-gray-700 font-semibold cursor-pointer">
                <option value="default">Mặc định</option>
                <option value="price-asc">Giá: Thấp đến Cao</option>
                <option value="price-desc">Giá: Cao đến Thấp</option>
                <option value="rating-desc">Đánh giá tốt nhất</option>
              </select>
            </div>
          </div>
          
          <!-- Product grid -->
          <div class="grid grid-cols-2 md:grid-cols-3 gap-6" id="shop-product-grid"></div>
          
          <!-- Empty State -->
          <div id="shop-empty-state" class="hidden flex flex-col items-center justify-center py-16 bg-white rounded-3xl border border-[#e8e5e0] text-center p-6">
            <span class="text-5xl">🔍</span>
            <h3 class="font-heading font-bold text-xl text-gray-800 mt-4">Không tìm thấy sản phẩm nào</h3>
            <p class="text-gray-400 text-sm max-w-sm mt-2">Vui lòng thử tìm kiếm với từ khóa khác hoặc điều chỉnh lại bộ lọc để tìm sản phẩm.</p>
            <button onclick="resetAllFilters()" class="bg-[#1a1a1a] text-white text-xs font-semibold px-6 py-2.5 rounded-full mt-4 hover:bg-[#c45e3a] transition">Xem tất cả</button>
          </div>
        </div>
      </div>
    </div>

    <!-- PRODUCT DETAIL VIEW -->
    <div id="product-detail-view" class="page-view hidden max-w-7xl mx-auto px-4 py-8 md:py-16">
      <a href="#/shop" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-black mb-8 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Quay lại cửa hàng
      </a>
      
      <div id="product-detail-content"></div>
      
      <!-- Reviews and comments -->
      <div class="mt-16 bg-white rounded-3xl p-6 md:p-8 border border-[#e8e5e0] shadow-sm">
        <h3 class="font-heading text-2xl font-bold text-gray-800 mb-6">Nhận xét từ Khách Hàng</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
          <!-- Rating Summary -->
          <div class="bg-[#faf9f7] p-6 rounded-3xl text-center flex flex-col items-center justify-center border border-gray-100 shadow-sm">
            <span class="text-5xl font-bold text-[#c45e3a]" id="detail-avg-rating">4.8</span>
            <div class="flex items-center gap-0.5 my-2.5" id="detail-avg-stars"></div>
            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider" id="detail-review-count">Dựa trên 0 đánh giá</p>
          </div>
          
          <!-- Rating Statistics Bars -->
          <div class="flex flex-col justify-center space-y-2 bg-gray-50/50 p-5 rounded-3xl border border-gray-100/50">
            <!-- 5 Star Bar -->
            <div class="flex items-center gap-2 text-xs">
              <span class="w-3 font-bold text-gray-600">5</span>
              <i data-lucide="star" class="w-3.5 h-3.5 text-amber-400 fill-current shrink-0"></i>
              <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div id="bar-5-star" class="h-full bg-amber-400 rounded-full transition-all duration-500" style="width: 0%;"></div>
              </div>
              <span id="pct-5-star" class="w-8 text-right font-semibold text-gray-400">0%</span>
            </div>
            <!-- 4 Star Bar -->
            <div class="flex items-center gap-2 text-xs">
              <span class="w-3 font-bold text-gray-600">4</span>
              <i data-lucide="star" class="w-3.5 h-3.5 text-amber-400 fill-current shrink-0"></i>
              <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div id="bar-4-star" class="h-full bg-amber-400 rounded-full transition-all duration-500" style="width: 0%;"></div>
              </div>
              <span id="pct-4-star" class="w-8 text-right font-semibold text-gray-400">0%</span>
            </div>
            <!-- 3 Star Bar -->
            <div class="flex items-center gap-2 text-xs">
              <span class="w-3 font-bold text-gray-600">3</span>
              <i data-lucide="star" class="w-3.5 h-3.5 text-amber-400 fill-current shrink-0"></i>
              <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div id="bar-3-star" class="h-full bg-amber-400 rounded-full transition-all duration-500" style="width: 0%;"></div>
              </div>
              <span id="pct-3-star" class="w-8 text-right font-semibold text-gray-400">0%</span>
            </div>
            <!-- 2 Star Bar -->
            <div class="flex items-center gap-2 text-xs">
              <span class="w-3 font-bold text-gray-600">2</span>
              <i data-lucide="star" class="w-3.5 h-3.5 text-amber-400 fill-current shrink-0"></i>
              <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div id="bar-2-star" class="h-full bg-amber-400 rounded-full transition-all duration-500" style="width: 0%;"></div>
              </div>
              <span id="pct-2-star" class="w-8 text-right font-semibold text-gray-400">0%</span>
            </div>
            <!-- 1 Star Bar -->
            <div class="flex items-center gap-2 text-xs">
              <span class="w-3 font-bold text-gray-600">1</span>
              <i data-lucide="star" class="w-3.5 h-3.5 text-amber-400 fill-current shrink-0"></i>
              <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div id="bar-1-star" class="h-full bg-amber-400 rounded-full transition-all duration-500" style="width: 0%;"></div>
              </div>
              <span id="pct-1-star" class="w-8 text-right font-semibold text-gray-400">0%</span>
            </div>
          </div>
          
          <!-- Submit Review Form -->
          <form id="review-form" class="md:col-span-1 lg:col-span-2 space-y-4">
            <h4 class="font-semibold text-base text-gray-800">Viết đánh giá của bạn</h4>
            <div class="flex items-center gap-2">
              <span class="text-sm text-gray-500 font-medium">Đánh giá sao:</span>
              <div class="flex gap-1" id="star-rating-select">
                <button type="button" data-rating="1" class="text-gray-300 hover:text-amber-400 transition"><i data-lucide="star" class="w-6 h-6 fill-current"></i></button>
                <button type="button" data-rating="2" class="text-gray-300 hover:text-amber-400 transition"><i data-lucide="star" class="w-6 h-6 fill-current"></i></button>
                <button type="button" data-rating="3" class="text-gray-300 hover:text-amber-400 transition"><i data-lucide="star" class="w-6 h-6 fill-current"></i></button>
                <button type="button" data-rating="4" class="text-gray-300 hover:text-amber-400 transition"><i data-lucide="star" class="w-6 h-6 fill-current"></i></button>
                <button type="button" data-rating="5" class="text-gray-300 hover:text-amber-400 transition"><i data-lucide="star" class="w-6 h-6 fill-current"></i></button>
              </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <input type="text" id="review-name" placeholder="Tên của bạn" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
              <input type="email" id="review-email" placeholder="Email (bảo mật)" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
            </div>
            <textarea id="review-comment" placeholder="Bạn cảm nhận thế nào về kiểu dáng, chất liệu sản phẩm này?" required rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm"></textarea>
            <button type="submit" class="bg-[#1a1a1a] text-white px-6 py-2.5 rounded-full text-xs font-semibold hover:bg-[#c45e3a] transition shadow-md">Gửi nhận xét</button>
          </form>
        </div>
        
        <!-- Comments list -->
        <div class="mt-8 border-t border-gray-100 pt-8 space-y-6" id="product-reviews-list"></div>
      </div>

      <!-- Related Products -->
      <div class="mt-16">
        <h3 class="font-heading text-2xl font-bold text-gray-800 mb-8">Có Thể Bạn Sẽ Thích</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6" id="related-product-grid"></div>
      </div>
    </div>

    <!-- CART VIEW -->
    <div id="cart-view" class="page-view hidden max-w-7xl mx-auto px-4 py-8 md:py-16">
      <h1 class="font-heading text-3xl font-bold text-gray-800 mb-8">Giỏ Hàng Của Bạn</h1>
      <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items Table -->
        <div class="flex-1 space-y-4" id="cart-items-wrapper"></div>
        
        <!-- Order Summary Card -->
        <aside class="w-full lg:w-96 shrink-0" id="cart-summary-wrapper"></aside>
      </div>
    </div>

    <!-- CHECKOUT VIEW -->
    <div id="checkout-view" class="page-view hidden max-w-7xl mx-auto px-4 py-8 md:py-16">
      <h1 class="font-heading text-3xl font-bold text-gray-800 mb-8">Thông Tin Thanh Toán</h1>
      <div class="flex flex-col lg:flex-row gap-8">
        <!-- Checkout Form -->
        <form id="checkout-form" class="flex-1 bg-white rounded-3xl p-6 md:p-8 border border-[#e8e5e0] shadow-sm space-y-6">
          <div class="space-y-4">
            <h3 class="font-semibold text-lg text-gray-800 border-b border-gray-100 pb-2">Thông tin giao hàng</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="text-xs font-semibold text-gray-500">Họ và tên *</label>
                <input type="text" id="checkout-name" placeholder="Nguyễn Văn A" required class="w-full px-4 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
              </div>
              <div class="space-y-1">
                <label class="text-xs font-semibold text-gray-500">Số điện thoại *</label>
                <input type="tel" id="checkout-phone" placeholder="0901234567" required class="w-full px-4 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
              </div>
            </div>
            <div class="space-y-1">
              <label class="text-xs font-semibold text-gray-500">Địa chỉ chi tiết (Số nhà, Tên đường, Quận, Thành phố) *</label>
              <input type="text" id="checkout-address" placeholder="123 Đường Nguyễn Huệ, Quận 1, TP. HCM" required class="w-full px-4 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
            </div>
            <div class="space-y-1">
              <label class="text-xs font-semibold text-gray-500">Ghi chú giao hàng (Không bắt buộc)</label>
              <textarea id="checkout-note" placeholder="Giao giờ hành chính, gọi trước khi giao..." rows="2" class="w-full px-4 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm"></textarea>
            </div>
          </div>
          
          <div class="space-y-4">
            <h3 class="font-semibold text-lg text-gray-800 border-b border-gray-100 pb-2">Phương thức thanh toán</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
              <label class="flex items-center justify-between p-4 border border-gray-200 hover:border-[#c45e3a] rounded-2xl cursor-pointer transition">
                <span class="flex items-center gap-3">
                  <span class="text-xl">💵</span>
                  <span class="text-sm font-semibold text-gray-700">Thanh toán khi nhận hàng (COD)</span>
                </span>
                <input type="radio" name="payment-method" value="cod" checked class="accent-[#c45e3a]">
              </label>
              <label class="flex items-center justify-between p-4 border border-gray-200 hover:border-[#c45e3a] rounded-2xl cursor-pointer transition">
                <span class="flex items-center gap-3">
                  <span class="text-xl">💳</span>
                  <span class="text-sm font-semibold text-gray-700">Chuyển khoản ngân hàng</span>
                </span>
                <input type="radio" name="payment-method" value="bank" class="accent-[#c45e3a]">
              </label>
              <label class="flex items-center justify-between p-4 border border-gray-200 hover:border-[#c45e3a] rounded-2xl cursor-pointer transition">
                <span class="flex items-center gap-3">
                  <span class="text-xl">⚡</span>
                  <span class="text-sm font-semibold text-gray-700">Thanh toán Online (VNPAY/MoMo)</span>
                </span>
                <input type="radio" name="payment-method" value="online_vnpay" class="accent-[#c45e3a]">
              </label>
            </div>
            
            <div id="bank-info" class="hidden bg-[#faf9f7] border border-dashed border-gray-200 p-4 rounded-2xl text-xs space-y-2">
              <p class="font-bold text-gray-700">Thông tin tài khoản ngân hàng:</p>
              <p>Ngân hàng: Techcombank</p>
              <p>Chủ tài khoản: CONG TY BEESTYLE VIET NAM</p>
              <p>Số tài khoản: 1903456789012</p>
              <p class="text-red-500 font-medium">Nội dung chuyển khoản: BEESTYLE + [Số điện thoại của bạn]</p>
            </div>
          </div>
          
          <button type="submit" class="w-full bg-[#1a1a1a] hover:bg-[#c45e3a] text-white py-4 rounded-full font-bold shadow-lg transition">Xác Nhận Đặt Hàng</button>
        </form>
        
        <!-- Summary items checkout -->
        <aside class="w-full lg:w-96 shrink-0 bg-white rounded-3xl p-6 border border-[#e8e5e0] shadow-sm space-y-4 h-fit">
          <h3 class="font-semibold text-lg text-gray-800 border-b border-gray-100 pb-2">Đơn hàng của bạn</h3>
          <div id="checkout-items-list" class="divide-y divide-gray-100 max-h-60 overflow-y-auto"></div>
          
          <!-- Voucher Section in Checkout -->
          <div class="border-t border-gray-100 pt-4 space-y-2">
            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Mã giảm giá</label>
            <div class="flex gap-2">
              <input type="text" id="checkout-voucher-input" placeholder="Nhập mã code..." class="flex-1 px-4 py-2 text-sm border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] uppercase font-mono">
              <button type="button" onclick="applyCheckoutVoucherCode()" class="bg-[#1a1a1a] hover:bg-[#c45e3a] text-white text-xs font-semibold px-4 py-2 rounded-xl transition">Áp dụng</button>
            </div>
            <div id="checkout-voucher-status"></div>
          </div>

          <div class="border-t border-gray-200 pt-4 space-y-2 text-sm" id="checkout-summary-calc"></div>
        </aside>
      </div>
    </div>

    <!-- ORDERS VIEW (Order Purchase History) -->
    <div id="orders-view" class="page-view hidden max-w-7xl mx-auto px-4 py-8 md:py-16">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="font-heading text-3xl font-bold text-gray-800">Lịch Sử Mua Hàng</h1>
          <p class="text-gray-500 text-sm mt-1">Quản lý và tra cứu các đơn hàng đã đặt của bạn</p>
        </div>
        <button onclick="clearOrderHistory()" class="text-xs text-red-500 hover:text-red-700 font-semibold border border-red-200 hover:bg-red-50 px-3 py-2 rounded-xl transition">Xóa lịch sử đơn hàng</button>
      </div>
      
      <div id="orders-list-container" class="space-y-6"></div>
    </div>

    <!-- PROFILE VIEW (User Settings) -->
    <div id="profile-view" class="page-view hidden max-w-2xl mx-auto px-4 py-8 md:py-16">
      <div class="bg-white rounded-3xl p-6 md:p-8 border border-[#e8e5e0] shadow-sm space-y-6">
        <div>
          <h1 class="font-heading text-2xl font-bold text-gray-800">Thông Tin Tài Khoản</h1>
          <p class="text-xs text-gray-400 mt-1">Cập nhật thông tin cá nhân và thay đổi mật khẩu của bạn.</p>
        </div>
        <form id="profile-form" class="space-y-4 text-xs" onsubmit="handleProfileUpdate(event)">
          <div class="space-y-1.5">
            <label class="font-bold text-gray-500 uppercase tracking-wider">Họ và tên *</label>
            <input type="text" id="profile-name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
          </div>
          <div class="space-y-1.5">
            <label class="font-bold text-gray-500 uppercase tracking-wider">Email (Không thể sửa)</label>
            <input type="email" id="profile-email" disabled class="w-full px-4 py-2.5 border border-gray-100 bg-gray-50 rounded-xl outline-none text-sm text-gray-400 cursor-not-allowed">
          </div>
          <div class="space-y-1.5">
            <label class="font-bold text-gray-500 uppercase tracking-wider">Số điện thoại</label>
            <input type="tel" id="profile-phone" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
          </div>
          <div class="space-y-1.5">
            <label class="font-bold text-gray-500 uppercase tracking-wider">Mật khẩu mới (Bỏ trống nếu không đổi)</label>
            <input type="password" id="profile-password" placeholder="Tối thiểu 6 ký tự" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
          </div>
          <button type="submit" class="w-full bg-[#1a1a1a] hover:bg-[#c45e3a] text-white py-3.5 rounded-full text-xs font-bold shadow-lg transition">Cập Nhật Thông Tin</button>
        </form>
      </div>
    </div>

    <!-- ORDER DETAIL VIEW -->
    <div id="order-detail-view" class="page-view hidden max-w-4xl mx-auto px-4 py-8 md:py-16">
      <a href="#/orders" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-black mb-6 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Quay lại đơn hàng
      </a>
      
      <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-200 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-gray-100 pb-4 gap-2">
          <div>
            <h2 class="font-heading text-2xl font-bold text-gray-800">Chi tiết đơn hàng: <span class="font-mono text-[#c45e3a]" id="cust-order-id"></span></h2>
            <p class="text-xs text-gray-400 mt-1 font-semibold" id="cust-order-date"></p>
          </div>
          <span class="text-xs px-3 py-1 rounded-full font-semibold" id="cust-order-status"></span>
        </div>

        <div class="py-4">
          <div class="flex items-center justify-between w-full max-w-2xl mx-auto text-[10px] font-bold text-gray-400 relative" id="cust-order-stepper">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
          <div class="space-y-2 bg-[#faf9f7] p-5 rounded-2xl border border-gray-100">
            <h4 class="font-bold text-sm text-gray-800">Thông tin giao hàng</h4>
            <div class="space-y-1.5 text-xs text-gray-600 font-light mt-2">
              <p>👤 Người nhận: <span class="font-semibold text-gray-800" id="cust-order-name"></span></p>
              <p>📞 Điện thoại: <span class="font-semibold text-gray-800" id="cust-order-phone"></span></p>
              <p>🏠 Địa chỉ: <span class="font-semibold text-gray-800" id="cust-order-address"></span></p>
              <p>✉️ Ghi chú: <span class="font-semibold text-gray-800" id="cust-order-note"></span></p>
            </div>
          </div>
          
          <div class="space-y-2 bg-[#faf9f7] p-5 rounded-2xl border border-gray-100">
            <h4 class="font-bold text-sm text-gray-800">Thông tin thanh toán</h4>
            <div class="space-y-1.5 text-xs text-gray-600 font-light mt-2">
              <p>💳 Phương thức: <span class="font-semibold text-gray-800 uppercase" id="cust-order-payment-method"></span></p>
              <p>💸 Trạng thái: <span class="font-semibold text-gray-800" id="cust-order-payment-status"></span></p>
            </div>
          </div>
        </div>

        <div class="space-y-3 pt-4 border-t border-gray-100">
          <h4 class="font-bold text-sm text-gray-800">Sản phẩm đã chọn</h4>
          <div class="divide-y divide-gray-100 mt-2" id="cust-order-items-tbody">
          </div>
        </div>

        <div class="border-t border-gray-100 pt-4 flex flex-col items-end space-y-1.5 text-xs">
          <div class="flex justify-between w-full max-w-[280px] text-gray-500 font-light">
            <span>Tạm tính:</span>
            <span class="font-semibold text-gray-800" id="cust-order-subtotal"></span>
          </div>
          <div class="flex justify-between w-full max-w-[280px] text-gray-500 font-light">
            <span>Giảm giá (Voucher):</span>
            <span class="font-semibold text-gray-800" id="cust-order-discount"></span>
          </div>
          <div class="flex justify-between w-full max-w-[280px] text-sm font-bold text-gray-800 border-t border-gray-100 pt-2">
            <span>Tổng thanh toán:</span>
            <span class="text-lg text-[#c45e3a]" id="cust-order-total"></span>
          </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-gray-100 hidden" id="cust-order-action-div">
          <button onclick="cancelClientOrderFromDetails()" class="text-xs text-red-500 hover:text-red-700 font-semibold border border-red-100 hover:bg-red-50 px-5 py-2.5 rounded-xl transition">Hủy đơn hàng này</button>
        </div>
      </div>
    </div>

  </main>

  <!-- Footer -->
  <footer class="bg-[#1a1a1a] text-white mt-16 border-t border-white/10 shrink-0">
   <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
    <div>
     <h4 class="font-heading text-xl font-bold mb-4 tracking-wider flex items-center gap-2"><span class="text-2xl">🐝</span>Beestyle</h4>
     <p class="text-gray-400 text-sm leading-relaxed font-light">Thời trang hiện đại cho cuộc sống năng động. Tinh hoa dệt may Việt Nam kết hợp phong cách tối giản quốc tế.</p>
    </div>
    <div>
     <h5 class="font-semibold mb-4 text-sm tracking-widest uppercase">Trang mua sắm</h5>
     <ul class="space-y-2 text-sm text-gray-400">
      <li><a href="#/" class="hover:text-white transition">Trang chủ</a></li>
      <li><a href="#/shop" class="hover:text-white transition">Cửa hàng sản phẩm</a></li>
      <li><a href="#/orders" class="hover:text-white transition">Đơn hàng của bạn</a></li>
      <li><a href="/admin" class="text-[#c45e3a] hover:underline font-semibold transition">Trang quản trị Admin</a></li>
     </ul>
    </div>
    <div>
     <h5 class="font-semibold mb-4 text-sm tracking-widest uppercase">Hỗ trợ khách hàng</h5>
     <ul class="space-y-2 text-sm text-gray-400">
      <li><a href="#/" class="hover:text-white transition">Chính sách đổi trả 7 ngày</a></li>
      <li><a href="#/" class="hover:text-white transition">Chính sách vận chuyển &amp; COD</a></li>
      <li><a href="#/" class="hover:text-white transition">Hướng dẫn chọn size chi tiết</a></li>
      <li><a href="#/" class="hover:text-white transition">Câu hỏi thường gặp FAQ</a></li>
     </ul>
    </div>
    <div>
     <h5 class="font-semibold mb-4 text-sm tracking-widest uppercase">Thông tin liên hệ</h5>
     <ul class="space-y-2 text-sm text-gray-400 font-light">
      <li>📍 123 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh</li>
      <li>📞 Hotline: 0909 123 456 (8h00 - 21h00)</li>
      <li>✉️ Email: hello@beestyle.vn</li>
     </ul>
     <div class="flex gap-3 mt-4">
       <a href="#" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#c45e3a] hover:scale-105 transition"><i data-lucide="facebook" style="width:16px;height:16px;"></i></a> 
       <a href="#" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#c45e3a] hover:scale-105 transition"><i data-lucide="instagram" style="width:16px;height:16px;"></i></a> 
       <a href="#" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#c45e3a] hover:scale-105 transition"><i data-lucide="twitter" style="width:16px;height:16px;"></i></a>
     </div>
    </div>
   </div>
   <div class="border-t border-white/5 text-center py-6 text-xs text-gray-500 font-light">
    © 2026 Beestyle Fashion &amp; E-commerce. Powered by Laravel &amp; SQLite.
   </div>
  </footer>

  <!-- Online Payment Simulation Modal -->
  <div id="online-payment-modal" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeOnlinePaymentModal()"></div>
    <div class="bg-white rounded-3xl p-6 md:p-8 w-full max-w-md shadow-2xl relative z-10 border border-gray-100 text-center space-y-6">
      <div>
        <span class="text-4xl block animate-bounce mb-2">⚡</span>
        <h3 class="font-heading text-xl font-bold text-gray-800">Cổng Thanh Toán Giả Lập</h3>
        <p class="text-xs text-gray-400 mt-1">Hệ thống mô phỏng giao dịch VNPAY / MoMo</p>
      </div>

      <div class="bg-[#faf9f7] p-5 rounded-2xl border border-gray-200/80 space-y-3">
        <div class="flex justify-between text-xs text-gray-500">
          <span>Đơn hàng tại Beestyle</span>
          <span class="font-semibold text-gray-800" id="online-payment-order-id">#temp</span>
        </div>
        <div class="flex justify-between text-xs text-gray-500 border-t border-gray-200/50 pt-2">
          <span>Số tiền cần thanh toán:</span>
          <span class="text-base font-bold text-[#c45e3a]" id="online-payment-amount">0₫</span>
        </div>
      </div>

      <!-- QR Code Simulation -->
      <div class="flex flex-col items-center justify-center p-4 bg-white border border-gray-100 rounded-2xl shadow-inner w-56 h-56 mx-auto relative group">
        <img src="https://images.unsplash.com/photo-1595079676339-1534801ad6cf?w=400&auto=format&fit=crop&q=80" alt="QR Code" class="w-44 h-44 object-cover filter blur-[0.5px] group-hover:blur-0 transition duration-300">
        <div class="absolute inset-0 bg-black/5 rounded-2xl pointer-events-none"></div>
      </div>

      <p class="text-xs text-gray-500 leading-relaxed font-light font-sans">Vui lòng bấm <strong>Xác nhận thanh toán</strong> để giả lập giao dịch thành công. Hoặc <strong>Hủy giao dịch</strong> để quay lại trang thanh toán.</p>

      <div class="text-xs text-amber-600 font-semibold bg-amber-50 py-2 rounded-xl" id="online-payment-timer">
        Giao dịch hết hạn sau: 05:00
      </div>

      <div class="grid grid-cols-2 gap-3 pt-2">
        <button onclick="confirmOnlinePayment()" class="bg-[#1a1a1a] hover:bg-emerald-600 text-white py-3 rounded-full text-xs font-bold shadow-lg transition">Xác nhận thanh toán</button>
        <button onclick="closeOnlinePaymentModal()" class="border border-gray-200 hover:bg-gray-50 text-gray-500 py-3 rounded-full text-xs font-bold transition">Hủy giao dịch</button>
      </div>
    </div>
  </div>

  <!-- Auth Modal -->
  <div id="auth-modal" class="fixed inset-0 z-[70] hidden flex items-center justify-center p-4 transition-all duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeAuthModal()"></div>
    <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 md:p-8 w-full max-w-md shadow-2xl relative z-10 border border-white/20 transform scale-95 opacity-0 transition-all duration-300" id="auth-modal-box">
      <!-- Close button -->
      <button onclick="closeAuthModal()" class="absolute top-4 right-4 p-2 hover:bg-gray-100 rounded-full transition text-gray-400 hover:text-black">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>

      <!-- Tabs -->
      <div class="flex border-b border-gray-100 pb-3 mb-6">
        <button onclick="switchAuthTab('login')" id="tab-login-btn" class="flex-1 text-center py-2 text-sm font-bold border-b-2 border-[#c45e3a] text-black transition">Đăng Nhập</button>
        <button onclick="switchAuthTab('register')" id="tab-register-btn" class="flex-1 text-center py-2 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-black transition">Đăng Ký</button>
      </div>

      <!-- Login Form -->
      <form id="login-form" class="space-y-4" onsubmit="handleLoginSubmit(event)">
        <div class="space-y-1">
          <label class="text-xs font-bold text-gray-500">Email *</label>
          <input type="email" id="login-email" required placeholder="admin@beestyle.vn" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
        </div>
        <div class="space-y-1">
          <label class="text-xs font-bold text-gray-500">Mật khẩu *</label>
          <input type="password" id="login-password" required placeholder="••••••••" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
        </div>
        <button type="submit" class="w-full bg-[#1a1a1a] hover:bg-[#c45e3a] text-white py-3 rounded-full text-sm font-bold shadow-lg transition">Đăng Nhập</button>

        <!-- Quick Login Shortcuts -->
        <div class="bg-[#faf9f7] border border-gray-200/80 rounded-2xl p-4 mt-4 space-y-2">
          <p class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Đăng nhập nhanh để test</p>
          <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="fillQuickAuth('admin@beestyle.vn', 'admin123')" class="bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 py-2 px-3 rounded-xl text-[10px] font-bold transition text-center truncate">
              🔑 Admin (Quản trị)
            </button>
            <button type="button" onclick="fillQuickAuth('customer@beestyle.vn', 'customer123')" class="bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 py-2 px-3 rounded-xl text-[10px] font-bold transition text-center truncate">
              👤 Customer (Khách)
            </button>
          </div>
        </div>
      </form>

      <!-- Register Form -->
      <form id="register-form" class="space-y-4 hidden" onsubmit="handleRegisterSubmit(event)">
        <div class="space-y-1">
          <label class="text-xs font-bold text-gray-500">Họ và tên *</label>
          <input type="text" id="register-name" required placeholder="Nguyễn Văn A" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
        </div>
        <div class="space-y-1">
          <label class="text-xs font-bold text-gray-500">Email *</label>
          <input type="email" id="register-email" required placeholder="nguyenvana@gmail.com" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
        </div>
        <div class="space-y-1">
          <label class="text-xs font-bold text-gray-500">Số điện thoại</label>
          <input type="tel" id="register-phone" placeholder="0901234567" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
        </div>
        <div class="space-y-1">
          <label class="text-xs font-bold text-gray-500">Mật khẩu *</label>
          <input type="password" id="register-password" required placeholder="Tối thiểu 6 ký tự" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] transition text-sm">
        </div>
        <button type="submit" class="w-full bg-[#1a1a1a] hover:bg-[#c45e3a] text-white py-3 rounded-full text-sm font-bold shadow-lg transition">Đăng Ký Tài Khoản</button>
      </form>
    </div>
  </div>
  <!-- Toast Notification System -->
  <div id="toast" class="fixed bottom-6 right-6 bg-[#1a1a1a] text-white px-5 py-3 rounded-2xl shadow-2xl transform translate-y-20 opacity-0 transition-all duration-300 z-50 flex items-center gap-2 text-sm border border-white/10"></div>

  <!-- Cart Drawer -->
  <div id="cart-drawer" class="fixed inset-0 z-[60] hidden">
   <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="cart-backdrop"></div>
   <div class="absolute right-0 top-0 h-full w-full max-w-md bg-[#faf9f7] shadow-2xl p-6 overflow-auto transform translate-x-full transition-transform duration-300 flex flex-col justify-between" id="cart-panel">
    <div>
      <div class="flex items-center justify-between mb-6">
       <h3 class="font-heading text-xl font-bold flex items-center gap-2">Giỏ Hàng <span id="cart-title-count" class="text-sm font-body font-normal text-gray-500">(0 sản phẩm)</span></h3>
       <button id="close-cart" class="p-2 hover:bg-gray-200 rounded-full transition"><i data-lucide="x" style="width:20px;height:20px;"></i></button>
      </div>
      <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1" id="cart-drawer-items"></div>
      <div id="cart-drawer-empty" class="hidden text-center py-16 space-y-3">
        <span class="text-5xl block">🛒</span>
        <p class="text-sm text-gray-500">Giỏ hàng của bạn đang trống.</p>
        <a href="#/shop" onclick="closeCart()" class="inline-block bg-[#1a1a1a] text-white text-xs font-semibold px-5 py-2 rounded-full hover:bg-[#c45e3a] transition">Khám phá sản phẩm ngay</a>
      </div>
    </div>
    
    <div class="border-t border-gray-200 pt-4 mt-6 bg-[#faf9f7]" id="cart-drawer-footer">
      <div class="flex justify-between text-sm mb-2 text-gray-500">
        <span>Tạm tính</span>
        <span class="font-semibold text-black" id="cart-drawer-subtotal">0₫</span>
      </div>
      <div class="flex justify-between font-bold text-lg mb-4">
        <span>Tổng số tiền</span> 
        <span class="text-[#c45e3a]" id="cart-drawer-total">0₫</span>
      </div>
      <div class="grid grid-cols-2 gap-2">
        <a href="#/cart" onclick="closeCart()" class="w-full text-center border border-gray-300 text-gray-700 py-3.5 rounded-full text-xs font-bold hover:bg-gray-50 transition">Xem Chi Tiết</a>
        <a href="#/checkout" onclick="closeCart()" class="w-full text-center bg-[#1a1a1a] hover:bg-[#c45e3a] text-white py-3.5 rounded-full text-xs font-bold transition shadow-lg shadow-black/10">Thanh Toán</a>
      </div>
    </div>
   </div>
  </div>

  <!-- JavaScript logic -->
  <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const headers = {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    };

    let productsState = [];
    let cartState = [];
    let wishlistState = [];
    let categoriesState = [];

    let appliedVoucher = null;
    let authUser = null;

    let currentOrderDetailId = null;
    let pendingOrderData = null;
    let onlinePaymentTimerInterval = null;

    function renderAuthUI() {
      const headerContainer = document.getElementById('auth-header-container');
      const mobileContainer = document.getElementById('mobile-auth-container');
      const navAdmin = document.getElementById('nav-admin');
      const navAdminMobile = document.getElementById('nav-admin-mobile');

      if (authUser) {
        // Show/hide admin navigation depending on user role
        if (authUser.role === 'Admin') {
          if (navAdmin) navAdmin.classList.remove('hidden');
          if (navAdminMobile) navAdminMobile.classList.remove('hidden');
        } else {
          if (navAdmin) navAdmin.classList.add('hidden');
          if (navAdminMobile) navAdminMobile.classList.add('hidden');
        }

        // Render desktop header user menu
        if (headerContainer) {
          headerContainer.innerHTML = `
            <div class="relative group">
              <button class="flex items-center gap-1.5 px-3 py-1.5 border border-gray-200 hover:border-gray-300 rounded-full transition bg-white text-xs font-semibold text-gray-700">
                <div class="w-5 h-5 bg-gradient-to-tr from-[#c45e3a] to-amber-400 text-white rounded-full flex items-center justify-center font-bold text-[10px]">
                  ${authUser.full_name ? authUser.full_name[0].toUpperCase() : 'U'}
                </div>
                <span class="max-w-[80px] truncate">${authUser.full_name}</span>
                <i data-lucide="chevron-down" class="w-3 h-3 text-gray-400"></i>
              </button>
              <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 hidden group-hover:block transition-all duration-300 z-50">
                <div class="px-4 py-2 border-b border-gray-50">
                  <p class="text-xs font-bold text-gray-800 line-clamp-1">${authUser.full_name}</p>
                  <p class="text-[10px] text-gray-400 line-clamp-1">${authUser.role}</p>
                </div>
                ${authUser.role === 'Admin' ? `
                  <a href="/admin" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition">
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#c45e3a]"></i>
                    <span>Quản trị Admin</span>
                  </a>
                ` : ''}
                <a href="#/profile" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition">
                  <i data-lucide="user" class="w-3.5 h-3.5"></i>
                  <span>Thông tin tài khoản</span>
                </a>
                <a href="#/orders" class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition">
                  <i data-lucide="package" class="w-3.5 h-3.5"></i>
                  <span>Đơn mua của tôi</span>
                </a>
                <button onclick="handleLogout()" class="w-full flex items-center gap-2 px-4 py-2 text-xs text-red-500 hover:bg-red-50 transition text-left">
                  <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                  <span>Đăng xuất</span>
                </button>
              </div>
            </div>
          `;
        }

        // Render mobile menu user info
        if (mobileContainer) {
          mobileContainer.innerHTML = `
            <div class="border-t border-gray-100 pt-3 space-y-2">
              <div class="flex items-center gap-2.5 px-2 py-1.5">
                <div class="w-8 h-8 bg-gradient-to-tr from-[#c45e3a] to-amber-400 text-white rounded-full flex items-center justify-center font-bold text-sm">
                  ${authUser.full_name ? authUser.full_name[0].toUpperCase() : 'U'}
                </div>
                <div>
                  <p class="text-xs font-bold text-gray-800">${authUser.full_name}</p>
                  <p class="text-[10px] text-gray-400">${authUser.role}</p>
                </div>
              </div>
              <a href="#/profile" class="w-full flex items-center justify-center gap-2 py-2.5 bg-gray-50 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-100 transition">
                <i data-lucide="user" class="w-4 h-4"></i>
                Thông tin tài khoản
              </a>
              <button onclick="handleLogout()" class="w-full flex items-center justify-center gap-2 py-2.5 bg-red-50 text-red-500 text-xs font-bold rounded-xl hover:bg-red-100 transition">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                Đăng xuất
              </button>
            </div>
          `;
        }
      } else {
        // Guest user state
        if (navAdmin) navAdmin.classList.add('hidden');
        if (navAdminMobile) navAdminMobile.classList.add('hidden');

        if (headerContainer) {
          headerContainer.innerHTML = `
            <button onclick="openAuthModal()" class="flex items-center gap-1.5 px-4 py-2 bg-[#1a1a1a] hover:bg-[#c45e3a] text-white text-xs font-bold rounded-full transition shadow-md">
              <i data-lucide="user" class="w-3.5 h-3.5"></i>
              <span>Đăng Nhập</span>
            </button>
          `;
        }

        if (mobileContainer) {
          mobileContainer.innerHTML = `
            <button onclick="openAuthModal()" class="w-full text-center py-2.5 bg-[#1a1a1a] hover:bg-[#c45e3a] text-white text-sm font-bold rounded-xl transition">
              Đăng Nhập
            </button>
          `;
        }
      }
      lucide.createIcons();
    }

    function openAuthModal() {
      const modal = document.getElementById('auth-modal');
      const box = document.getElementById('auth-modal-box');
      if (modal && box) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        void modal.offsetWidth; // force layout reflow
        box.classList.remove('scale-95', 'opacity-0');
      }
    }

    function closeAuthModal() {
      const modal = document.getElementById('auth-modal');
      const box = document.getElementById('auth-modal-box');
      if (modal && box) {
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
          modal.classList.add('hidden');
          modal.classList.remove('flex');
        }, 300);
      }
    }

    function switchAuthTab(tab) {
      const loginForm = document.getElementById('login-form');
      const registerForm = document.getElementById('register-form');
      const loginBtn = document.getElementById('tab-login-btn');
      const registerBtn = document.getElementById('tab-register-btn');
      
      if (tab === 'login') {
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');
        loginBtn.className = "flex-1 text-center py-2 text-sm font-bold border-b-2 border-[#c45e3a] text-black transition";
        registerBtn.className = "flex-1 text-center py-2 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-black transition";
      } else {
        loginForm.classList.add('hidden');
        registerForm.classList.remove('hidden');
        registerBtn.className = "flex-1 text-center py-2 text-sm font-bold border-b-2 border-[#c45e3a] text-black transition";
        loginBtn.className = "flex-1 text-center py-2 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-black transition";
      }
    }

    function fillQuickAuth(email, password) {
      const emailInput = document.getElementById('login-email');
      const passInput = document.getElementById('login-password');
      if (emailInput) emailInput.value = email;
      if (passInput) passInput.value = password;
    }

    async function handleLoginSubmit(event) {
      event.preventDefault();
      const email = document.getElementById('login-email').value;
      const password = document.getElementById('login-password').value;
      
      try {
        const res = await fetch('/api/login', {
          method: 'POST',
          headers: headers,
          body: JSON.stringify({ email, password })
        });
        const data = await res.json();
        if (res.ok) {
          authUser = data.user;
          showToast('Đăng nhập thành công!', 'success');
          closeAuthModal();
          renderAuthUI();
          
          document.getElementById('login-email').value = '';
          document.getElementById('login-password').value = '';
          
          await router();
        } else {
          showToast(data.message || 'Đăng nhập thất bại!', 'info');
        }
      } catch (err) {
        console.error("Login error:", err);
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    async function handleRegisterSubmit(event) {
      event.preventDefault();
      const full_name = document.getElementById('register-name').value;
      const email = document.getElementById('register-email').value;
      const phone = document.getElementById('register-phone').value;
      const password = document.getElementById('register-password').value;
      
      try {
        const res = await fetch('/api/register', {
          method: 'POST',
          headers: headers,
          body: JSON.stringify({ full_name, email, phone, password })
        });
        const data = await res.json();
        if (res.ok) {
          authUser = data.user;
          showToast('Đăng ký thành công!', 'success');
          closeAuthModal();
          renderAuthUI();
          
          document.getElementById('register-name').value = '';
          document.getElementById('register-email').value = '';
          document.getElementById('register-phone').value = '';
          document.getElementById('register-password').value = '';
          
          await router();
        } else {
          showToast(data.message || 'Đăng ký thất bại!', 'info');
        }
      } catch (err) {
        console.error("Register error:", err);
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    async function handleLogout() {
      try {
        const res = await fetch('/api/logout', {
          method: 'POST',
          headers: headers
        });
        const data = await res.json();
        if (res.ok) {
          authUser = null;
          cartState = [];
          wishlistState = [];
          localStorage.removeItem('beestyle_cart');
          localStorage.removeItem('beestyle_wishlist');
          updateCartBadge();
          updateWishlistBadge();
          showToast('Đăng xuất thành công!', 'info');
          renderAuthUI();
          if (window.location.hash === '#/profile' || window.location.hash === '#/orders' || window.location.hash.startsWith('#/order-detail/')) {
            window.location.hash = '#/';
          } else {
            await router();
          }
        } else {
          showToast(data.message || 'Lỗi đăng xuất', 'info');
        }
      } catch (err) {
        console.error("Logout error:", err);
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    async function initData() {
      try {
        const authRes = await fetch('/api/auth/status');
        const authData = await authRes.json();
        if (authData.logged_in) {
          authUser = authData.user;
          cartState = JSON.parse(localStorage.getItem('beestyle_cart') || '[]');
          wishlistState = JSON.parse(localStorage.getItem('beestyle_wishlist') || '[]');
        } else {
          authUser = null;
          cartState = [];
          wishlistState = [];
          localStorage.removeItem('beestyle_cart');
          localStorage.removeItem('beestyle_wishlist');
        }
      } catch (err) {
        console.error("Error checking auth status:", err);
        authUser = null;
        cartState = [];
        wishlistState = [];
        localStorage.removeItem('beestyle_cart');
        localStorage.removeItem('beestyle_wishlist');
      }
      
      renderAuthUI();

      try {
        const catRes = await fetch('/api/categories');
        categoriesState = await catRes.json();
      } catch (err) {
        console.error("Error loading categories:", err);
      }

      await ensureProductsLoaded();
      updateCartBadge();
      updateWishlistBadge();
    }

    async function ensureProductsLoaded() {
      if (productsState.length === 0) {
        try {
          const res = await fetch('/api/products');
          productsState = await res.json();
        } catch (err) {
          console.error("Error loading products cache:", err);
        }
      }
    }

    // -------------------------------------------------------------
    // Router Implementation
    // -------------------------------------------------------------
    async function router() {
      const hash = window.location.hash || '#/';
      
      // Hide all pages
      document.querySelectorAll('.page-view').forEach(view => view.classList.add('hidden'));
      // Remove all active header nav highlights
      document.querySelectorAll('header nav a').forEach(link => link.classList.remove('text-[#c45e3a]', 'font-bold'));
      
      // Close mobile menu on navigate
      document.getElementById('mobile-menu').classList.add('hidden');
      
      if (hash === '#/' || hash === '') {
        showPage('home-view');
        document.getElementById('nav-home').classList.add('text-[#c45e3a]', 'font-bold');
        await renderHomePage();
      } else if (hash.startsWith('#/shop')) {
        showPage('shop-view');
        document.getElementById('nav-shop').classList.add('text-[#c45e3a]', 'font-bold');
        
        const queryParams = new URLSearchParams(hash.includes('?') ? hash.split('?')[1] : '');
        await renderShopPage(queryParams);
      } else if (hash.startsWith('#/product/')) {
        const id = hash.split('#/product/')[1].split('?')[0]; // Extract ID
        showPage('product-detail-view');
        await renderProductDetailPage(id);
      } else if (hash === '#/cart') {
        showPage('cart-view');
        await renderCartPage();
      } else if (hash === '#/checkout') {
        if (!authUser) {
          showToast('Vui lòng đăng nhập để tiến hành thanh toán!', 'info');
          window.location.hash = '#/';
          openAuthModal();
          return;
        }
        showPage('checkout-view');
        await renderCheckoutPage();
      } else if (hash === '#/orders') {
        if (!authUser) {
          showToast('Vui lòng đăng nhập để xem đơn hàng của bạn!', 'info');
          window.location.hash = '#/';
          openAuthModal();
          return;
        }
        showPage('orders-view');
        document.getElementById('nav-orders').classList.add('text-[#c45e3a]', 'font-bold');
        await renderOrdersPage();
      } else if (hash === '#/profile') {
        if (!authUser) {
          showToast('Vui lòng đăng nhập để chỉnh sửa thông tin cá nhân!', 'info');
          window.location.hash = '#/';
          openAuthModal();
          return;
        }
        showPage('profile-view');
        renderProfilePage();
      } else if (hash.startsWith('#/order-detail/')) {
        if (!authUser) {
          showToast('Vui lòng đăng nhập để xem chi tiết đơn hàng!', 'info');
          window.location.hash = '#/';
          openAuthModal();
          return;
        }
        const id = hash.split('#/order-detail/')[1].split('?')[0];
        showPage('order-detail-view');
        await renderOrderDetailPage(id);
      }
      
      window.scrollTo(0, 0);
    }

    function showPage(viewId) {
      const page = document.getElementById(viewId);
      if (page) page.classList.remove('hidden');
      lucide.createIcons();
    }

    window.addEventListener('hashchange', router);
    window.addEventListener('load', async () => {
      await initData();
      await router();
    });

    // -------------------------------------------------------------
    // UI Helpers (Toast, Dialog, Badges)
    // -------------------------------------------------------------
    function showToast(message, type = 'success') {
      const t = document.getElementById('toast');
      const icon = type === 'success' ? '✨' : type === 'info' ? 'ℹ️' : '❤️';
      t.innerHTML = `<span>${icon}</span> <span>${message}</span>`;
      t.classList.remove('translate-y-20', 'opacity-0');
      
      setTimeout(() => {
        t.classList.add('translate-y-20', 'opacity-0');
      }, 3000);
    }

    function updateCartBadge() {
      const totalItems = cartState.reduce((sum, item) => sum + item.quantity, 0);
      document.getElementById('cart-count').textContent = totalItems;
      document.getElementById('cart-title-count').textContent = `(${totalItems} sản phẩm)`;
    }

    function updateWishlistBadge() {
      const count = wishlistState.length;
      const badge = document.getElementById('wishlist-count');
      if (count > 0) {
        badge.classList.remove('hidden');
        badge.textContent = count;
      } else {
        badge.classList.add('hidden');
      }
    }

    function formatVND(amount) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    }

    // -------------------------------------------------------------
    // Wishlist Logic
    // -------------------------------------------------------------
    function toggleWishlist(prodId, event) {
      if (event) event.stopPropagation();
      if (!authUser) {
        showToast('Vui lòng đăng nhập để sử dụng tính năng yêu thích!', 'info');
        openAuthModal();
        return;
      }
      const idStr = prodId.toString();
      const index = wishlistState.indexOf(idStr);
      if (index === -1) {
        wishlistState.push(idStr);
        showToast('Đã thêm sản phẩm vào danh sách yêu thích!', 'heart');
      } else {
        wishlistState.splice(index, 1);
        showToast('Đã xóa sản phẩm khỏi danh sách yêu thích!', 'info');
      }
      localStorage.setItem('beestyle_wishlist', JSON.stringify(wishlistState));
      updateWishlistBadge();
      
      const hash = window.location.hash || '#/';
      if (hash.startsWith('#/shop')) {
        const queryParams = new URLSearchParams(hash.includes('?') ? hash.split('?')[1] : '');
        renderShopPage(queryParams);
      } else if (hash === '#/' || hash === '') {
        renderHomePage();
      } else if (hash.startsWith('#/product/')) {
        const id = hash.split('#/product/')[1].split('?')[0];
        renderProductDetailPage(id);
      }
    }

    // -------------------------------------------------------------
    // Page Rendering: HOME
    // -------------------------------------------------------------
    async function renderHomePage() {
      const grid = document.getElementById('home-product-grid');
      grid.innerHTML = '<div class="col-span-4 text-center py-10 text-gray-400">Đang tải sản phẩm nổi bật...</div>';
      
      try {
        const res = await fetch('/api/products');
        productsState = await res.json();
        
        grid.innerHTML = '';
        const featured = productsState.slice(0, 4);
        
        if (featured.length === 0) {
          grid.innerHTML = '<div class="col-span-4 text-center py-10 text-gray-400">Chưa có sản phẩm nổi bật nào.</div>';
          return;
        }
        
        featured.forEach((p) => {
          const isFav = wishlistState.includes(p.id.toString());
          const favIconClass = isFav ? 'text-red-500 fill-current' : 'text-gray-400 fill-transparent hover:text-red-500';
          
          grid.innerHTML += `
            <div class="product-card group cursor-pointer bg-white p-4 rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-300 relative flex flex-col justify-between" onclick="window.location.hash = '#/product/${p.id}'">
              <button onclick="toggleWishlist('${p.id}', event)" class="absolute top-6 right-6 z-10 w-9 h-9 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-transform">
                <i data-lucide="heart" class="w-4 h-4 ${favIconClass}"></i>
              </button>
              
              <div class="relative bg-[#faf9f7] rounded-xl overflow-hidden mb-3 aspect-[3/4] flex items-center justify-center">
                <img src="${p.thumbnail_url}" alt="${p.name}" class="product-img w-full h-full object-cover">
                ${p.tag ? `<span class="absolute top-3 left-3 bg-[#c45e3a] text-white text-[10px] px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">${p.tag}</span>` : ''}
                
                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-4">
                  <button class="bg-[#1a1a1a] text-white text-[10px] font-bold px-4 py-2.5 rounded-full shadow-lg hover:bg-[#c45e3a] transition transform translate-y-2 group-hover:translate-y-0 duration-300" onclick="event.stopPropagation(); quickAddToCart('${p.id}')">
                    + Thêm nhanh vào giỏ
                  </button>
                </div>
              </div>
              <div>
                <div class="flex items-center gap-1 mb-1 text-yellow-500">
                  <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                  <span class="text-xs font-bold text-gray-700">${p.rating}</span>
                </div>
                <h3 class="font-bold text-sm text-gray-800 line-clamp-1 group-hover:text-[#c45e3a] transition">${p.name}</h3>
                <div class="flex items-center gap-2 mt-1">
                  <span class="font-bold text-sm text-[#c45e3a]">${formatVND(p.price)}</span>
                  ${p.old_price ? `<span class="text-xs text-gray-400 line-through">${formatVND(p.old_price)}</span>` : ''}
                </div>
              </div>
            </div>`;
        });
        lucide.createIcons();
      } catch (err) {
        grid.innerHTML = '<div class="col-span-4 text-center py-10 text-red-500">Lỗi kết nối máy chủ khi tải sản phẩm.</div>';
      }
    }

    // -------------------------------------------------------------
    // Page Rendering: SHOP (Product List, Filtering & Sorting)
    // -------------------------------------------------------------
    let currentCategoryFilter = 'all';
    let currentMaxPrice = 1500000;
    let currentSearchQuery = '';
    let selectedActiveTag = null;
    let showWishlistOnly = false;

    async function renderShopPage(queryParams) {
      if (queryParams) {
        if (queryParams.has('category')) currentCategoryFilter = queryParams.get('category');
        if (queryParams.has('tag')) selectedActiveTag = queryParams.get('tag');
        if (queryParams.has('wishlist')) showWishlistOnly = queryParams.get('wishlist') === 'true';
        if (queryParams.has('search')) currentSearchQuery = queryParams.get('search');
      }

      // Sync form controls on UI
      const categoryInputs = document.querySelectorAll('input[name="category"]');
      categoryInputs.forEach(input => {
        input.checked = input.value === currentCategoryFilter;
      });
      
      const priceSlider = document.getElementById('price-range');
      priceSlider.value = currentMaxPrice;
      document.getElementById('price-range-val').textContent = `Dưới ${formatVND(currentMaxPrice)}`;
      
      const searchBoxInput = document.getElementById('shop-search-input');
      searchBoxInput.value = currentSearchQuery;

      const grid = document.getElementById('shop-product-grid');
      const emptyState = document.getElementById('shop-empty-state');
      grid.innerHTML = '<div class="col-span-3 text-center py-20 text-gray-400">Đang tải sản phẩm...</div>';
      emptyState.classList.add('hidden');
      grid.classList.remove('hidden');

      try {
        const params = new URLSearchParams();
        if (currentCategoryFilter && currentCategoryFilter !== 'all') params.set('category', currentCategoryFilter);
        if (currentSearchQuery.trim() !== '') params.set('search', currentSearchQuery);
        if (selectedActiveTag) params.set('tag', selectedActiveTag);
        params.set('max_price', currentMaxPrice);
        
        const sortBy = document.getElementById('sort-select').value;
        params.set('sort', sortBy);

        const res = await fetch('/api/products?' + params.toString());
        let filtered = await res.json();

        // client-side wishlist filter
        if (showWishlistOnly) {
          filtered = filtered.filter(p => wishlistState.includes(p.id.toString()));
          document.getElementById('filter-wishlist').classList.add('bg-red-500', 'text-white');
        } else {
          document.getElementById('filter-wishlist').classList.remove('bg-red-500', 'text-white');
        }

        if (selectedActiveTag) {
          document.getElementById('filter-tag-new').classList.toggle('bg-[#c45e3a]', selectedActiveTag === 'Mới');
          document.getElementById('filter-tag-new').classList.toggle('text-white', selectedActiveTag === 'Mới');
          document.getElementById('filter-tag-sale').classList.toggle('bg-[#c45e3a]', selectedActiveTag === 'Sale');
          document.getElementById('filter-tag-sale').classList.toggle('text-white', selectedActiveTag === 'Sale');
        } else {
          document.getElementById('filter-tag-new').classList.remove('bg-[#c45e3a]', 'text-white');
          document.getElementById('filter-tag-sale').classList.remove('bg-[#c45e3a]', 'text-white');
        }

        document.getElementById('product-count-text').textContent = `Hiển thị ${filtered.length} sản phẩm`;
        
        grid.innerHTML = '';
        if (filtered.length === 0) {
          grid.classList.add('hidden');
          emptyState.classList.remove('hidden');
        } else {
          grid.classList.remove('hidden');
          emptyState.classList.add('hidden');

          filtered.forEach(p => {
            const isFav = wishlistState.includes(p.id.toString());
            const favIconClass = isFav ? 'text-red-500 fill-current' : 'text-gray-400 fill-transparent hover:text-red-500';
            
            grid.innerHTML += `
              <div class="product-card group cursor-pointer bg-white p-4 rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-300 relative flex flex-col justify-between" onclick="window.location.hash = '#/product/${p.id}'">
                <button onclick="toggleWishlist('${p.id}', event)" class="absolute top-6 right-6 z-10 w-9 h-9 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-transform">
                  <i data-lucide="heart" class="w-4 h-4 ${favIconClass}"></i>
                </button>
                
                <div class="relative bg-[#faf9f7] rounded-xl overflow-hidden mb-3 aspect-[3/4] flex items-center justify-center">
                  <img src="${p.thumbnail_url}" alt="${p.name}" class="product-img w-full h-full object-cover">
                  ${p.tag ? `<span class="absolute top-3 left-3 bg-[#c45e3a] text-white text-[10px] px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">${p.tag}</span>` : ''}
                  
                  <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-4">
                    <button class="bg-[#1a1a1a] text-white text-[10px] font-bold px-4 py-2.5 rounded-full shadow-lg hover:bg-[#c45e3a] transition transform translate-y-2 group-hover:translate-y-0 duration-300" onclick="event.stopPropagation(); quickAddToCart('${p.id}')">
                      + Thêm nhanh vào giỏ
                    </button>
                  </div>
                </div>
                <div>
                  <div class="flex items-center gap-1 mb-1 text-yellow-500">
                    <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                    <span class="text-xs font-bold text-gray-700">${p.rating}</span>
                  </div>
                  <h3 class="font-bold text-sm text-gray-800 line-clamp-2 group-hover:text-[#c45e3a] transition h-10">${p.name}</h3>
                  <div class="flex items-center gap-2 mt-1">
                    <span class="font-bold text-sm text-[#c45e3a]">${formatVND(p.price)}</span>
                    ${p.old_price ? `<span class="text-xs text-gray-400 line-through">${formatVND(p.old_price)}</span>` : ''}
                  </div>
                </div>
              </div>`;
          });
        }
        lucide.createIcons();
      } catch (err) {
        grid.innerHTML = '<div class="col-span-3 text-center py-20 text-red-500">Lỗi kết nối máy chủ.</div>';
      }
    }

    document.getElementById('category-filter-list').addEventListener('change', (e) => {
      if (e.target.name === 'category') {
        currentCategoryFilter = e.target.value;
        updateUrlParams();
      }
    });

    document.getElementById('price-range').addEventListener('input', (e) => {
      currentMaxPrice = parseInt(e.target.value);
      document.getElementById('price-range-val').textContent = `Dưới ${formatVND(currentMaxPrice)}`;
    });
    
    document.getElementById('price-range').addEventListener('change', () => {
      updateUrlParams();
    });

    let searchTimeout = null;
    document.getElementById('shop-search-input').addEventListener('input', (e) => {
      currentSearchQuery = e.target.value;
      if (searchTimeout) clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        updateUrlParams();
      }, 400);
    });

    document.getElementById('sort-select').addEventListener('change', () => {
      renderShopPage();
    });

    document.getElementById('filter-tag-new').onclick = () => {
      selectedActiveTag = selectedActiveTag === 'Mới' ? null : 'Mới';
      updateUrlParams();
    };

    document.getElementById('filter-tag-sale').onclick = () => {
      selectedActiveTag = selectedActiveTag === 'Sale' ? null : 'Sale';
      updateUrlParams();
    };

    document.getElementById('filter-wishlist').onclick = () => {
      showWishlistOnly = !showWishlistOnly;
      updateUrlParams();
    };

    document.getElementById('reset-filters').onclick = resetAllFilters;

    function resetAllFilters() {
      currentCategoryFilter = 'all';
      currentMaxPrice = 1500000;
      currentSearchQuery = '';
      selectedActiveTag = null;
      showWishlistOnly = false;
      document.getElementById('sort-select').value = 'default';
      window.location.hash = '#/shop';
      renderShopPage();
    }

    function updateUrlParams() {
      const params = new URLSearchParams();
      if (currentCategoryFilter !== 'all') params.set('category', currentCategoryFilter);
      if (currentSearchQuery.trim() !== '') params.set('search', currentSearchQuery);
      if (selectedActiveTag) params.set('tag', selectedActiveTag);
      if (showWishlistOnly) params.set('wishlist', 'true');
      
      const searchStr = params.toString();
      window.location.hash = `#/shop${searchStr ? '?' + searchStr : ''}`;
    }

    // -------------------------------------------------------------
    // Page Rendering: PRODUCT DETAIL PAGE & REVIEWS
    // -------------------------------------------------------------
    let currentSelectedSize = '';
    let currentSelectedColor = '';
    let currentDetailProductId = '';
    let userReviewRating = 5;
    let currentSelectedPrice = 0;
    let currentProductDetails = null;

    const colorMap = {
      'trắng': '#ffffff',
      'đen': '#1a1a1a',
      'xám': '#8e8e93',
      'be': '#f5f5dc',
      'xanh bơ': '#a3b899',
      'hồng nhạt': '#ffb6c1',
      'xanh đậm': '#1e293b',
      'xanh sáng': '#7dd3fc',
      'xanh navy': '#1e3a8a',
      'xanh rêu': '#3f6212',
      'kem': '#fffdd0',
      'nâu hạt dẻ': '#8b5a2b',
      'kem sữa': '#fdf5e6',
      'đen nhám': '#2d2d2d',
      'mặc định': '#e2e8f0'
    };

    async function renderProductDetailPage(prodId) {
      currentDetailProductId = prodId;
      const detailContainer = document.getElementById('product-detail-content');
      detailContainer.innerHTML = '<div class="text-center py-20 text-gray-400">Đang tải thông tin sản phẩm...</div>';
      
      try {
        const res = await fetch('/api/products/' + prodId);
        if (res.status === 404) {
          detailContainer.innerHTML = `
            <div class="text-center py-20">
              <span class="text-6xl block mb-4">⚠️</span>
              <h3 class="font-heading text-2xl font-bold">Không tìm thấy sản phẩm</h3>
              <a href="#/shop" class="text-[#c45e3a] hover:underline text-sm font-semibold mt-2 inline-block">Trở lại cửa hàng</a>
            </div>`;
          return;
        }

        const product = await res.json();
        currentProductDetails = product;
        reviewsState = product.reviews || [];

        const sizesArr = product.sizes ? product.sizes.split(',').map(s => s.trim()) : ['Free Size'];
        const colorsArr = product.colors ? product.colors.split(',').map(c => c.trim()) : ['Mặc định'];

        currentSelectedSize = sizesArr[0];
        currentSelectedColor = colorsArr[0];
        currentSelectedPrice = product.price;

        const isFav = wishlistState.includes(product.id.toString());
        const favBtnLabel = isFav ? 'Đã yêu thích' : 'Thêm vào yêu thích';
        const favIconClass = isFav ? 'text-red-500 fill-current' : 'text-gray-500 fill-transparent hover:text-red-500';

        // Dynamic Interactive Gallery Images
        const galleryImages = [
          { url: product.thumbnail_url, label: 'Bản chính', style: '' },
          { url: product.thumbnail_url, label: 'Cận cảnh', style: 'object-position: center 20%; transform: scale(1.15);' },
          { url: product.thumbnail_url, label: 'Phối màu', style: 'filter: hue-rotate(15deg) brightness(1.05);' }
        ];

        detailContainer.innerHTML = `
          <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Gallery -->
            <div class="space-y-4">
              <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 aspect-[3/4] shadow-md relative group">
                <img id="detail-main-img" src="${product.thumbnail_url}" alt="${product.name}" class="w-full h-full object-cover transition-all duration-500">
                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
              </div>
              <div class="grid grid-cols-3 gap-3">
                ${galleryImages.map((img, idx) => `
                  <button onclick="switchDetailImage('${img.url}', '${img.style}', this)" 
                          class="aspect-[3/4] rounded-2xl overflow-hidden border-2 transition-all bg-white relative ${idx === 0 ? 'border-black ring-2 ring-offset-2 ring-black/10' : 'border-gray-100 hover:border-gray-300'}"
                          style="outline: none;">
                    <img src="${img.url}" class="w-full h-full object-cover" style="${img.style}">
                    <div class="absolute inset-0 bg-black/5 hover:bg-transparent transition-all"></div>
                  </button>
                `).join('')}
              </div>
            </div>
            
            <!-- Product information -->
            <div class="space-y-6">
              <div class="space-y-2">
                ${product.tag ? `<span class="bg-[#c45e3a] text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider inline-block">${product.tag}</span>` : ''}
                <h1 class="font-heading text-3xl font-bold text-gray-800 leading-tight">${product.name}</h1>
                
                <div class="flex items-center gap-4 text-sm font-semibold">
                  <div class="flex items-center gap-1 text-yellow-500">
                    <i data-lucide="star" class="w-4.5 h-4.5 fill-current"></i>
                    <span class="text-gray-800">${product.rating}</span>
                  </div>
                  <span class="text-gray-300">|</span>
                  <span class="text-[#c45e3a] hover:underline cursor-pointer" onclick="scrollToReviews()">${reviewsState.length} lượt nhận xét</span>
                  <span class="text-gray-300">|</span>
                  <span id="detail-stock-badge"></span>
                </div>
              </div>
              
              <div class="flex items-center gap-3">
                <span id="detail-product-price" class="font-heading text-3xl font-bold text-[#c45e3a]">${formatVND(product.price)}</span>
                ${product.old_price ? `<span class="text-lg text-gray-400 line-through font-light">${formatVND(product.old_price)}</span>` : ''}
              </div>
              
              <p class="text-gray-600 font-light text-sm leading-relaxed">${product.description}</p>
              
              <!-- Select size -->
              <div class="space-y-2">
                <div class="flex items-center">
                  <span class="text-xs font-bold uppercase text-gray-500 tracking-wider">Kích thước:</span>
                  <span id="detail-active-size" class="text-xs font-bold text-gray-800 ml-1.5">${currentSelectedSize}</span>
                </div>
                <div class="flex gap-2">
                  ${sizesArr.map(size => `
                    <button onclick="selectDetailSize('${size}', this)" class="border px-4 py-2.5 rounded-xl text-xs font-bold transition ${size === currentSelectedSize ? 'border-black bg-black text-white shadow-sm' : 'border-gray-200 text-gray-600 bg-white hover:bg-gray-50 hover:border-black'}">${size}</button>
                  `).join('')}
                </div>
              </div>
              
              <!-- Select color -->
              <div class="space-y-2">
                <div class="flex items-center">
                  <span class="text-xs font-bold uppercase text-gray-500 tracking-wider">Màu sắc:</span>
                  <span id="detail-active-color" class="text-xs font-bold text-gray-800 ml-1.5">${currentSelectedColor}</span>
                </div>
                <div class="flex gap-3 items-center">
                  ${colorsArr.map(color => {
                    const norm = color.toLowerCase().trim();
                    const hex = colorMap[norm] || '#e2e8f0';
                    const isLight = ['trắng', 'kem', 'be', 'kem sữa'].includes(norm);
                    return `
                      <button onclick="selectDetailColor('${color}', this)" 
                              title="${color}"
                              class="w-9 h-9 rounded-full border-2 transition-all duration-200 relative flex items-center justify-center ${color === currentSelectedColor ? 'border-[#c45e3a] scale-110 shadow-md ring-2 ring-offset-2 ring-[#c45e3a]/40' : 'border-gray-200 hover:border-gray-400'}"
                              style="background-color: ${hex}; outline: none;">
                        ${isLight ? `<span class="absolute inset-0.5 rounded-full border border-gray-200/50"></span>` : ''}
                        ${color === currentSelectedColor ? `
                          <span class="absolute inset-0 flex items-center justify-center">
                            <i data-lucide="check" class="w-4 h-4 ${isLight ? 'text-black' : 'text-white'}"></i>
                          </span>
                        ` : ''}
                      </button>
                    `;
                  }).join('')}
                </div>
              </div>

              <!-- Trust Badges -->
              <div class="grid grid-cols-3 gap-3 py-4 border-t border-b border-gray-100 my-6">
                <div class="flex flex-col items-center text-center p-2 rounded-2xl bg-gray-50 border border-gray-100/50">
                  <i data-lucide="truck" class="w-5 h-5 text-[#c45e3a] mb-1"></i>
                  <span class="text-[10px] font-bold text-gray-800">Giao Miễn Phí</span>
                  <span class="text-[8px] text-gray-400 mt-0.5">Đơn hàng từ 500k</span>
                </div>
                <div class="flex flex-col items-center text-center p-2 rounded-2xl bg-gray-50 border border-gray-100/50">
                  <i data-lucide="rotate-ccw" class="w-5 h-5 text-[#c45e3a] mb-1"></i>
                  <span class="text-[10px] font-bold text-gray-800">Đổi Trả 7 Ngày</span>
                  <span class="text-[8px] text-gray-400 mt-0.5">Dễ dàng, nhanh chóng</span>
                </div>
                <div class="flex flex-col items-center text-center p-2 rounded-2xl bg-gray-50 border border-gray-100/50">
                  <i data-lucide="shield-check" class="w-5 h-5 text-[#c45e3a] mb-1"></i>
                  <span class="text-[10px] font-bold text-gray-800">Chính Hãng 100%</span>
                  <span class="text-[8px] text-gray-400 mt-0.5">Cam kết chất lượng</span>
                </div>
              </div>
              
              <!-- Quantity and Add to Cart -->
              <div class="pt-2 flex flex-col sm:flex-row gap-4">
                <div class="flex border border-gray-200 rounded-full w-fit bg-white overflow-hidden self-start">
                  <button onclick="changeDetailQty(-1)" class="px-4 py-3 hover:bg-gray-100 transition"><i data-lucide="minus" class="w-4 h-4"></i></button>
                  <input type="number" id="detail-qty" value="1" min="1" max="99" class="w-12 text-center outline-none text-sm font-bold bg-transparent">
                  <button onclick="changeDetailQty(1)" class="px-4 py-3 hover:bg-gray-100 transition"><i data-lucide="plus" class="w-4 h-4"></i></button>
                </div>
                
                <button id="detail-cart-btn" onclick="addDetailToCart()" class="flex-1 bg-[#1a1a1a] hover:bg-[#c45e3a] text-white font-bold py-3.5 rounded-full transition flex items-center justify-center gap-2 shadow-lg shadow-black/10">
                  <i data-lucide="shopping-bag" class="w-4 h-4"></i> Thêm vào giỏ hàng
                </button>
                
                <button onclick="toggleWishlist('${product.id}')" class="border border-gray-200 p-3 rounded-full hover:bg-gray-50 transition flex items-center gap-1 text-xs font-semibold">
                  <i data-lucide="heart" class="w-5 h-5 ${favIconClass}"></i> <span class="hidden sm:inline">${favBtnLabel}</span>
                </button>
              </div>

              <!-- Accordions -->
              <div class="space-y-2 pt-2">
                <div class="border border-gray-100 rounded-2xl overflow-hidden bg-white">
                  <button onclick="toggleAccordion('acc-spec')" class="w-full flex items-center justify-between p-4 text-xs font-bold text-gray-800 hover:bg-gray-50 transition">
                    <span>THÔNG SỐ & CHẤT LIỆU</span>
                    <i id="acc-spec-icon" data-lucide="chevron-down" class="w-4 h-4 text-gray-400 transition-transform"></i>
                  </button>
                  <div id="acc-spec" class="hidden px-4 pb-4 text-xs text-gray-600 leading-relaxed space-y-2 border-t border-gray-50 pt-3">
                    <p>• <strong>Chất liệu:</strong> 100% Cotton tự nhiên cao cấp mềm mại, thấm hút mồ hôi và thoáng khí.</p>
                    <p>• <strong>Kiểu dáng:</strong> Thiết kế thời trang, dễ dàng phối hợp trang phục hàng ngày.</p>
                    <p>• <strong>Chất lượng:</strong> Đường kim mũi chỉ đạt tiêu chuẩn xuất khẩu cao cấp.</p>
                  </div>
                </div>
                
                <div class="border border-gray-100 rounded-2xl overflow-hidden bg-white">
                  <button onclick="toggleAccordion('acc-care')" class="w-full flex items-center justify-between p-4 text-xs font-bold text-gray-800 hover:bg-gray-50 transition">
                    <span>HƯỚNG DẪN BẢO QUẢN</span>
                    <i id="acc-care-icon" data-lucide="chevron-down" class="w-4 h-4 text-gray-400 transition-transform"></i>
                  </button>
                  <div id="acc-care" class="hidden px-4 pb-4 text-xs text-gray-600 leading-relaxed space-y-2 border-t border-gray-50 pt-3">
                    <p>• Giặt máy ở chế độ nhẹ nhàng với nước lạnh hoặc ấm.</p>
                    <p>• Không sử dụng hóa chất tẩy rửa mạnh để giữ màu tốt hơn.</p>
                    <p>• Phơi nơi khô ráo thoáng mát, hạn chế vắt quá kiệt nước.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>`;

        renderDetailReviews(product);
        renderRelatedProducts(product);
        lucide.createIcons();

        const stockVal = product.stock !== undefined ? product.stock : 0;
        const badgeNode = document.getElementById('detail-stock-badge');
        if (badgeNode) {
          if (stockVal === 0) {
            badgeNode.innerHTML = `<span class="text-red-500 font-bold bg-red-50 px-2 py-0.5 rounded border border-red-100 text-xs">Hết hàng</span>`;
          } else if (stockVal <= 5) {
            badgeNode.innerHTML = `<span class="text-amber-500 font-bold bg-amber-50 px-2 py-0.5 rounded border border-amber-100 text-xs">Sắp hết hàng (${stockVal})</span>`;
          } else {
            badgeNode.innerHTML = `<span class="text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 text-xs">Còn hàng (${stockVal})</span>`;
          }
        }
        
        const cartBtn = document.getElementById('detail-cart-btn');
        if (cartBtn && stockVal === 0) {
          cartBtn.disabled = true;
          cartBtn.className = 'flex-1 bg-gray-300 text-gray-500 font-bold py-3.5 rounded-full cursor-not-allowed flex items-center justify-center gap-2';
          cartBtn.innerHTML = `<i data-lucide="shopping-bag" class="w-4.5 h-4.5"></i> Hết hàng`;
          lucide.createIcons();
        }

        updateProductDetailsPriceAndImage();
      } catch (err) {
        detailContainer.innerHTML = '<div class="text-center py-20 text-red-500">Lỗi tải chi tiết sản phẩm.</div>';
      }
    }

    function switchDetailImage(url, style, btn) {
      const mainImg = document.getElementById('detail-main-img');
      if (mainImg) {
        mainImg.src = url;
        mainImg.style = style;
      }
      btn.parentElement.querySelectorAll('button').forEach(b => {
        b.className = 'aspect-[3/4] rounded-2xl overflow-hidden border-2 transition-all bg-white relative border-gray-100 hover:border-gray-300';
      });
      btn.className = 'aspect-[3/4] rounded-2xl overflow-hidden border-2 transition-all bg-white relative border-black ring-2 ring-offset-2 ring-black/10';
    }

    function toggleAccordion(id) {
      const element = document.getElementById(id);
      const icon = document.getElementById(id + '-icon');
      if (element && icon) {
        const isHidden = element.classList.contains('hidden');
        if (isHidden) {
          element.classList.remove('hidden');
          icon.classList.add('rotate-180');
        } else {
          element.classList.add('hidden');
          icon.classList.remove('rotate-180');
        }
      }
    }

    function selectDetailSize(size, btn) {
      currentSelectedSize = size;
      const activeSizeLabel = document.getElementById('detail-active-size');
      if (activeSizeLabel) activeSizeLabel.textContent = size;
      
      btn.parentElement.querySelectorAll('button').forEach(b => {
        b.className = 'border px-4 py-2.5 rounded-xl text-xs font-bold transition border-gray-200 text-gray-600 bg-white hover:bg-gray-50 hover:border-black';
      });
      btn.className = 'border px-4 py-2.5 rounded-xl text-xs font-bold transition border-black bg-black text-white shadow-sm';
      updateProductDetailsPriceAndImage();
    }

    function selectDetailColor(color, btn) {
      currentSelectedColor = color;
      const activeColorLabel = document.getElementById('detail-active-color');
      if (activeColorLabel) activeColorLabel.textContent = color;
      
      btn.parentElement.querySelectorAll('button').forEach(b => {
        b.className = 'w-9 h-9 rounded-full border-2 transition-all duration-200 relative flex items-center justify-center border-gray-200 hover:border-gray-400';
        const check = b.querySelector('.absolute.inset-0.flex');
        if (check) check.remove();
      });
      
      btn.className = 'w-9 h-9 rounded-full border-2 transition-all duration-200 relative flex items-center justify-center border-[#c45e3a] scale-110 shadow-md ring-2 ring-offset-2 ring-[#c45e3a]/40';
      
      const norm = color.toLowerCase().trim();
      const isLight = ['trắng', 'kem', 'be', 'kem sữa'].includes(norm);
      const checkHtml = `
        <span class="absolute inset-0 flex items-center justify-center">
          <i data-lucide="check" class="w-4 h-4 ${isLight ? 'text-black' : 'text-white'}"></i>
        </span>`;
      btn.insertAdjacentHTML('beforeend', checkHtml);
      lucide.createIcons();
      updateProductDetailsPriceAndImage();
    }

    function changeDetailQty(amount) {
      const input = document.getElementById('detail-qty');
      let val = parseInt(input.value) + amount;
      if (val < 1) val = 1;
      input.value = val;
    }

    function addDetailToCart() {
      if (!authUser) {
        showToast('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!', 'info');
        openAuthModal();
        return;
      }
      const qty = parseInt(document.getElementById('detail-qty').value);
      addToCartState(currentDetailProductId, qty, currentSelectedSize, currentSelectedColor);
      showToast('Đã thêm sản phẩm vào giỏ hàng!');
    }

    function scrollToReviews() {
      const section = document.getElementById('review-form');
      if (section) section.scrollIntoView({ behavior: 'smooth' });
    }

    function renderDetailReviews(product) {
      const reviews = reviewsState;
      const list = document.getElementById('product-reviews-list');
      
      document.getElementById('detail-review-count').textContent = `Dựa trên ${reviews.length} đánh giá`;
      
      const avg = product.rating;
      document.getElementById('detail-avg-rating').textContent = avg;
      
      const avgStars = document.getElementById('detail-avg-stars');
      avgStars.innerHTML = '';
      const roundedAvg = Math.round(parseFloat(avg));
      for (let i = 1; i <= 5; i++) {
        avgStars.innerHTML += `<i data-lucide="star" class="w-4 h-4 text-amber-400 ${i <= roundedAvg ? 'fill-current' : 'text-gray-300 fill-none'}"></i>`;
      }

      // Calculate rating breakdown statistics
      const totalReviews = reviews.length;
      const counts = { 5: 0, 4: 0, 3: 0, 2: 0, 1: 0 };
      reviews.forEach(r => {
        if (counts[r.rating] !== undefined) counts[r.rating]++;
      });
      
      for (let star = 5; star >= 1; star--) {
        const count = counts[star];
        const pct = totalReviews > 0 ? Math.round((count / totalReviews) * 100) : 0;
        const bar = document.getElementById(`bar-${star}-star`);
        const pctText = document.getElementById(`pct-${star}-star`);
        if (bar) bar.style.width = pct + '%';
        if (pctText) pctText.textContent = pct + '%';
      }

      list.innerHTML = '';
      if (reviews.length === 0) {
        list.innerHTML = `<p class="text-sm text-gray-400 italic">Chưa có đánh giá nào cho sản phẩm này. Hãy mua sản phẩm và viết cảm nhận đầu tiên của bạn!</p>`;
      } else {
        reviews.forEach(r => {
          let stars = '';
          for (let i = 1; i <= 5; i++) {
            stars += `<i data-lucide="star" class="w-3.5 h-3.5 text-amber-400 ${i <= r.rating ? 'fill-current' : 'text-gray-300 fill-none'}"></i>`;
          }
          
          const reviewDate = r.created_at ? new Date(r.created_at).toLocaleDateString('vi-VN') : 'Vừa xong';
          list.innerHTML += `
            <div class="bg-gray-50 p-4 rounded-2xl space-y-2 border border-gray-100">
              <div class="flex items-center justify-between">
                <div>
                  <h5 class="font-bold text-sm text-gray-800">${r.customer_name}</h5>
                  <div class="flex items-center gap-0.5 mt-0.5">${stars}</div>
                </div>
                <span class="text-xs text-gray-400 font-semibold">${reviewDate}</span>
              </div>
              <p class="text-sm text-gray-600 font-light leading-relaxed">${r.comment}</p>
            </div>`;
        });
      }
      lucide.createIcons();
    }

    const starButtons = document.querySelectorAll('#star-rating-select button');
    starButtons.forEach(btn => {
      btn.onclick = () => {
        userReviewRating = parseInt(btn.dataset.rating);
        starButtons.forEach((b, i) => {
          if (i < userReviewRating) {
            b.classList.remove('text-gray-300');
            b.classList.add('text-amber-400');
          } else {
            b.classList.remove('text-amber-400');
            b.classList.add('text-gray-300');
          }
        });
      };
    });

    document.getElementById('review-form').onsubmit = async (e) => {
      e.preventDefault();
      const name = document.getElementById('review-name').value;
      const comment = document.getElementById('review-comment').value;

      const bodyData = {
        product_id: currentDetailProductId,
        customer_name: name,
        rating: userReviewRating,
        comment
      };

      try {
        const res = await fetch('/api/reviews', {
          method: 'POST',
          headers,
          body: JSON.stringify(bodyData)
        });

        const data = await res.json();
        
        if (res.ok) {
          showToast('Cảm ơn bạn đã gửi đánh giá sản phẩm!');
          await renderProductDetailPage(currentDetailProductId);
          
          document.getElementById('review-name').value = '';
          document.getElementById('review-email').value = '';
          document.getElementById('review-comment').value = '';
          userReviewRating = 5;
          starButtons.forEach(b => b.classList.add('text-amber-400'));
        } else {
          showToast(data.message || 'Lỗi gửi đánh giá', 'info');
        }
      } catch (err) {
        showToast('Lỗi gửi đánh giá, vui lòng thử lại', 'info');
      }
    };

    function renderRelatedProducts(product) {
      const grid = document.getElementById('related-product-grid');
      grid.innerHTML = '';
      
      const related = productsState.filter(p => p.category_id === product.category_id && p.id !== product.id).slice(0, 4);
      const displayRelated = related.length > 0 ? related : productsState.filter(p => p.id !== product.id).slice(0, 4);

      displayRelated.forEach(p => {
        const isFav = wishlistState.includes(p.id.toString());
        const favIconClass = isFav ? 'text-red-500 fill-current' : 'text-gray-400 fill-transparent hover:text-red-500';
        
        grid.innerHTML += `
          <div class="product-card group cursor-pointer bg-white p-4 rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-300 relative flex flex-col justify-between" onclick="window.location.hash = '#/product/${p.id}'">
            <button onclick="toggleWishlist('${p.id}', event)" class="absolute top-6 right-6 z-10 w-9 h-9 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-transform">
              <i data-lucide="heart" class="w-4 h-4 ${favIconClass}"></i>
            </button>
            
            <div class="relative bg-[#faf9f7] rounded-xl overflow-hidden mb-3 aspect-[3/4] flex items-center justify-center">
              <img src="${p.thumbnail_url}" alt="${p.name}" class="product-img w-full h-full object-cover">
              
              <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center pb-4">
                <button class="bg-[#1a1a1a] text-white text-[10px] font-bold px-4 py-2.5 rounded-full shadow-lg hover:bg-[#c45e3a] transition transform translate-y-2 group-hover:translate-y-0 duration-300" onclick="event.stopPropagation(); quickAddToCart('${p.id}')">
                  + Thêm nhanh vào giỏ
                </button>
              </div>
            </div>
            <div>
              <h3 class="font-bold text-sm text-gray-800 line-clamp-1 group-hover:text-[#c45e3a] transition">${p.name}</h3>
              <span class="font-bold text-sm text-[#c45e3a] mt-1 block">${formatVND(p.price)}</span>
            </div>
          </div>`;
      });
      lucide.createIcons();
    }

    // -------------------------------------------------------------
    // Shopping Cart State & View Actions
    // -------------------------------------------------------------
    function addToCartState(productId, quantity, size, color, customPrice) {
      if (!authUser) {
        showToast('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!', 'info');
        openAuthModal();
        return;
      }
      const existing = cartState.find(item => item.productId.toString() === productId.toString() && item.size === size && item.color === color);
      if (existing) {
        existing.quantity += quantity;
      } else {
        cartState.push({ productId, quantity, size, color, price: customPrice });
      }
      localStorage.setItem('beestyle_cart', JSON.stringify(cartState));
      updateCartBadge();
      renderCartDrawer();
    }

    async function quickAddToCart(productId) {
      if (!authUser) {
        showToast('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!', 'info');
        openAuthModal();
        return;
      }
      await ensureProductsLoaded();
      const product = productsState.find(p => p.id.toString() === productId.toString());
      if (product) {
        const sizes = product.sizes ? product.sizes.split(',').map(s => s.trim()) : ['Free Size'];
        const colors = product.colors ? product.colors.split(',').map(c => c.trim()) : ['Mặc định'];
        addToCartState(productId, 1, sizes[0], colors[0], product.price);
        showToast('Đã thêm sản phẩm vào giỏ hàng!');
      }
    }

    function removeCartItem(index, event) {
      if (event) event.stopPropagation();
      cartState.splice(index, 1);
      localStorage.setItem('beestyle_cart', JSON.stringify(cartState));
      updateCartBadge();
      renderCartDrawer();
      if (window.location.hash === '#/cart') renderCartPage();
      showToast('Đã xóa sản phẩm khỏi giỏ hàng.', 'info');
    }

    function updateCartItemQty(index, newQty) {
      if (newQty < 1) newQty = 1;
      cartState[index].quantity = newQty;
      localStorage.setItem('beestyle_cart', JSON.stringify(cartState));
      updateCartBadge();
      renderCartDrawer();
      if (window.location.hash === '#/cart') renderCartPage();
    }

    // -------------------------------------------------------------
    // Page Rendering: CART Drawer & Page
    // -------------------------------------------------------------
    async function renderCartDrawer() {
      const drawerItems = document.getElementById('cart-drawer-items');
      const drawerEmpty = document.getElementById('cart-drawer-empty');
      const drawerFooter = document.getElementById('cart-drawer-footer');
      
      drawerItems.innerHTML = '';
      
      if (cartState.length === 0) {
        drawerEmpty.classList.remove('hidden');
        drawerFooter.classList.add('hidden');
        return;
      }
      
      drawerEmpty.classList.add('hidden');
      drawerFooter.classList.remove('hidden');

      await ensureProductsLoaded();

      let subtotal = 0;

      cartState.forEach((item, index) => {
        const prod = productsState.find(p => p.id.toString() === item.productId.toString());
        if (!prod) return;

        const itemPrice = item.price !== undefined ? item.price : prod.price;
        const itemTotal = itemPrice * item.quantity;
        subtotal += itemTotal;

        drawerItems.innerHTML += `
          <div class="flex gap-4 p-3 bg-white border border-gray-100 rounded-2xl shadow-sm relative group">
            <div class="w-16 h-20 bg-[#f5f0ea] rounded-xl overflow-hidden shrink-0 flex items-center justify-center">
              <img src="${prod.thumbnail_url}" alt="${prod.name}" class="w-full h-full object-cover">
            </div>
            
            <div class="flex-1 flex flex-col justify-between">
              <div>
                <h4 class="font-bold text-xs text-gray-800 line-clamp-1">${prod.name}</h4>
                <p class="text-[10px] text-gray-400 mt-0.5">Size: ${item.size} · Màu: ${item.color}</p>
              </div>
              
              <div class="flex items-center justify-between mt-1">
                <div class="flex border border-gray-200 rounded-full bg-white overflow-hidden">
                  <button onclick="updateCartItemQty(${index}, ${item.quantity - 1})" class="px-2 py-1 hover:bg-gray-100 transition text-xs font-semibold">-</button>
                  <span class="w-6 text-center text-xs self-center font-bold">${item.quantity}</span>
                  <button onclick="updateCartItemQty(${index}, ${item.quantity + 1})" class="px-2 py-1 hover:bg-gray-100 transition text-xs font-semibold">+</button>
                </div>
                <span class="text-xs font-bold text-[#c45e3a]">${formatVND(itemPrice)}</span>
              </div>
            </div>
            
            <button onclick="removeCartItem(${index}, event)" class="absolute top-2 right-2 text-gray-300 hover:text-red-500 transition">
              <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
          </div>`;
      });

      document.getElementById('cart-drawer-subtotal').textContent = formatVND(subtotal);
      document.getElementById('cart-drawer-total').textContent = formatVND(subtotal);
      lucide.createIcons();
    }

    async function renderCartPage() {
      const wrapper = document.getElementById('cart-items-wrapper');
      const summary = document.getElementById('cart-summary-wrapper');
      
      wrapper.innerHTML = '';
      summary.innerHTML = '';

      if (cartState.length === 0) {
        wrapper.innerHTML = `
          <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm p-6 col-span-3">
            <span class="text-6xl block mb-4">🛒</span>
            <h3 class="font-heading text-2xl font-bold text-gray-800">Giỏ hàng trống</h3>
            <p class="text-gray-400 text-sm mt-2 max-w-sm mx-auto">Chưa có sản phẩm nào được chọn. Hãy ghé qua cửa hàng thời trang Beestyle của chúng tôi để mua sắm ngay.</p>
            <a href="#/shop" class="bg-[#1a1a1a] hover:bg-[#c45e3a] text-white text-xs font-bold px-8 py-3.5 rounded-full mt-6 inline-block transition shadow-lg">Tiếp Tục Mua Sắm</a>
          </div>`;
        return;
      }

      await ensureProductsLoaded();

      let subtotal = 0;

      let itemsHtml = `<div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm space-y-4">`;
      cartState.forEach((item, index) => {
        const prod = productsState.find(p => p.id.toString() === item.productId.toString());
        if (!prod) return;

        const itemPrice = item.price !== undefined ? item.price : prod.price;
        const itemTotal = itemPrice * item.quantity;
        subtotal += itemTotal;

        itemsHtml += `
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 py-4 ${index > 0 ? 'border-t border-gray-100' : ''}">
            <div class="flex gap-4">
              <div class="w-16 h-20 bg-gray-50 rounded-xl overflow-hidden shrink-0">
                <img src="${prod.thumbnail_url}" alt="${prod.name}" class="w-full h-full object-cover">
              </div>
              <div>
                <h4 class="font-bold text-sm text-gray-800 hover:text-[#c45e3a] cursor-pointer" onclick="window.location.hash = '#/product/${prod.id}'">${prod.name}</h4>
                <p class="text-xs text-gray-400 mt-1">Kích cỡ: <span class="font-bold">${item.size}</span> · Màu sắc: <span class="font-bold">${item.color}</span></p>
                <div class="sm:hidden flex items-center gap-4 mt-2">
                  <span class="text-sm font-bold text-[#c45e3a]">${formatVND(itemPrice)}</span>
                </div>
              </div>
            </div>
            
            <div class="flex sm:flex-row items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
              <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 font-semibold sm:hidden">Số lượng:</span>
                <div class="flex border border-gray-200 rounded-full bg-white overflow-hidden">
                  <button onclick="updateCartItemQty(${index}, ${item.quantity - 1})" class="px-3 py-1.5 hover:bg-gray-100 transition text-sm font-semibold">-</button>
                  <span class="w-8 text-center text-sm self-center font-bold">${item.quantity}</span>
                  <button onclick="updateCartItemQty(${index}, ${item.quantity + 1})" class="px-3 py-1.5 hover:bg-gray-100 transition text-sm font-semibold">+</button>
                </div>
              </div>
              
              <div class="text-right hidden sm:block">
                <p class="text-xs text-gray-400">Thành tiền</p>
                <p class="text-sm font-bold text-gray-800">${formatVND(itemTotal)}</p>
              </div>
              
              <button onclick="removeCartItem(${index}, event)" class="text-gray-300 hover:text-red-500 transition p-2 hover:bg-gray-50 rounded-full">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
              </button>
            </div>
          </div>`;
      });
      itemsHtml += `</div>`;
      wrapper.innerHTML = itemsHtml;

      let discountAmount = 0;
      let finalTotal = subtotal;

      if (appliedVoucher) {
        discountAmount = appliedVoucher.discount_amount;
        finalTotal = Math.max(0, subtotal - discountAmount);
      }

      summary.innerHTML = `
        <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm space-y-6">
          <h3 class="font-bold text-lg text-gray-800 border-b border-gray-100 pb-2">Tóm tắt đơn hàng</h3>
          
          <div class="space-y-3 text-sm">
            <div class="flex justify-between text-gray-500">
              <span>Tạm tính</span>
              <span class="font-semibold text-gray-800">${formatVND(subtotal)}</span>
            </div>
            ${appliedVoucher ? `
              <div class="flex justify-between text-green-600 font-semibold">
                <span>Voucher (${appliedVoucher.code})</span>
                <span>-${formatVND(discountAmount)}</span>
              </div>
            ` : ''}
            <div class="flex justify-between text-gray-500">
              <span>Phí vận chuyển</span>
              <span class="font-semibold text-green-600">Miễn phí</span>
            </div>
            <div class="border-t border-gray-100 pt-3 flex justify-between font-bold text-base text-gray-800">
              <span>Tổng cộng</span>
              <span class="text-[#c45e3a] text-lg">${formatVND(finalTotal)}</span>
            </div>
          </div>
          
          <div class="space-y-2">
            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Mã giảm giá</label>
            <div class="flex gap-2">
              <input type="text" id="voucher-input" placeholder="Nhập mã code..." value="${appliedVoucher ? appliedVoucher.code : ''}" class="flex-1 px-4 py-2 text-sm border border-gray-200 rounded-xl outline-none focus:border-[#c45e3a] uppercase font-mono">
              <button onclick="applyVoucherCode()" class="bg-[#1a1a1a] hover:bg-[#c45e3a] text-white text-xs font-semibold px-4 py-2 rounded-xl transition">Áp dụng</button>
            </div>
            ${appliedVoucher ? `
              <p class="text-xs text-green-600 font-semibold flex items-center gap-1 mt-1">
                ✓ Đã áp dụng mã giảm giá thành công.
                <button onclick="removeVoucher()" class="text-red-500 underline ml-2 hover:text-red-700">Hủy</button>
              </p>
            ` : `
              <p class="text-[10px] text-gray-400">Gợi ý: Thử nhập mã <span class="font-bold text-gray-600">BEESTYLE30</span></p>
            `}
          </div>
          
          <a href="#/checkout" class="w-full text-center bg-[#1a1a1a] hover:bg-[#c45e3a] text-white py-4 rounded-full font-bold shadow-lg transition block text-sm">
            Tiến Hành Thanh Toán
          </a>
        </div>`;
      
      lucide.createIcons();
    }

    async function applyVoucherCode() {
      const code = document.getElementById('voucher-input').value.toUpperCase().trim();
      if (code === '') return;

      let subtotal = 0;
      cartState.forEach(item => {
        const prod = productsState.find(p => p.id.toString() === item.productId.toString());
        if (prod) subtotal += prod.price * item.quantity;
      });

      try {
        const res = await fetch('/api/vouchers/apply', {
          method: 'POST',
          headers,
          body: JSON.stringify({ code, order_value: subtotal })
        });

        const data = await res.json();

        if (res.ok) {
          appliedVoucher = {
            id: data.voucher_id,
            code: data.code,
            discount_amount: data.discount_amount
          };
          showToast('Áp dụng mã giảm giá ' + code + ' thành công!');
          renderCartPage();
        } else {
          showToast(data.message || 'Mã giảm giá không hợp lệ', 'info');
          appliedVoucher = null;
          renderCartPage();
        }
      } catch (err) {
        showToast('Lỗi áp dụng mã giảm giá', 'info');
      }
    }

    function removeVoucher() {
      appliedVoucher = null;
      showToast('Đã hủy áp dụng mã giảm giá.', 'info');
      renderCartPage();
    }

    // -------------------------------------------------------------
    // Page Rendering: CHECKOUT & PLACE ORDER
    // -------------------------------------------------------------
    async function renderCheckoutPage() {
      if (cartState.length === 0) {
        window.location.hash = '#/cart';
        return;
      }

      await ensureProductsLoaded();

      const itemsList = document.getElementById('checkout-items-list');
      const summaryCalc = document.getElementById('checkout-summary-calc');
      
      itemsList.innerHTML = '';
      let subtotal = 0;

      cartState.forEach(item => {
        const prod = productsState.find(p => p.id.toString() === item.productId.toString());
        if (!prod) return;

        const itemPrice = item.price !== undefined ? item.price : prod.price;
        const totalItemPrice = itemPrice * item.quantity;
        subtotal += totalItemPrice;

        itemsList.innerHTML += `
          <div class="flex items-center gap-3 py-3">
            <div class="w-12 h-14 bg-[#f5f0ea] rounded-lg overflow-hidden shrink-0 flex items-center justify-center">
              <img src="${prod.thumbnail_url}" alt="${prod.name}" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 text-xs">
              <h4 class="font-bold text-gray-800 line-clamp-1">${prod.name}</h4>
              <p class="text-gray-400 mt-0.5">${item.size} · ${item.color} · Qty: ${item.quantity}</p>
            </div>
            <span class="text-xs font-bold text-gray-700">${formatVND(totalItemPrice)}</span>
          </div>`;
      });

      let discount = 0;
      let total = subtotal;

      if (appliedVoucher) {
        discount = appliedVoucher.discount_amount;
        total = Math.max(0, subtotal - discount);
      }

      summaryCalc.innerHTML = `
        <div class="flex justify-between text-gray-500">
          <span>Tạm tính</span>
          <span class="font-semibold text-gray-700">${formatVND(subtotal)}</span>
        </div>
        ${appliedVoucher ? `
          <div class="flex justify-between text-green-600 font-semibold">
            <span>Voucher giảm giá</span>
            <span>-${formatVND(discount)}</span>
          </div>
        ` : ''}
        <div class="flex justify-between text-gray-500">
          <span>Phí vận chuyển</span>
          <span class="font-semibold text-green-600">Miễn phí</span>
        </div>
        <div class="border-t border-gray-100 pt-3 flex justify-between font-bold text-base text-gray-800">
          <span>Tổng cộng</span>
          <span class="text-[#c45e3a] text-lg">${formatVND(total)}</span>
        </div>`;

      const paymentRadios = document.querySelectorAll('input[name="payment-method"]');
      const bankInfo = document.getElementById('bank-info');
      
      paymentRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
          if (e.target.value === 'bank') {
            bankInfo.classList.remove('hidden');
          } else {
            bankInfo.classList.add('hidden');
          }
        });
      });

      // Update checkout voucher status
      const voucherInput = document.getElementById('checkout-voucher-input');
      const voucherStatus = document.getElementById('checkout-voucher-status');
      if (voucherInput) {
        voucherInput.value = appliedVoucher ? appliedVoucher.code : '';
      }
      if (voucherStatus) {
        voucherStatus.innerHTML = appliedVoucher ? `
          <p class="text-xs text-green-600 font-semibold flex items-center gap-1 mt-1">
            ✓ Đã áp dụng mã giảm giá thành công.
            <button type="button" onclick="removeCheckoutVoucher()" class="text-red-500 underline ml-2 hover:text-red-700">Hủy</button>
          </p>
        ` : `
          <p class="text-[10px] text-gray-400">Gợi ý: Thử nhập mã <span class="font-bold text-gray-600">BEESTYLE30</span></p>
        `;
      }
    }

    async function applyCheckoutVoucherCode() {
      const codeInput = document.getElementById('checkout-voucher-input');
      if (!codeInput) return;
      const code = codeInput.value.toUpperCase().trim();
      if (code === '') return;

      let subtotal = 0;
      cartState.forEach(item => {
        const prod = productsState.find(p => p.id.toString() === item.productId.toString());
        if (prod) subtotal += prod.price * item.quantity;
      });

      try {
        const res = await fetch('/api/vouchers/apply', {
          method: 'POST',
          headers,
          body: JSON.stringify({ code, order_value: subtotal })
        });

        const data = await res.json();

        if (res.ok) {
          appliedVoucher = {
            id: data.voucher_id,
            code: data.code,
            discount_amount: data.discount_amount
          };
          showToast('Áp dụng mã giảm giá ' + code + ' thành công!');
          await renderCheckoutPage();
        } else {
          showToast(data.message || 'Mã giảm giá không hợp lệ', 'info');
          appliedVoucher = null;
          await renderCheckoutPage();
        }
      } catch (err) {
        showToast('Lỗi áp dụng mã giảm giá', 'info');
      }
    }

    function removeCheckoutVoucher() {
      appliedVoucher = null;
      showToast('Đã hủy áp dụng mã giảm giá.', 'info');
      renderCheckoutPage();
    }

    document.getElementById('checkout-form').onsubmit = async (e) => {
      e.preventDefault();
      
      const name = document.getElementById('checkout-name').value;
      const phone = document.getElementById('checkout-phone').value;
      const address = document.getElementById('checkout-address').value;
      const note = document.getElementById('checkout-note').value;
      const paymentMethod = document.querySelector('input[name="payment-method"]:checked').value;
      
      let subtotal = 0;
      const orderItems = cartState.map(item => {
        const prod = productsState.find(p => p.id.toString() === item.productId.toString());
        const itemPrice = item.price !== undefined ? item.price : (prod ? prod.price : 0);
        const itemTotal = itemPrice * item.quantity;
        subtotal += itemTotal;
        return {
          product_id: item.productId,
          price: itemPrice,
          quantity: item.quantity,
          size: item.size,
          color: item.color
        };
      });

      let discount = 0;
      if (appliedVoucher) {
        discount = appliedVoucher.discount_amount;
      }
      
      const total = Math.max(0, subtotal - discount);

      const orderData = {
        customer_name: name,
        customer_phone: phone,
        customer_address: address,
        customer_note: note,
        payment_method: paymentMethod,
        items: orderItems,
        total_amount: total,
        voucher_id: appliedVoucher ? appliedVoucher.id : null
      };

      if (paymentMethod === 'online_vnpay') {
        pendingOrderData = orderData;
        
        // Show online payment modal
        document.getElementById('online-payment-order-id').innerText = '#' + Math.floor(Math.random() * 90000 + 10000);
        document.getElementById('online-payment-amount').innerText = formatVND(total);
        
        const modal = document.getElementById('online-payment-modal');
        modal.classList.remove('hidden');
        
        let secondsLeft = 300;
        const timerLabel = document.getElementById('online-payment-timer');
        timerLabel.innerText = `Giao dịch hết hạn sau: 05:00`;
        
        if (onlinePaymentTimerInterval) {
          clearInterval(onlinePaymentTimerInterval);
        }
        
        onlinePaymentTimerInterval = setInterval(() => {
          secondsLeft--;
          if (secondsLeft <= 0) {
            clearInterval(onlinePaymentTimerInterval);
            onlinePaymentTimerInterval = null;
            modal.classList.add('hidden');
            showToast('Giao dịch trực tuyến đã hết hạn!', 'info');
          } else {
            const m = Math.floor(secondsLeft / 60).toString().padStart(2, '0');
            const s = (secondsLeft % 60).toString().padStart(2, '0');
            timerLabel.innerText = `Giao dịch hết hạn sau: ${m}:${s}`;
          }
        }, 1000);
        
        return;
      }

      try {
        const res = await fetch('/api/orders', {
          method: 'POST',
          headers,
          body: JSON.stringify(orderData)
        });

        const data = await res.json();

        if (res.ok) {
          const savedIds = JSON.parse(localStorage.getItem('beestyle_order_ids') || '[]');
          savedIds.unshift(data.order_id);
          localStorage.setItem('beestyle_order_ids', JSON.stringify(savedIds));

          cartState = [];
          localStorage.setItem('beestyle_cart', JSON.stringify(cartState));
          updateCartBadge();
          renderCartDrawer();
          appliedVoucher = null;

          showToast('Đặt hàng thành công! Cám ơn bạn đã lựa chọn Beestyle.');
          window.location.hash = '#/orders';
        } else {
          showToast(data.message || 'Lỗi đặt hàng, vui lòng thử lại', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ khi đặt hàng', 'info');
      }
    };

    // -------------------------------------------------------------
    // Page Rendering: ORDER PURCHASE HISTORY
    // -------------------------------------------------------------
    async function renderOrdersPage() {
      const container = document.getElementById('orders-list-container');
      container.innerHTML = '<div class="text-center py-20 text-gray-400">Đang tải lịch sử mua hàng...</div>';

      const savedIds = JSON.parse(localStorage.getItem('beestyle_order_ids') || '[]');
      
      if (savedIds.length === 0) {
        container.innerHTML = `
          <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
            <span class="text-6xl block mb-4">📦</span>
            <h3 class="font-heading text-2xl font-bold text-gray-800">Chưa có đơn hàng nào</h3>
            <p class="text-gray-400 text-sm mt-2 max-w-sm mx-auto">Bạn chưa thực hiện đơn đặt hàng nào tại cửa hàng của chúng tôi.</p>
            <a href="#/shop" class="bg-[#1a1a1a] hover:bg-[#c45e3a] text-white text-xs font-bold px-8 py-3.5 rounded-full mt-6 inline-block transition">Mua Sắm Ngay</a>
          </div>`;
        return;
      }

      try {
        const params = new URLSearchParams();
        savedIds.forEach(id => params.append('order_ids[]', id));

        const res = await fetch('/api/orders?' + params.toString());
        const orders = await res.json();

        container.innerHTML = '';
        if (orders.length === 0) {
          container.innerHTML = `
            <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
              <span class="text-6xl block mb-4">📦</span>
              <h3 class="font-heading text-2xl font-bold text-gray-800">Chưa có đơn hàng nào</h3>
              <p class="text-gray-400 text-sm mt-2 max-w-sm mx-auto">Bạn chưa thực hiện đơn đặt hàng nào tại cửa hàng của chúng tôi.</p>
              <a href="#/shop" class="bg-[#1a1a1a] hover:bg-[#c45e3a] text-white text-xs font-bold px-8 py-3.5 rounded-full mt-6 inline-block transition">Mua Sắm Ngay</a>
            </div>`;
          return;
        }

        orders.forEach(order => {
          let statusText = 'Chờ xử lý';
          let statusBadgeClass = 'bg-yellow-50 text-yellow-600 border border-yellow-200';
          
          if (order.status === 'Processing') {
            statusText = 'Đang xử lý';
            statusBadgeClass = 'bg-yellow-100 text-yellow-700 border border-yellow-300';
          } else if (order.status === 'Shipping') {
            statusText = 'Đang giao hàng';
            statusBadgeClass = 'bg-blue-50 text-blue-600 border border-blue-200';
          } else if (order.status === 'Completed') {
            statusText = 'Đã giao thành công';
            statusBadgeClass = 'bg-green-50 text-green-600 border border-green-200';
          } else if (order.status === 'Cancelled') {
            statusText = 'Đã hủy đơn';
            statusBadgeClass = 'bg-red-50 text-red-600 border border-red-200';
          }

          const itemsSummary = order.order_items.map(item => {
            const prodName = item.product ? item.product.name : 'Sản phẩm đã xóa';
            return `
              <div class="flex justify-between items-center text-xs py-2 text-gray-600">
                <span>${prodName} <span class="text-gray-400">(${item.size || 'Free'} · ${item.color || 'Mặc định'})</span> x${item.quantity}</span>
                <span class="font-bold">${formatVND(item.price * item.quantity)}</span>
              </div>
            `;
          }).join('');

          const orderDate = new Date(order.created_at).toLocaleString('vi-VN');

          container.innerHTML += `
            <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm space-y-4">
              <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-gray-100 pb-3 gap-2">
                <div>
                  <span class="text-sm font-bold text-gray-800">Đơn hàng: <span class="font-mono text-[#c45e3a]">#${order.id}</span></span>
                  <span class="text-xs text-gray-400 ml-2 font-semibold">${orderDate}</span>
                </div>
                <span class="text-xs px-3 py-1 rounded-full font-semibold ${statusBadgeClass}">${statusText}</span>
              </div>
              
              <div class="divide-y divide-gray-50">
                ${itemsSummary}
              </div>
              
              <div class="border-t border-gray-100 pt-3 flex flex-col sm:flex-row justify-between text-xs gap-3">
                <div class="space-y-1 text-gray-500 font-light">
                  <p>📍 Người nhận: <span class="font-semibold text-gray-700">${order.customer_name} - ${order.customer_phone}</span></p>
                  <p>🏠 Địa chỉ: <span class="font-semibold text-gray-700">${order.customer_address}</span></p>
                  <p>💳 Thanh toán: <span class="font-semibold text-gray-700 uppercase">${order.payment_method === 'cod' ? 'Tiền mặt khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng'}</span></p>
                </div>
                
                <div class="text-right sm:self-end">
                  <p class="text-gray-400 font-semibold">Tổng thanh toán</p>
                  <p class="text-lg font-bold text-[#c45e3a]">${formatVND(order.total_amount)}</p>
                </div>
              </div>
              
              <div class="flex justify-between items-center pt-2">
                <a href="#/order-detail/${order.id}" class="text-xs text-[#c45e3a] hover:underline font-semibold flex items-center gap-1">
                  Xem chi tiết đơn hàng →
                </a>
                ${order.status === 'Pending' ? `
                  <button onclick="cancelClientOrder('${order.id}')" class="text-xs text-red-500 hover:text-red-700 font-semibold border border-red-100 hover:bg-red-50 px-3.5 py-1.5 rounded-xl transition">Hủy yêu cầu đặt hàng</button>
                ` : ''}
              </div>
            </div>`;
        });
        lucide.createIcons();
      } catch (err) {
        container.innerHTML = '<div class="text-center py-20 text-red-500">Lỗi tải danh sách đơn hàng. Vui lòng thử lại.</div>';
      }
    }

    async function cancelClientOrder(orderId) {
      if (confirm('Bạn chắc chắn muốn hủy đơn hàng #' + orderId + ' chứ?')) {
        try {
          const res = await fetch(`/api/orders/${orderId}/cancel`, {
            method: 'PUT',
            headers
          });
          const data = await res.json();
          if (res.ok) {
            await renderOrdersPage();
            showToast('Hủy đơn hàng thành công!');
          } else {
            showToast(data.message || 'Không thể hủy đơn hàng lúc này', 'info');
          }
        } catch (err) {
          showToast('Lỗi kết nối máy chủ', 'info');
        }
      }
    }

    function clearOrderHistory() {
      if (confirm('Bạn muốn xóa toàn bộ lịch sử mua hàng trên trình duyệt này?')) {
        localStorage.removeItem('beestyle_order_ids');
        renderOrdersPage();
        showToast('Đã dọn dẹp lịch sử đặt hàng.', 'info');
      }
    }

    // --- USER PROFILE PAGE ---
    function renderProfilePage() {
      if (!authUser) {
        showToast('Vui lòng đăng nhập để xem thông tin tài khoản!', 'info');
        window.location.hash = '#/';
        return;
      }
      document.getElementById('profile-name').value = authUser.full_name || '';
      document.getElementById('profile-email').value = authUser.email || '';
      document.getElementById('profile-phone').value = authUser.phone || '';
      document.getElementById('profile-password').value = '';
    }

    async function handleProfileUpdate(e) {
      e.preventDefault();
      const full_name = document.getElementById('profile-name').value.trim();
      const phone = document.getElementById('profile-phone').value.trim();
      const password = document.getElementById('profile-password').value;

      const bodyData = { full_name };
      if (phone) bodyData.phone = phone;
      if (password) bodyData.password = password;

      try {
        const res = await fetch('/api/auth/profile', {
          method: 'PUT',
          headers,
          body: JSON.stringify(bodyData)
        });
        const data = await res.json();
        if (res.ok) {
          showToast('Cập nhật thông tin thành công!');
          authUser = data.user;
          localStorage.setItem('beestyle_user', JSON.stringify(authUser));
          renderAuthUI();
          document.getElementById('profile-password').value = '';
        } else {
          showToast(data.message || 'Lỗi cập nhật thông tin', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    // --- CUSTOMER ORDER DETAIL PAGE ---
    async function renderOrderDetailPage(orderId) {
      currentOrderDetailId = orderId;
      
      const statusBadge = document.getElementById('cust-order-status');
      const stepperNode = document.getElementById('cust-order-stepper');
      const actionDiv = document.getElementById('cust-order-action-div');
      
      try {
        const res = await fetch('/api/orders/' + orderId);
        if (res.status === 404) {
          showToast('Không tìm thấy đơn hàng!', 'info');
          window.location.hash = '#/orders';
          return;
        }
        
        const order = await res.json();

        document.getElementById('cust-order-id').innerText = '#' + order.id;
        
        const orderDate = new Date(order.created_at).toLocaleString('vi-VN');
        document.getElementById('cust-order-date').innerText = 'Đặt ngày: ' + orderDate;

        // Stepper & Status Badge
        let statusText = 'Chờ xử lý';
        let statusColorClass = 'bg-yellow-50 text-yellow-600 border border-yellow-200';
        let stepIndex = 0;

        if (order.status === 'Processing') {
          statusText = 'Đang xử lý';
          statusColorClass = 'bg-yellow-100 text-yellow-700 border border-yellow-300';
          stepIndex = 1;
        } else if (order.status === 'Shipping') {
          statusText = 'Đang giao';
          statusColorClass = 'bg-blue-50 text-blue-600 border border-blue-200';
          stepIndex = 2;
        } else if (order.status === 'Completed') {
          statusText = 'Đã giao hàng';
          statusColorClass = 'bg-green-50 text-green-600 border border-green-200';
          stepIndex = 3;
        } else if (order.status === 'Cancelled') {
          statusText = 'Đã hủy';
          statusColorClass = 'bg-red-50 text-red-600 border border-red-200';
          stepIndex = -1;
        }

        statusBadge.innerText = statusText;
        statusBadge.className = `text-xs px-3 py-1 rounded-full font-semibold ${statusColorClass}`;

        // Stepper HTML
        if (stepIndex === -1) {
          stepperNode.innerHTML = `
            <div class="flex items-center justify-center py-4 w-full">
              <span class="text-red-500 font-bold text-xs bg-red-50 px-4 py-2 border border-red-200 rounded-2xl">ĐƠN HÀNG NÀY ĐÃ BỊ HỦY</span>
            </div>`;
        } else {
          const steps = ['Chờ xử lý', 'Đang xử lý', 'Đang giao', 'Đã giao'];
          let stepperHtml = '';
          
          stepperHtml += `<div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 -translate-y-1/2 z-0"></div>`;
          const pct = stepIndex * 33.33;
          stepperHtml += `<div class="absolute top-1/2 left-0 h-1 bg-emerald-500 -translate-y-1/2 z-0 transition-all duration-500" style="width: ${pct}%"></div>`;

          steps.forEach((step, idx) => {
            const isCompleted = idx <= stepIndex;
            const bgClass = isCompleted ? 'bg-emerald-500 text-white ring-4 ring-emerald-100' : 'bg-gray-200 text-gray-400';
            stepperHtml += `
              <div class="flex flex-col items-center gap-1 z-10">
                <span class="w-6 h-6 rounded-full flex items-center justify-center ${bgClass} transition-colors duration-500 text-[10px]">${idx + 1}</span>
                <span class="${isCompleted ? 'text-gray-800 font-bold' : 'text-gray-400 font-light'} mt-1 transition-colors duration-500">${step}</span>
              </div>`;
          });
          stepperNode.innerHTML = stepperHtml;
        }

        document.getElementById('cust-order-name').innerText = order.customer_name;
        document.getElementById('cust-order-phone').innerText = order.customer_phone;
        document.getElementById('cust-order-address').innerText = order.customer_address;
        document.getElementById('cust-order-note').innerText = order.customer_note || 'Không có';
        
        document.getElementById('cust-order-payment-method').innerText = order.payment_method === 'cod' ? 'COD (Thanh toán khi nhận hàng)' : 'Chuyển khoản / Trực tuyến';
        document.getElementById('cust-order-payment-status').innerText = order.payment_status || 'Chưa thanh toán';

        const tbody = document.getElementById('cust-order-items-tbody');
        tbody.innerHTML = '';
        let subtotal = 0;

        order.order_items.forEach(item => {
          const prod = item.product;
          const name = prod ? prod.name : 'Sản phẩm đã xóa';
          const img = prod ? prod.thumbnail_url : 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=100';
          const size = item.size || 'Free';
          const color = item.color || 'Mặc định';
          const itemPrice = item.price;
          const qty = item.quantity;
          const total = itemPrice * qty;
          subtotal += total;

          tbody.innerHTML += `
            <div class="flex items-center justify-between py-4 text-xs">
              <div class="flex gap-3">
                <div class="w-10 h-12 bg-gray-50 rounded overflow-hidden shrink-0 border border-gray-100">
                  <img src="${img}" class="w-full h-full object-cover">
                </div>
                <div>
                  <h5 class="font-bold text-gray-800">${name}</h5>
                  <p class="text-[10px] text-gray-400 mt-0.5">Phân loại: ${size} · ${color} · Số lượng: ${qty}</p>
                </div>
              </div>
              <span class="font-bold text-gray-800">${formatVND(total)}</span>
            </div>`;
        });

        let discount = 0;
        if (order.voucher) {
          discount = Math.min(order.voucher.max_discount || subtotal, Math.round(subtotal * order.voucher.discount_percent / 100));
        }

        document.getElementById('cust-order-subtotal').innerText = formatVND(subtotal);
        document.getElementById('cust-order-discount').innerText = '-' + formatVND(discount);
        document.getElementById('cust-order-total').innerText = formatVND(order.total_amount);

        if (order.status === 'Pending') {
          actionDiv.classList.remove('hidden');
        } else {
          actionDiv.classList.add('hidden');
        }

      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    async function cancelClientOrderFromDetails() {
      if (!currentOrderDetailId) return;
      if (confirm('Bạn chắc chắn muốn hủy đơn hàng #' + currentOrderDetailId + ' chứ?')) {
        try {
          const res = await fetch(`/api/orders/${currentOrderDetailId}/cancel`, {
            method: 'PUT',
            headers
          });
          const data = await res.json();
          if (res.ok) {
            showToast('Hủy đơn hàng thành công!');
            await renderOrderDetailPage(currentOrderDetailId);
          } else {
            showToast(data.message || 'Không thể hủy đơn hàng lúc này', 'info');
          }
        } catch (err) {
          showToast('Lỗi kết nối máy chủ', 'info');
        }
      }
    }

    // --- PRODUCT VARIANTS AND STOCK ---
    function updateProductDetailsPriceAndImage() {
      if (!currentProductDetails) return;
      let basePrice = currentProductDetails.price;
      let totalPrice = basePrice;
      let variantImage = currentProductDetails.thumbnail_url;

      let variantData = null;
      if (currentProductDetails.variant_data) {
        try {
          variantData = typeof currentProductDetails.variant_data === 'string' 
            ? JSON.parse(currentProductDetails.variant_data) 
            : currentProductDetails.variant_data;
        } catch (e) {
          console.error("Failed to parse variant_data:", e);
        }
      }

      if (variantData) {
        if (variantData.colors && variantData.colors[currentSelectedColor]) {
          const colorVar = variantData.colors[currentSelectedColor];
          if (colorVar.price_offset) {
            totalPrice += parseInt(colorVar.price_offset);
          }
          if (colorVar.image) {
            variantImage = colorVar.image;
          }
        }
        if (variantData.sizes && variantData.sizes[currentSelectedSize]) {
          const sizeVar = variantData.sizes[currentSelectedSize];
          if (sizeVar.price_offset) {
            totalPrice += parseInt(sizeVar.price_offset);
          }
        }
      }

      currentSelectedPrice = totalPrice;
      
      const priceLabel = document.getElementById('detail-product-price');
      if (priceLabel) {
        priceLabel.textContent = formatVND(totalPrice);
      }

      const mainImg = document.getElementById('detail-main-img');
      if (mainImg) {
        mainImg.src = variantImage;
      }
    }

    // --- ONLINE PAYMENT SIMULATION ---
    function closeOnlinePaymentModal() {
      document.getElementById('online-payment-modal').classList.add('hidden');
      if (onlinePaymentTimerInterval) {
        clearInterval(onlinePaymentTimerInterval);
        onlinePaymentTimerInterval = null;
      }
      showToast('Thanh toán giả lập đã bị hủy.', 'info');
    }

    async function confirmOnlinePayment() {
      if (!pendingOrderData) return;
      document.getElementById('online-payment-modal').classList.add('hidden');
      if (onlinePaymentTimerInterval) {
        clearInterval(onlinePaymentTimerInterval);
        onlinePaymentTimerInterval = null;
      }

      try {
        const res = await fetch('/api/orders', {
          method: 'POST',
          headers,
          body: JSON.stringify(pendingOrderData)
        });

        const data = await res.json();

        if (res.ok) {
          const savedIds = JSON.parse(localStorage.getItem('beestyle_order_ids') || '[]');
          savedIds.unshift(data.order_id);
          localStorage.setItem('beestyle_order_ids', JSON.stringify(savedIds));

          cartState = [];
          localStorage.setItem('beestyle_cart', JSON.stringify(cartState));
          updateCartBadge();
          renderCartDrawer();
          appliedVoucher = null;

          showToast('Đặt hàng và thanh toán trực tuyến thành công!');
          window.location.hash = '#/orders';
        } else {
          showToast(data.message || 'Lỗi đặt hàng, vui lòng thử lại', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ khi đặt hàng', 'info');
      } finally {
        pendingOrderData = null;
      }
    }

    // -------------------------------------------------------------
    // Header Navigation Dialogs/Interactions (Search & Cart Drawer)
    // -------------------------------------------------------------
    const searchOverlay = document.getElementById('search-overlay');
    const searchBox = document.getElementById('search-box');
    const searchInput = document.getElementById('search-input');
    const searchResultsBox = document.getElementById('search-results-box');
    const searchResultsList = document.getElementById('search-results-list');
    
    document.getElementById('search-btn').onclick = () => {
      searchOverlay.classList.remove('hidden');
      setTimeout(() => {
        searchBox.classList.remove('opacity-0', 'scale-95');
        searchInput.focus();
      }, 50);
    };

    function closeSearchOverlay() {
      searchBox.classList.add('opacity-0', 'scale-95');
      setTimeout(() => {
        searchOverlay.classList.add('hidden');
        searchInput.value = '';
        searchResultsBox.classList.add('hidden');
      }, 200);
    }

    document.getElementById('close-search').onclick = closeSearchOverlay;
    searchOverlay.onclick = (e) => {
      if (e.target === searchOverlay) closeSearchOverlay();
    };

    searchInput.addEventListener('input', (e) => {
      const q = e.target.value.toLowerCase().trim();
      if (q === '') {
        searchResultsBox.classList.add('hidden');
        return;
      }

      const matching = productsState.filter(p => p.name.toLowerCase().includes(q) || p.category_id.toString() === q).slice(0, 5);
      
      searchResultsList.innerHTML = '';
      if (matching.length === 0) {
        searchResultsList.innerHTML = `<p class="text-xs text-gray-400 italic py-2">Không tìm thấy sản phẩm phù hợp.</p>`;
      } else {
        matching.forEach(p => {
          searchResultsList.innerHTML += `
            <div onclick="window.location.hash = '#/product/${p.id}'; closeSearchOverlay();" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-xl cursor-pointer transition">
              <div class="w-8 h-10 bg-gray-50 rounded overflow-hidden shrink-0">
                <img src="${p.thumbnail_url}" class="w-full h-full object-cover">
              </div>
              <div class="flex-1 text-xs text-left">
                <h5 class="font-bold text-gray-800 line-clamp-1">${p.name}</h5>
                <span class="font-semibold text-[#c45e3a] mt-0.5 block">${formatVND(p.price)}</span>
              </div>
            </div>`;
        });
      }
      searchResultsBox.classList.remove('hidden');
    });

    function quickSearch(val) {
      closeSearchOverlay();
      window.location.hash = `#/shop?search=${val}`;
    }

    const cartDrawer = document.getElementById('cart-drawer');
    const cartPanel = document.getElementById('cart-panel');
    const cartBtn = document.getElementById('cart-btn');
    
    cartBtn.onclick = () => {
      renderCartDrawer();
      cartDrawer.classList.remove('hidden');
      setTimeout(() => {
        cartPanel.classList.remove('translate-x-full');
      }, 50);
    };

    function closeCart() {
      cartPanel.classList.add('translate-x-full');
      setTimeout(() => {
        cartDrawer.classList.add('hidden');
      }, 250);
    }

    document.getElementById('close-cart').onclick = closeCart;
    document.getElementById('cart-backdrop').onclick = closeCart;

    document.getElementById('menu-btn').onclick = () => {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    };

    // -------------------------------------------------------------
    // Element SDK Fallback Integration
    // -------------------------------------------------------------
    const defaultConfig = {
      brand_name: 'Beestyle',
      hero_title: 'Nâng tầm\nphong cách\ncủa bạn',
      hero_subtitle: 'Thời trang cao cấp, tối giản nhưng đậm chất riêng. Hãy khám phá và tự tin tỏa sáng mỗi ngày cùng Beestyle.',
      background_color: '#faf9f7',
      text_color: '#1a1a1a',
      accent_color: '#c45e3a',
    };

    function applyConfig(config) {
      const brandNodes = document.querySelectorAll('#brand-name');
      brandNodes.forEach(node => {
        node.innerHTML = `<span class="text-3xl">🐝</span>` + (config.brand_name || defaultConfig.brand_name);
      });
      
      const title = config.hero_title || defaultConfig.hero_title;
      const heroTitleNode = document.getElementById('hero-title');
      if (heroTitleNode) {
        heroTitleNode.innerHTML = title.replace(/\n/g, '<br>');
      }
      
      const heroSubNode = document.getElementById('hero-subtitle');
      if (heroSubNode) {
        heroSubNode.textContent = config.hero_subtitle || defaultConfig.hero_subtitle;
      }
      
      document.body.style.backgroundColor = config.background_color || defaultConfig.background_color;
      document.body.style.color = config.text_color || defaultConfig.text_color;
    }

    if (window.elementSdk && window.elementSdk.init) {
      window.elementSdk.init({
        defaultConfig,
        onConfigChange: async (config) => applyConfig(config),
        mapToCapabilities: (config) => ({
          recolorables: [
            { get: () => config.background_color || defaultConfig.background_color, set: (v) => { config.background_color = v; window.elementSdk.setConfig({ background_color: v }); } },
            { get: () => config.text_color || defaultConfig.text_color, set: (v) => { config.text_color = v; window.elementSdk.setConfig({ text_color: v }); } },
            { get: () => config.accent_color || defaultConfig.accent_color, set: (v) => { config.accent_color = v; window.elementSdk.setConfig({ accent_color: v }); } },
          ],
          borderables: [],
          fontEditable: { get: () => 'DM Sans', set: (v) => {} },
          fontSizeable: { get: () => 16, set: (v) => {} },
        }),
        mapToEditPanelValues: (config) => new Map([
          ['brand_name', config.brand_name || defaultConfig.brand_name],
          ['hero_title', config.hero_title || defaultConfig.hero_title],
          ['hero_subtitle', config.hero_subtitle || defaultConfig.hero_subtitle],
        ])
      });
    } else {
      applyConfig(defaultConfig);
    }
  </script>
 </body>
</html>
