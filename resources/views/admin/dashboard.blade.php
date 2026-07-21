<!doctype html>
<html lang="vi" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Beestyle Admin - Trang Quản Trị</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    html, body { height: 100%; margin: 0; }
    .font-heading { font-family: 'Playfair Display', serif; }
    .font-body { font-family: 'DM Sans', sans-serif; }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #faf9f7; }
    ::-webkit-scrollbar-thumb { background: #e8e5e0; border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: #4e73df; }
  </style>
 </head>
 <body class="h-full font-body bg-[#f8f9fc] text-[#1a1a1a] overflow-x-hidden">

  <div id="admin-view" class="w-full min-h-screen flex bg-[#f8f9fc]">
    <!-- Sidebar -->
    <aside id="admin-sidebar" class="fixed md:static inset-y-0 left-0 z-20 w-64 -translate-x-full md:translate-x-0 bg-gradient-to-b from-[#4e73df] to-[#224abe] text-white flex flex-col shrink-0 transition-all duration-300 shadow-xl md:shadow-none">
      <!-- Brand -->
      <a href="/" class="h-16 flex items-center justify-center gap-2 border-b border-white/10 px-4">
        <span class="text-2xl animate-pulse">🐝</span>
        <span class="font-heading font-bold text-lg tracking-wider sidebar-text">Beestyle Admin</span>
      </a>

      <!-- Sidebar Navigation -->
      <div class="flex-1 py-4 space-y-1 overflow-y-auto">
        <div class="px-6 text-[10px] uppercase font-bold text-white/40 tracking-wider sidebar-text mb-2">Bảng điều khiển</div>

        <button onclick="switchAdminTab('stat')" id="btn-admin-sidebar-stat" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white border-l-4 border-white bg-white/10 text-left outline-none">
          <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i>
          <span class="sidebar-text">Dashboard</span>
        </button>

        <div class="h-px bg-white/10 my-2"></div>

        <div class="px-6 text-[10px] uppercase font-bold text-white/40 tracking-wider sidebar-text mb-2">Quản lý cửa hàng</div>

        <button onclick="switchAdminTab('prod')" id="btn-admin-sidebar-prod" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white/60 hover:text-white hover:bg-white/5 border-l-4 border-transparent text-left outline-none">
          <i data-lucide="package" class="w-5 h-5 shrink-0"></i>
          <span class="sidebar-text">Sản phẩm</span>
        </button>

        <button onclick="switchAdminTab('ord')" id="btn-admin-sidebar-ord" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white/60 hover:text-white hover:bg-white/5 border-l-4 border-transparent text-left outline-none">
          <i data-lucide="shopping-cart" class="w-5 h-5 shrink-0"></i>
          <span class="sidebar-text">Đơn hàng</span>
        </button>

        <button onclick="switchAdminTab('voucher')" id="btn-admin-sidebar-voucher" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white/60 hover:text-white hover:bg-white/5 border-l-4 border-transparent text-left outline-none">
          <i data-lucide="ticket" class="w-5 h-5 shrink-0"></i>
          <span class="sidebar-text">Vouchers</span>
        </button>

        <button onclick="switchAdminTab('user')" id="btn-admin-sidebar-user" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white/60 hover:text-white hover:bg-white/5 border-l-4 border-transparent text-left outline-none">
          <i data-lucide="users" class="w-5 h-5 shrink-0"></i>
          <span class="sidebar-text">Người dùng</span>
        </button>

        <button onclick="switchAdminTab('review')" id="btn-admin-sidebar-review" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white/60 hover:text-white hover:bg-white/5 border-l-4 border-transparent text-left outline-none">
          <i data-lucide="message-square" class="w-5 h-5 shrink-0"></i>
          <span class="sidebar-text">Đánh giá</span>
        </button>

        <div class="h-px bg-white/10 my-2"></div>

        <a href="/" class="flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white/60 hover:text-white hover:bg-white/5 text-left">
          <i data-lucide="arrow-left-right" class="w-5 h-5 shrink-0"></i>
          <span class="sidebar-text">Xem Cửa Hàng</span>
        </a>

        <button onclick="handleLogout()" class="w-full flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white/60 hover:text-white hover:bg-white/5 text-left">
          <i data-lucide="log-out" class="w-5 h-5 shrink-0"></i>
          <span class="sidebar-text">Đăng xuất</span>
        </button>
      </div>
    </aside>

    <!-- Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
      <!-- Topbar -->
      <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shadow-sm z-10">
        <div class="flex items-center gap-4">
          <button onclick="toggleAdminSidebarMobile()" class="md:hidden p-2 hover:bg-gray-100 rounded-full transition text-gray-500">
            <i data-lucide="menu" class="w-5 h-5"></i>
          </button>
          <div class="relative hidden sm:block">
            <input type="text" placeholder="Tìm kiếm nhanh..." class="w-64 bg-gray-100 border border-gray-200 rounded-xl px-4 py-1.5 text-xs outline-none focus:border-[#4e73df] transition">
            <button class="absolute right-2 top-1.5 text-gray-400 hover:text-[#4e73df]"><i data-lucide="search" class="w-4 h-4"></i></button>
          </div>
        </div>

        <div class="flex items-center gap-4">
          <!-- Notifications -->
          <div class="relative">
            <button class="p-2 hover:bg-gray-100 rounded-full transition text-gray-500 relative">
              <i data-lucide="bell" class="w-5 h-5"></i>
              <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
          </div>

          <div class="h-8 w-px bg-gray-200"></div>

          <!-- Profile Info -->
          <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-gray-600 hidden md:inline" id="admin-topbar-name">Beestyle Admin</span>
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-[#4e73df]/20">
          </div>

          <button onclick="handleLogout()" class="text-xs font-semibold text-gray-500 hover:text-red-500 transition flex items-center gap-1.5" title="Đăng xuất">
            <i data-lucide="log-out" class="w-4 h-4"></i>
            <span class="hidden md:inline">Đăng xuất</span>
          </button>
        </div>
      </header>

      <!-- Page Content -->
      <div class="flex-grow p-6 overflow-y-auto space-y-6">

        <!-- Stat Tab (Dashboard) -->
        <div id="admin-tab-stat" class="admin-tab space-y-6">
          <!-- Page Header -->
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="font-heading text-2xl font-bold text-gray-800">Dashboard</h1>
              <p class="text-xs text-gray-500">Xem thống kê và doanh số cửa hàng thời trang Beestyle.</p>
            </div>
            <button class="bg-[#4e73df] hover:bg-[#2e59d9] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-[#4e73df]/20 transition flex items-center gap-2">
              <i data-lucide="download-cloud" class="w-4 h-4"></i> Tải Báo Cáo
            </button>
          </div>

          <!-- Stat widgets (SB Admin 2 Cards) -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Earnings Monthly Card -->
            <div class="bg-white p-5 rounded-xl border-l-4 border-[#4e73df] shadow-sm flex items-center justify-between">
              <div>
                <p class="text-[10px] text-[#4e73df] uppercase font-bold tracking-wider">Doanh Thu (Tổng cộng)</p>
                <h3 class="text-xl font-bold text-gray-800 mt-1" id="stat-revenue">0₫</h3>
              </div>
              <div class="text-gray-300"><i data-lucide="dollar-sign" class="w-8 h-8"></i></div>
            </div>

            <!-- Orders Count Card -->
            <div class="bg-white p-5 rounded-xl border-l-4 border-[#1cc88a] shadow-sm flex items-center justify-between">
              <div>
                <p class="text-[10px] text-[#1cc88a] uppercase font-bold tracking-wider">Đơn Hàng</p>
                <h3 class="text-xl font-bold text-gray-800 mt-1" id="stat-orders-count">0</h3>
              </div>
              <div class="text-gray-300"><i data-lucide="shopping-bag" class="w-8 h-8"></i></div>
            </div>

            <!-- Products Count Card -->
            <div class="bg-white p-5 rounded-xl border-l-4 border-[#36b9cc] shadow-sm flex items-center justify-between">
              <div>
                <p class="text-[10px] text-[#36b9cc] uppercase font-bold tracking-wider">Sản Phẩm</p>
                <h3 class="text-xl font-bold text-gray-800 mt-1" id="stat-products-count">0</h3>
              </div>
              <div class="text-gray-300"><i data-lucide="package" class="w-8 h-8"></i></div>
            </div>

            <!-- Reviews Count Card -->
            <div class="bg-white p-5 rounded-xl border-l-4 border-[#f6c23e] shadow-sm flex items-center justify-between">
              <div>
                <p class="text-[10px] text-[#f6c23e] uppercase font-bold tracking-wider">Đánh Giá</p>
                <h3 class="text-xl font-bold text-gray-800 mt-1" id="stat-reviews-count">0</h3>
              </div>
              <div class="text-gray-300"><i data-lucide="star" class="w-8 h-8"></i></div>
            </div>
          </div>

          <!-- Charts Row (SB Admin 2 style charts) -->
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart (Earnings Overview) -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
              <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="font-bold text-sm text-[#4e73df]">Tổng Quan Doanh Thu</h3>
                <button class="text-gray-400 hover:text-gray-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
              </div>
              <div class="p-5 flex-grow flex items-center justify-center" style="position: relative; height: 320px;">
                <canvas id="earningsAreaChart"></canvas>
              </div>
            </div>

            <!-- Doughnut Chart (Revenue Sources) -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
              <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="font-bold text-sm text-[#4e73df]">Nguồn Doanh Thu</h3>
                <button class="text-gray-400 hover:text-gray-600"><i data-lucide="more-vertical" class="w-4 h-4"></i></button>
              </div>
              <div class="p-5 flex-grow flex flex-col justify-center items-center" style="position: relative; height: 320px;">
                <div class="w-full flex-grow max-h-[220px]">
                  <canvas id="revenuePieChart"></canvas>
                </div>
                <div class="flex justify-center gap-4 text-xs mt-4" id="pie-chart-legend"></div>
              </div>
            </div>
          </div>

          <!-- Top products & activities -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Selling Products Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
              <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="font-bold text-sm text-gray-800">Top Sản Phẩm Giá Trị Nhất</h3>
              </div>
              <div class="p-5 overflow-x-auto">
                <table class="w-full text-xs text-left border-collapse">
                  <thead>
                    <tr class="text-[10px] text-gray-400 uppercase border-b border-gray-100">
                      <th class="py-2.5 pb-3">Sản phẩm</th>
                      <th class="py-2.5 pb-3 text-right">Giá tiền</th>
                      <th class="py-2.5 pb-3 text-right">Đánh giá</th>
                    </tr>
                  </thead>
                  <tbody id="top-products-tbody"></tbody>
                </table>
              </div>
            </div>

            <!-- Recent Activity Log Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
              <div class="bg-gray-50 px-5 py-4 border-b border-gray-200">
                <h3 class="font-bold text-sm text-gray-800">Hoạt Động Gần Đây</h3>
              </div>
              <div class="p-5 space-y-4 max-h-[300px] overflow-y-auto" id="recent-orders-list"></div>
            </div>
          </div>
        </div>

        <!-- Product Management Tab -->
        <div id="admin-tab-prod" class="admin-tab hidden grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Add/Edit form -->
          <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm h-fit">
            <h3 class="font-bold text-gray-800 text-sm mb-4" id="admin-prod-form-title">Thêm Sản Phẩm Mới</h3>
            <form id="admin-product-form" class="space-y-3">
              <input type="hidden" id="admin-prod-id">

              <div class="space-y-1">
                <label class="text-[10px] text-gray-500 font-semibold uppercase">Tên sản phẩm *</label>
                <input type="text" id="admin-prod-name" placeholder="Áo thun polo Beestyle" required class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
              </div>

              <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Giá bán (₫) *</label>
                  <input type="number" id="admin-prod-price" placeholder="350000" required class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Giá cũ (₫)</label>
                  <input type="number" id="admin-prod-old-price" placeholder="450000" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
              </div>

              <div class="grid grid-cols-3 gap-3">
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Danh mục *</label>
                  <select id="admin-prod-category" required class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs bg-white cursor-pointer">
                    <option value="shirt">Áo Nam & Nữ</option>
                    <option value="pants">Quần Jeans & Tây</option>
                    <option value="dress">Váy Đầm Dạo Phố</option>
                    <option value="accessories">Phụ kiện</option>
                  </select>
                </div>
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Nhãn/Tag</label>
                  <input type="text" id="admin-prod-tag" placeholder="Mới, Hot, Sale" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Tồn kho *</label>
                  <input type="number" id="admin-prod-stock" placeholder="50" required value="50" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
              </div>

              <div class="space-y-1">
                <label class="text-[10px] text-gray-500 font-semibold uppercase">Đường dẫn ảnh Unsplash *</label>
                <input type="url" id="admin-prod-image" placeholder="https://images.unsplash.com/..." class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
              </div>

              <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Các Size (Cắt bằng dấu phẩy) *</label>
                  <input type="text" id="admin-prod-sizes" placeholder="S, M, L, XL" required value="S, M, L, XL" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Các Màu (Cắt bằng dấu phẩy) *</label>
                  <input type="text" id="admin-prod-colors" placeholder="Trắng, Đen, Xanh" required value="Trắng, Đen" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
              </div>

              <div class="space-y-1">
                <label class="text-[10px] text-gray-500 font-semibold uppercase">Mô tả sản phẩm *</label>
                <textarea id="admin-prod-desc" placeholder="Chất liệu cotton co giãn nhẹ..." required rows="3" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs"></textarea>
              </div>

              <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-[#4e73df] hover:bg-[#2e59d9] text-white py-2.5 rounded-xl font-semibold transition text-xs" id="btn-admin-prod-submit">Lưu sản phẩm</button>
                <button type="button" onclick="resetAdminProductForm()" class="px-4 py-2.5 border border-gray-200 hover:bg-gray-50 rounded-xl transition text-xs text-gray-500">Hủy</button>
              </div>
            </form>
          </div>

          <!-- Products list Table -->
          <div class="lg:col-span-2 bg-white p-5 rounded-xl border border-gray-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
              <h3 class="font-bold text-gray-800 text-sm">Danh Sách Sản Phẩm</h3>
              <button onclick="restoreDefaultProducts()" class="text-xs font-semibold text-[#4e73df] hover:text-[#2e59d9] border border-[#4e73df] px-3 py-1.5 rounded-xl hover:bg-[#4e73df]/5 transition">Khôi phục mặc định</button>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full text-xs text-left border-collapse">
                <thead>
                  <tr class="text-[10px] text-gray-400 uppercase border-b border-gray-100">
                    <th class="py-3 px-2">Ảnh</th>
                    <th class="py-3 px-2">Tên sản phẩm</th>
                    <th class="py-3 px-2">Danh mục</th>
                    <th class="py-3 px-2 text-right">Giá tiền</th>
                    <th class="py-3 px-2 text-center">Tồn kho</th>
                    <th class="py-3 px-2 text-center">Hành động</th>
                  </tr>
                </thead>
                <tbody id="admin-products-tbody" class="divide-y divide-gray-100"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Order Management Tab -->
        <div id="admin-tab-ord" class="admin-tab hidden bg-white p-5 rounded-xl border border-gray-200 shadow-sm space-y-4">
          <h3 class="font-bold text-gray-800 text-sm">Danh Sách Đơn Hàng Đã Đặt</h3>
          <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse">
              <thead>
                <tr class="text-[10px] text-gray-400 uppercase border-b border-gray-100">
                  <th class="py-3 px-2">Mã Đơn</th>
                  <th class="py-3 px-2">Ngày Đặt</th>
                  <th class="py-3 px-2">Khách Hàng</th>
                  <th class="py-3 px-2">Địa Chỉ</th>
                  <th class="py-3 px-2 text-right">Tổng Tiền</th>
                  <th class="py-3 px-2 text-center">Trạng Thái</th>
                  <th class="py-3 px-2 text-center">Hành Động</th>
                </tr>
              </thead>
              <tbody id="admin-orders-tbody" class="divide-y divide-gray-100"></tbody>
            </table>
          </div>
          <div id="admin-orders-empty" class="hidden text-center py-12 text-gray-400">
            Chưa có đơn hàng nào được đặt trên hệ thống.
          </div>
        </div>

        <!-- Voucher Management Tab -->
        <div id="admin-tab-voucher" class="admin-tab hidden grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Add/Edit Voucher Form -->
          <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm h-fit text-xs">
            <h3 class="font-bold text-gray-800 text-sm mb-4" id="admin-voucher-form-title">Thêm Voucher Mới</h3>
            <form id="admin-voucher-form" class="space-y-3" onsubmit="handleAdminVoucherSubmit(event)">
              <input type="hidden" id="admin-voucher-id">

              <div class="space-y-1">
                <label class="text-[10px] text-gray-500 font-semibold uppercase">Mã Voucher *</label>
                <input type="text" id="admin-voucher-code" placeholder="BEESTYLE50" required class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
              </div>

              <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Phần trăm giảm (%) *</label>
                  <input type="number" id="admin-voucher-percent" placeholder="10" min="1" max="100" required class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Giảm tối đa (₫)</label>
                  <input type="number" id="admin-voucher-max-discount" placeholder="50000" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
              </div>

              <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Giới hạn sử dụng</label>
                  <input type="number" id="admin-voucher-limit" placeholder="100" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Ngày hết hạn *</label>
                  <input type="date" id="admin-voucher-expiry" required class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs bg-white">
                </div>
              </div>

              <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-[#4e73df] hover:bg-[#2e59d9] text-white py-2 rounded-xl font-semibold transition text-xs" id="btn-admin-voucher-submit">Lưu Voucher</button>
                <button type="button" onclick="resetAdminVoucherForm()" class="px-4 py-2 border border-gray-200 hover:bg-gray-50 rounded-xl transition text-xs text-gray-500">Hủy</button>
              </div>
            </form>
          </div>

          <!-- Vouchers List Table -->
          <div class="lg:col-span-2 bg-white p-5 rounded-xl border border-gray-200 shadow-sm space-y-4">
            <h3 class="font-bold text-gray-800 text-sm">Danh Sách Mã Giảm Giá</h3>
            <div class="overflow-x-auto">
              <table class="w-full text-xs text-left border-collapse">
                <thead>
                  <tr class="text-[10px] text-gray-400 uppercase border-b border-gray-100">
                    <th class="py-3 px-2">Mã code</th>
                    <th class="py-3 px-2 text-center">Giảm %</th>
                    <th class="py-3 px-2 text-right">Giảm tối đa</th>
                    <th class="py-3 px-2 text-center">Lượt dùng</th>
                    <th class="py-3 px-2 text-center">Hết hạn</th>
                    <th class="py-3 px-2 text-center">Hành động</th>
                  </tr>
                </thead>
                <tbody id="admin-vouchers-tbody" class="divide-y divide-gray-100"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- User Management Tab -->
        <div id="admin-tab-user" class="admin-tab hidden grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Edit User Form -->
          <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm h-fit text-xs">
            <h3 class="font-bold text-gray-800 text-sm mb-4" id="admin-user-form-title">Cập Nhật Người Dùng</h3>
            <form id="admin-user-form" class="space-y-3" onsubmit="handleAdminUserSubmit(event)">
              <input type="hidden" id="admin-user-id">

              <div class="space-y-1">
                <label class="text-[10px] text-gray-500 font-semibold uppercase">Họ và tên *</label>
                <input type="text" id="admin-user-name" placeholder="Nguyễn Văn A" required class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
              </div>

              <div class="space-y-1">
                <label class="text-[10px] text-gray-500 font-semibold uppercase">Email *</label>
                <input type="email" id="admin-user-email" placeholder="email@beestyle.vn" required class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
              </div>

              <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Số điện thoại</label>
                  <input type="text" id="admin-user-phone" placeholder="0901234567" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
                </div>
                <div class="space-y-1">
                  <label class="text-[10px] text-gray-500 font-semibold uppercase">Vai trò *</label>
                  <select id="admin-user-role" required class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs bg-white cursor-pointer">
                    <option value="Customer">Customer</option>
                    <option value="Admin">Admin</option>
                  </select>
                </div>
              </div>

              <div class="space-y-1">
                <label class="text-[10px] text-gray-500 font-semibold uppercase">Mật khẩu mới (Bỏ trống nếu giữ nguyên)</label>
                <input type="password" id="admin-user-password" placeholder="••••••••" class="w-full px-3 py-2 border border-gray-200 rounded-xl outline-none focus:border-[#4e73df] transition text-xs">
              </div>

              <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-[#4e73df] hover:bg-[#2e59d9] text-white py-2 rounded-xl font-semibold transition text-xs" id="btn-admin-user-submit">Cập nhật tài khoản</button>
                <button type="button" onclick="resetAdminUserForm()" class="px-4 py-2 border border-gray-200 hover:bg-gray-50 rounded-xl transition text-xs text-gray-500">Hủy</button>
              </div>
            </form>
          </div>

          <!-- Users List Table -->
          <div class="lg:col-span-2 bg-white p-5 rounded-xl border border-gray-200 shadow-sm space-y-4">
            <h3 class="font-bold text-gray-800 text-sm">Danh Sách Người Dùng</h3>
            <div class="overflow-x-auto">
              <table class="w-full text-xs text-left border-collapse">
                <thead>
                  <tr class="text-[10px] text-gray-400 uppercase border-b border-gray-100">
                    <th class="py-3 px-2">Họ và tên</th>
                    <th class="py-3 px-2">Email</th>
                    <th class="py-3 px-2">Số điện thoại</th>
                    <th class="py-3 px-2 text-center">Vai trò</th>
                    <th class="py-3 px-2 text-center">Hành động</th>
                  </tr>
                </thead>
                <tbody id="admin-users-tbody" class="divide-y divide-gray-100"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Review Moderation Tab -->
        <div id="admin-tab-review" class="admin-tab hidden bg-white p-5 rounded-xl border border-gray-200 shadow-sm space-y-4">
          <h3 class="font-bold text-gray-800 text-sm">Kiểm Duyệt Bình Luận & Đánh Giá</h3>
          <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse">
              <thead>
                <tr class="text-[10px] text-gray-400 uppercase border-b border-gray-100">
                  <th class="py-3 px-2">Sản phẩm</th>
                  <th class="py-3 px-2">Người đánh giá</th>
                  <th class="py-3 px-2 text-center">Số sao</th>
                  <th class="py-3 px-2">Nội dung bình luận</th>
                  <th class="py-3 px-2 text-center">Ngày đánh giá</th>
                  <th class="py-3 px-2 text-center">Hành động</th>
                </tr>
              </thead>
              <tbody id="admin-reviews-tbody" class="divide-y divide-gray-100"></tbody>
            </table>
          </div>
          <div id="admin-reviews-empty" class="hidden text-center py-12 text-gray-400">
            Chưa có đánh giá nào trên hệ thống.
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Admin Order Details Modal -->
  <div id="admin-order-detail-modal" class="fixed inset-0 z-[70] hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeAdminOrderDetailModal()"></div>
    <div class="bg-white rounded-3xl p-6 md:p-8 w-full max-w-3xl shadow-2xl relative z-10 border border-gray-100 space-y-6 max-h-[90vh] overflow-y-auto">
      <div class="flex items-center justify-between border-b border-gray-100 pb-3">
        <h3 class="font-heading text-lg font-bold text-gray-800">Chi Tiết Đơn Hàng <span class="font-mono text-[#4e73df]" id="admin-modal-order-id"></span></h3>
        <button onclick="closeAdminOrderDetailModal()" class="p-2 hover:bg-gray-100 rounded-full transition text-gray-400 hover:text-black">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
        <div class="space-y-1.5 bg-[#faf9f7] p-4 rounded-2xl border border-gray-100">
          <p class="font-bold text-gray-700 uppercase tracking-wider text-[10px]">Thông tin khách hàng</p>
          <p class="text-gray-600 mt-2">👤 Tên người nhận: <span class="font-semibold text-gray-800" id="admin-modal-cust-name"></span></p>
          <p class="text-gray-600">📞 Số điện thoại: <span class="font-semibold text-gray-800" id="admin-modal-cust-phone"></span></p>
          <p class="text-gray-600">🏠 Địa chỉ: <span class="font-semibold text-gray-800" id="admin-modal-cust-address"></span></p>
          <p class="text-gray-600">✉️ Ghi chú: <span class="font-semibold text-gray-800" id="admin-modal-cust-note"></span></p>
        </div>

        <div class="space-y-1.5 bg-[#faf9f7] p-4 rounded-2xl border border-gray-100">
          <p class="font-bold text-gray-700 uppercase tracking-wider text-[10px]">Thông tin đơn hàng</p>
          <p class="text-gray-600 mt-2">📅 Ngày đặt: <span class="font-semibold text-gray-800" id="admin-modal-order-date"></span></p>
          <p class="text-gray-600">💳 Phương thức: <span class="font-semibold text-gray-800 uppercase" id="admin-modal-order-method"></span></p>
          <p class="text-gray-600">💸 Trạng thái TT: <span class="font-semibold text-gray-800" id="admin-modal-order-payment-status"></span></p>
          <div class="flex items-center gap-1.5 mt-2">
            <span class="text-gray-600 font-bold">Trạng thái đơn:</span>
            <select id="admin-modal-order-status-select" onchange="updateAdminOrderStatusFromModal(this.value)" class="border rounded px-2.5 py-1 bg-white cursor-pointer outline-none font-bold text-[11px]"></select>
          </div>
        </div>
      </div>

      <!-- Items List -->
      <div class="space-y-2">
        <p class="text-xs font-bold text-gray-700 uppercase tracking-wider text-[10px]">Sản phẩm trong đơn</p>
        <div class="overflow-x-auto border border-gray-100 rounded-2xl">
          <table class="w-full text-xs text-left border-collapse bg-[#faf9f7]">
            <thead>
              <tr class="text-[10px] text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                <th class="py-2.5 px-3">Ảnh</th>
                <th class="py-2.5 px-3">Sản phẩm</th>
                <th class="py-2.5 px-3">Phân loại</th>
                <th class="py-2.5 px-3 text-right">Đơn giá</th>
                <th class="py-2.5 px-3 text-center">SL</th>
                <th class="py-2.5 px-3 text-right">Thành tiền</th>
              </tr>
            </thead>
            <tbody id="admin-modal-order-items-tbody"></tbody>
          </table>
        </div>
      </div>

      <div class="border-t border-gray-100 pt-4 flex flex-col items-end space-y-1 text-xs">
        <div class="flex justify-between w-full max-w-[280px] text-gray-500">
          <span>Giảm giá (Voucher):</span>
          <span class="font-bold text-gray-800" id="admin-modal-order-discount"></span>
        </div>
        <div class="flex justify-between w-full max-w-[280px] text-sm font-bold text-gray-800 border-t border-gray-100 pt-2">
          <span>Tổng cộng:</span>
          <span class="text-base text-[#4e73df]" id="admin-modal-order-total"></span>
        </div>
      </div>

      <div class="flex justify-between pt-2 border-t border-gray-100">
        <button id="admin-modal-delete-btn" onclick="deleteAdminOrderFromModal()" class="text-xs text-red-500 hover:text-red-700 font-bold border border-red-100 hover:bg-red-50 px-4 py-2.5 rounded-xl transition">Xóa Đơn Hàng</button>
        <button onclick="closeAdminOrderDetailModal()" class="bg-[#1a1a1a] hover:bg-[#c45e3a] text-white py-2.5 px-6 rounded-xl text-xs font-bold transition">Đóng</button>
      </div>
    </div>
  </div>

  <!-- Toast Notification System -->
  <div id="toast" class="fixed bottom-6 right-6 bg-[#1a1a1a] text-white px-5 py-3 rounded-2xl shadow-2xl transform translate-y-20 opacity-0 transition-all duration-300 z-50 flex items-center gap-2 text-sm border border-white/10"></div>

  <!-- JavaScript logic -->
  <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const headers = {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    };

    let categoriesState = [];
    let earningsAreaChartInstance = null;
    let revenuePieChartInstance = null;

    // -------------------------------------------------------------
    // UI Helpers (Toast, formatting)
    // -------------------------------------------------------------
    function showToast(message, type = 'success') {
      const t = document.getElementById('toast');
      t.innerHTML = `<span>${type === 'success' ? '✅' : 'ℹ️'}</span><span>${message}</span>`;
      t.classList.remove('translate-y-20', 'opacity-0');
      setTimeout(() => {
        t.classList.add('translate-y-20', 'opacity-0');
      }, 3000);
    }

    function formatVND(amount) {
      return new Intl.NumberFormat('vi-VN').format(Math.round(amount)) + '₫';
    }

    async function handleLogout() {
      try {
        const res = await fetch('/api/logout', {
          method: 'POST',
          headers: headers
        });
        const data = await res.json();
        if (res.ok) {
          window.location.href = '/';
        } else {
          showToast(data.message || 'Lỗi đăng xuất', 'info');
        }
      } catch (err) {
        console.error("Logout error:", err);
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    function toggleAdminSidebarMobile() {
      document.getElementById('admin-sidebar').classList.toggle('-translate-x-full');
    }

    // -------------------------------------------------------------
    // Page init - verify current user is still an authenticated Admin
    // -------------------------------------------------------------
    async function initAdminData() {
      try {
        const authRes = await fetch('/api/auth/status');
        const authData = await authRes.json();
        if (!authData.logged_in || authData.user.role !== 'Admin') {
          showToast('Bạn không có quyền truy cập trang quản trị!', 'info');
          window.location.href = '/';
          return;
        }
        document.getElementById('admin-topbar-name').textContent = authData.user.full_name;
      } catch (err) {
        console.error("Error checking auth status:", err);
        window.location.href = '/';
        return;
      }

      try {
        const catRes = await fetch('/api/categories');
        categoriesState = await catRes.json();
      } catch (err) {
        console.error("Error loading categories:", err);
      }

      await renderAdminPage();
      lucide.createIcons();
    }

    window.addEventListener('load', initAdminData);

    // -------------------------------------------------------------
    // Page Rendering: ADMIN DASHBOARD
    // -------------------------------------------------------------
    let activeAdminTab = 'stat';
    let adminProducts = [];
    let adminOrders = [];

    async function renderAdminPage() {
      const statRevenueNode = document.getElementById('stat-revenue');
      const statOrdersNode = document.getElementById('stat-orders-count');
      const statProdsNode = document.getElementById('stat-products-count');
      const statReviewsNode = document.getElementById('stat-reviews-count');

      try {
        const statsRes = await fetch('/api/admin/stats');
        const stats = await statsRes.json();

        statRevenueNode.textContent = formatVND(stats.total_revenue);
        statOrdersNode.textContent = stats.order_count;
        statProdsNode.textContent = stats.product_count;
        statReviewsNode.textContent = stats.review_count;

        const recentOrdersList = document.getElementById('recent-orders-list');
        recentOrdersList.innerHTML = '';
        if (stats.activities.length === 0) {
          recentOrdersList.innerHTML = `<p class="text-xs text-gray-400 italic">Chưa có hoạt động nào gần đây.</p>`;
        } else {
          stats.activities.forEach(act => {
            const icon = act.type === 'order' ? '📦' : '⭐';
            recentOrdersList.innerHTML += `
              <div class="flex items-start gap-2.5 text-xs p-3 bg-gray-50 rounded-xl border border-gray-100">
                <span class="text-sm mt-0.5">${icon}</span>
                <div class="flex-1">
                  <p class="text-gray-700 leading-relaxed font-medium">${act.description}</p>
                  <p class="text-[10px] text-gray-400 mt-1">${act.time}</p>
                </div>
              </div>`;
          });
        }

        // Setup monthly revenue chart
        const months = stats.monthly_revenue.map(item => item.month);
        const revenues = stats.monthly_revenue.map(item => item.revenue);

        const ctxArea = document.getElementById('earningsAreaChart');
        if (ctxArea) {
          if (earningsAreaChartInstance) {
            earningsAreaChartInstance.destroy();
          }
          earningsAreaChartInstance = new Chart(ctxArea, {
            type: 'line',
            data: {
              labels: months,
              datasets: [{
                label: 'Doanh thu',
                data: revenues,
                backgroundColor: 'rgba(196, 94, 58, 0.05)',
                borderColor: '#c45e3a',
                borderWidth: 2.5,
                pointBackgroundColor: '#c45e3a',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 1.5,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.35,
                fill: true
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: false
                },
                tooltip: {
                  callbacks: {
                    label: function(context) {
                      return 'Doanh thu: ' + formatVND(context.raw);
                    }
                  }
                }
              },
              scales: {
                x: {
                  grid: {
                    display: false
                  },
                  ticks: {
                    color: '#8e8e93',
                    font: {
                      size: 10
                    }
                  }
                },
                y: {
                  grid: {
                    color: '#f3f4f6'
                  },
                  ticks: {
                    color: '#8e8e93',
                    font: {
                      size: 10
                    },
                    callback: function(value) {
                      return formatVND(value);
                    }
                  }
                }
              }
            }
          });
        }

        // Setup category revenue doughnut chart
        const categories = stats.category_revenue.map(item => item.category);
        const catRevenues = stats.category_revenue.map(item => item.revenue);
        const pieColors = ['#c45e3a', '#1e293b', '#a3b899', '#8e8e93', '#ffb6c1', '#f5f5dc'];

        const ctxPie = document.getElementById('revenuePieChart');
        if (ctxPie) {
          if (revenuePieChartInstance) {
            revenuePieChartInstance.destroy();
          }

          revenuePieChartInstance = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
              labels: categories,
              datasets: [{
                data: catRevenues,
                backgroundColor: pieColors.slice(0, categories.length),
                borderWidth: 2,
                borderColor: '#ffffff'
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: false
                },
                tooltip: {
                  callbacks: {
                    label: function(context) {
                      const total = context.dataset.data.reduce((a, b) => a + b, 0);
                      const val = context.raw;
                      const pct = total > 0 ? Math.round((val / total) * 100) : 0;
                      return `${context.label}: ${formatVND(val)} (${pct}%)`;
                    }
                  }
                }
              },
              cutout: '70%'
            }
          });

          // Build custom legend under the pie chart
          const legendNode = document.getElementById('pie-chart-legend');
          if (legendNode) {
            legendNode.innerHTML = '';
            categories.forEach((cat, idx) => {
              const val = catRevenues[idx];
              const total = catRevenues.reduce((a, b) => a + b, 0);
              const pct = total > 0 ? Math.round((val / total) * 100) : 0;
              legendNode.innerHTML += `
                <div class="flex items-center gap-1.5">
                  <span class="w-2.5 h-2.5 rounded-full inline-block" style="background-color: ${pieColors[idx % pieColors.length]}"></span>
                  <span class="text-gray-600 font-medium">${cat} (${pct}%)</span>
                </div>`;
            });
          }
        }

      } catch (err) {
        console.error("Error rendering admin stats:", err);
      }

      const topProductsTbody = document.getElementById('top-products-tbody');
      topProductsTbody.innerHTML = '';

      const adminProductsTbody = document.getElementById('admin-products-tbody');
      adminProductsTbody.innerHTML = '<td colspan="5" class="text-center py-4 text-gray-400">Đang tải sản phẩm...</td>';

      try {
        const prodRes = await fetch('/api/admin/products');
        adminProducts = await prodRes.json();

        const topProducts = [...adminProducts].sort((a, b) => b.price - a.price).slice(0, 5);
        topProductsTbody.innerHTML = '';
        topProducts.forEach(p => {
          topProductsTbody.innerHTML += `
            <tr class="border-b border-gray-50 text-xs">
              <td class="py-2.5 font-semibold text-gray-800 flex items-center gap-2">
                <span class="w-6 h-8 rounded overflow-hidden shrink-0 inline-block bg-gray-100">
                  <img src="${p.thumbnail_url}" class="w-full h-full object-cover">
                </span>
                <span class="line-clamp-1">${p.name}</span>
              </td>
              <td class="py-2.5 text-right font-bold text-gray-700">${formatVND(p.price)}</td>
              <td class="py-2.5 text-right text-yellow-500 font-bold">★ ${p.rating}</td>
            </tr>`;
        });

        adminProductsTbody.innerHTML = '';
        adminProducts.forEach(p => {
          const catText = p.category ? p.category.name : 'Khác';
          const stockVal = p.stock !== undefined ? p.stock : 0;
          let stockBadge = '';
          if (stockVal === 0) {
            stockBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100">Hết hàng</span>`;
          } else if (stockVal <= 10) {
            stockBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">Sắp hết (${stockVal})</span>`;
          } else {
            stockBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">${stockVal} chiếc</span>`;
          }

          adminProductsTbody.innerHTML += `
            <tr class="text-xs border-b border-gray-100 hover:bg-gray-50/50 transition">
              <td class="py-3 px-2">
                <div class="w-9 h-12 rounded overflow-hidden shadow-sm bg-[#faf9f7] flex items-center justify-center">
                  <img src="${p.thumbnail_url}" class="w-full h-full object-cover">
                </div>
              </td>
              <td class="py-3 px-2 font-semibold text-gray-800">${p.name}</td>
              <td class="py-3 px-2 text-gray-500">${catText}</td>
              <td class="py-3 px-2 text-right font-bold text-gray-700">${formatVND(p.price)}</td>
              <td class="py-3 px-2 text-center">${stockBadge}</td>
              <td class="py-3 px-2 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  <button onclick="editAdminProduct('${p.id}')" class="p-1 text-gray-400 hover:text-blue-600 transition" title="Sửa"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                  <button onclick="deleteAdminProduct('${p.id}')" class="p-1 text-gray-400 hover:text-red-500 transition" title="Xóa"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                </div>
              </td>
            </tr>`;
        });
      } catch (err) {
        adminProductsTbody.innerHTML = '<td colspan="5" class="text-center py-4 text-red-500">Lỗi tải danh sách sản phẩm.</td>';
      }

      const adminOrdersTbody = document.getElementById('admin-orders-tbody');
      const adminOrdersEmpty = document.getElementById('admin-orders-empty');
      adminOrdersTbody.innerHTML = '<td colspan="7" class="text-center py-4 text-gray-400">Đang tải đơn hàng...</td>';
      adminOrdersEmpty.classList.add('hidden');

      try {
        const ordRes = await fetch('/api/admin/orders');
        adminOrders = await ordRes.json();

        adminOrdersTbody.innerHTML = '';
        if (adminOrders.length === 0) {
          adminOrdersEmpty.classList.remove('hidden');
        } else {
          adminOrders.forEach(o => {
            const orderDate = new Date(o.created_at).toLocaleString('vi-VN');
            adminOrdersTbody.innerHTML += `
              <tr class="text-xs border-b border-gray-100 hover:bg-gray-50/50 transition">
                <td class="py-3 px-2 font-mono font-bold text-[#c45e3a]">#${o.id}</td>
                <td class="py-3 px-2 text-gray-400">${orderDate}</td>
                <td class="py-3 px-2">
                  <p class="font-bold text-gray-800">${o.customer_name}</p>
                  <p class="text-[10px] text-gray-400">${o.customer_phone}</p>
                </td>
                <td class="py-3 px-2 text-gray-500 max-w-xs truncate" title="${o.customer_address}">${o.customer_address}</td>
                <td class="py-3 px-2 text-right font-bold text-gray-700">${formatVND(o.total_amount)}</td>
                <td class="py-3 px-2 text-center font-bold">
                  <select ${o.status === 'Completed' || o.status === 'Cancelled' ? 'disabled' : ''} onchange="updateAdminOrderStatus('${o.id}', this.value)" class="border rounded px-2 py-1 text-[11px] bg-white cursor-pointer outline-none ${
                    o.status === 'Pending' ? 'border-yellow-300 text-yellow-600' :
                    o.status === 'Processing' ? 'border-yellow-500 text-yellow-800' :
                    o.status === 'Shipping' ? 'border-blue-300 text-blue-600' :
                    o.status === 'Completed' ? 'border-green-300 text-green-600' :
                    'border-red-300 text-red-500'
                  }">
                    ${o.status === 'Completed' ? `
                      <option value="Completed" selected>Đã giao</option>
                    ` : o.status === 'Cancelled' ? `
                      <option value="Cancelled" selected>Đã hủy</option>
                    ` : `
                      <option value="Pending" ${o.status === 'Pending' ? 'selected' : ''}>Chờ xử lý</option>
                      <option value="Processing" ${o.status === 'Processing' ? 'selected' : ''}>Đang xử lý</option>
                      <option value="Shipping" ${o.status === 'Shipping' ? 'selected' : ''}>Đang giao</option>
                      <option value="Completed" ${o.status === 'Completed' ? 'selected' : ''}>Đã giao</option>
                      <option value="Cancelled" ${o.status === 'Cancelled' ? 'selected' : ''}>Đã hủy</option>
                    `}
                  </select>
                </td>
                <td class="py-3 px-2 text-center">
                  <button onclick="viewAdminOrderDetails('${o.id}')" class="text-xs text-[#c45e3a] hover:underline font-semibold">Chi tiết</button>
                </td>
              </tr>`;
          });
        }
      } catch (err) {
        adminOrdersTbody.innerHTML = '<td colspan="7" class="text-center py-4 text-red-500">Lỗi tải danh sách đơn hàng.</td>';
      }

      switchAdminTab(activeAdminTab);
      lucide.createIcons();
    }

    function switchAdminTab(tabName) {
      activeAdminTab = tabName;
      document.querySelectorAll('.admin-tab').forEach(tab => tab.classList.add('hidden'));
      document.getElementById('admin-tab-' + tabName).classList.remove('hidden');

      // Update sidebar buttons styling
      const adminTabs = ['stat', 'prod', 'ord', 'voucher', 'user', 'review'];
      adminTabs.forEach(tab => {
        const btn = document.getElementById('btn-admin-sidebar-' + tab);
        if (btn) {
          if (tab === tabName) {
            btn.className = 'w-full flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white border-l-4 border-white bg-white/10 text-left outline-none';
          } else {
            btn.className = 'w-full flex items-center gap-3 px-6 py-3 text-sm font-semibold transition text-white/60 hover:text-white hover:bg-white/5 border-l-4 border-transparent text-left outline-none';
          }
        }
      });

      // Lazy load tab data
      if (tabName === 'voucher') {
        loadAdminVouchers();
      } else if (tabName === 'user') {
        loadAdminUsers();
      } else if (tabName === 'review') {
        loadAdminReviews();
      }
      lucide.createIcons();
    }

    // --- VOUCHERS MANAGEMENT TAB ---
    let adminVouchers = [];
    async function loadAdminVouchers() {
      const tbody = document.getElementById('admin-vouchers-tbody');
      tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-400">Đang tải voucher...</td></tr>';
      try {
        const res = await fetch('/api/admin/vouchers');
        adminVouchers = await res.json();
        tbody.innerHTML = '';
        if (adminVouchers.length === 0) {
          tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-400">Chưa có voucher nào.</td></tr>';
          return;
        }
        adminVouchers.forEach(v => {
          const expiryDate = new Date(v.expiry_date).toLocaleDateString('vi-VN');
          tbody.innerHTML += `
            <tr class="text-xs border-b border-gray-100 hover:bg-gray-50/50 transition">
              <td class="py-3 px-2 font-mono font-bold text-gray-800">${v.code}</td>
              <td class="py-3 px-2 text-center font-bold text-emerald-600">${v.discount_percent}%</td>
              <td class="py-3 px-2 text-right font-bold text-gray-700">${v.max_discount ? formatVND(v.max_discount) : 'Không giới hạn'}</td>
              <td class="py-3 px-2 text-center text-gray-500">${v.usage_limit ? v.usage_limit : 'Vô hạn'}</td>
              <td class="py-3 px-2 text-center text-gray-500">${expiryDate}</td>
              <td class="py-3 px-2 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  <button onclick="editAdminVoucher('${v.id}')" class="p-1 text-gray-400 hover:text-blue-600 transition" title="Sửa"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                  <button onclick="deleteAdminVoucher('${v.id}')" class="p-1 text-gray-400 hover:text-red-500 transition" title="Xóa"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                </div>
              </td>
            </tr>`;
        });
        lucide.createIcons();
      } catch (err) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-rose-500">Lỗi tải danh sách voucher.</td></tr>';
      }
    }

    function editAdminVoucher(id) {
      const v = adminVouchers.find(item => item.id.toString() === id.toString());
      if (!v) return;
      document.getElementById('admin-voucher-id').value = v.id;
      document.getElementById('admin-voucher-code').value = v.code;
      document.getElementById('admin-voucher-percent').value = v.discount_percent;
      document.getElementById('admin-voucher-max-discount').value = v.max_discount || '';
      document.getElementById('admin-voucher-limit').value = v.usage_limit || '';
      const expiry = v.expiry_date.split(' ')[0];
      document.getElementById('admin-voucher-expiry').value = expiry;
      document.getElementById('admin-voucher-form-title').innerText = 'Chỉnh Sửa Voucher';
      document.getElementById('btn-admin-voucher-submit').innerText = 'Cập nhật Voucher';
    }

    function resetAdminVoucherForm() {
      document.getElementById('admin-voucher-id').value = '';
      document.getElementById('admin-voucher-code').value = '';
      document.getElementById('admin-voucher-percent').value = '';
      document.getElementById('admin-voucher-max-discount').value = '';
      document.getElementById('admin-voucher-limit').value = '';
      document.getElementById('admin-voucher-expiry').value = '';
      document.getElementById('admin-voucher-form-title').innerText = 'Thêm Voucher Mới';
      document.getElementById('btn-admin-voucher-submit').innerText = 'Lưu Voucher';
    }

    async function handleAdminVoucherSubmit(e) {
      e.preventDefault();
      const id = document.getElementById('admin-voucher-id').value;
      const code = document.getElementById('admin-voucher-code').value.trim();
      const discount_percent = parseInt(document.getElementById('admin-voucher-percent').value);
      const maxDiscountVal = document.getElementById('admin-voucher-max-discount').value;
      const max_discount = maxDiscountVal ? parseInt(maxDiscountVal) : null;
      const limitVal = document.getElementById('admin-voucher-limit').value;
      const usage_limit = limitVal ? parseInt(limitVal) : null;
      const expiry_date = document.getElementById('admin-voucher-expiry').value;

      const bodyData = { code, discount_percent, max_discount, usage_limit, expiry_date };
      try {
        let url = '/api/admin/vouchers';
        let method = 'POST';
        if (id) {
          url = '/api/admin/vouchers/' + id;
          method = 'PUT';
        }
        const res = await fetch(url, {
          method,
          headers,
          body: JSON.stringify(bodyData)
        });
        const data = await res.json();
        if (res.ok) {
          showToast(id ? 'Cập nhật voucher thành công!' : 'Tạo voucher thành công!');
          resetAdminVoucherForm();
          await loadAdminVouchers();
        } else {
          showToast(data.message || 'Lỗi xử lý voucher', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    async function deleteAdminVoucher(id) {
      if (!confirm('Bạn có chắc chắn muốn xóa voucher này?')) return;
      try {
        const res = await fetch('/api/admin/vouchers/' + id, {
          method: 'DELETE',
          headers
        });
        const data = await res.json();
        if (res.ok) {
          showToast('Xóa voucher thành công!');
          await loadAdminVouchers();
        } else {
          showToast(data.message || 'Lỗi khi xóa voucher', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    // --- USERS MANAGEMENT TAB ---
    let adminUsers = [];
    async function loadAdminUsers() {
      const tbody = document.getElementById('admin-users-tbody');
      tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-gray-400">Đang tải danh sách người dùng...</td></tr>';
      try {
        const res = await fetch('/api/admin/users');
        adminUsers = await res.json();
        tbody.innerHTML = '';
        if (adminUsers.length === 0) {
          tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-gray-400">Chưa có người dùng nào.</td></tr>';
          return;
        }
        adminUsers.forEach(u => {
          tbody.innerHTML += `
            <tr class="text-xs border-b border-gray-100 hover:bg-gray-50/50 transition">
              <td class="py-3 px-2 font-semibold text-gray-800">${u.full_name}</td>
              <td class="py-3 px-2 text-gray-500">${u.email}</td>
              <td class="py-3 px-2 text-gray-500">${u.phone || 'Chưa cập nhật'}</td>
              <td class="py-3 px-2 text-center">
                <span class="px-2 py-0.5 rounded text-[10px] font-bold ${
                  u.role === 'Admin' ? 'bg-purple-50 text-purple-600 border border-purple-100' : 'bg-blue-50 text-blue-600 border border-blue-100'
                }">${u.role}</span>
              </td>
              <td class="py-3 px-2 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  <button onclick="editAdminUser('${u.id}')" class="p-1 text-gray-400 hover:text-blue-600 transition" title="Sửa"><i data-lucide="edit-3" class="w-4 h-4"></i></button>
                  <button onclick="deleteAdminUser('${u.id}')" class="p-1 text-gray-400 hover:text-red-500 transition" title="Xóa"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                </div>
              </td>
            </tr>`;
        });
        lucide.createIcons();
      } catch (err) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-rose-500">Lỗi tải danh sách người dùng.</td></tr>';
      }
    }

    function editAdminUser(id) {
      const u = adminUsers.find(item => item.id.toString() === id.toString());
      if (!u) return;
      document.getElementById('admin-user-id').value = u.id;
      document.getElementById('admin-user-name').value = u.full_name;
      document.getElementById('admin-user-email').value = u.email;
      document.getElementById('admin-user-phone').value = u.phone || '';
      document.getElementById('admin-user-role').value = u.role;
      document.getElementById('admin-user-password').value = '';
      document.getElementById('admin-user-form-title').innerText = 'Chỉnh Sửa Người Dùng';
      document.getElementById('btn-admin-user-submit').innerText = 'Cập nhật tài khoản';
    }

    function resetAdminUserForm() {
      document.getElementById('admin-user-id').value = '';
      document.getElementById('admin-user-name').value = '';
      document.getElementById('admin-user-email').value = '';
      document.getElementById('admin-user-phone').value = '';
      document.getElementById('admin-user-role').value = 'Customer';
      document.getElementById('admin-user-password').value = '';
      document.getElementById('admin-user-form-title').innerText = 'Cập Nhật Người Dùng';
      document.getElementById('btn-admin-user-submit').innerText = 'Cập nhật tài khoản';
    }

    async function handleAdminUserSubmit(e) {
      e.preventDefault();
      const id = document.getElementById('admin-user-id').value;
      if (!id) {
        showToast('Vui lòng chọn một người dùng từ danh sách để cập nhật vai trò hoặc mật khẩu.', 'info');
        return;
      }
      const full_name = document.getElementById('admin-user-name').value.trim();
      const email = document.getElementById('admin-user-email').value.trim();
      const phone = document.getElementById('admin-user-phone').value.trim();
      const role = document.getElementById('admin-user-role').value;
      const password = document.getElementById('admin-user-password').value;

      const bodyData = { full_name, email, phone, role };
      if (password) {
        bodyData.password = password;
      }

      try {
        const res = await fetch('/api/admin/users/' + id, {
          method: 'PUT',
          headers,
          body: JSON.stringify(bodyData)
        });
        const data = await res.json();
        if (res.ok) {
          showToast('Cập nhật tài khoản thành công!');
          resetAdminUserForm();
          await loadAdminUsers();
        } else {
          showToast(data.message || 'Lỗi cập nhật người dùng', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    async function deleteAdminUser(id) {
      if (!confirm('Bạn có chắc chắn muốn xóa người dùng này?')) return;
      try {
        const res = await fetch('/api/admin/users/' + id, {
          method: 'DELETE',
          headers
        });
        const data = await res.json();
        if (res.ok) {
          showToast('Xóa người dùng thành công!');
          await loadAdminUsers();
        } else {
          showToast(data.message || 'Lỗi khi xóa người dùng', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    // --- REVIEWS MANAGEMENT TAB ---
    async function loadAdminReviews() {
      const tbody = document.getElementById('admin-reviews-tbody');
      const emptyMsg = document.getElementById('admin-reviews-empty');
      tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-400">Đang tải đánh giá...</td></tr>';
      emptyMsg.classList.add('hidden');
      try {
        const res = await fetch('/api/admin/reviews');
        const reviews = await res.json();
        tbody.innerHTML = '';
        if (reviews.length === 0) {
          tbody.innerHTML = '';
          emptyMsg.classList.remove('hidden');
          return;
        }
        reviews.forEach(r => {
          const prodName = r.product ? r.product.name : 'Sản phẩm đã xóa';
          const reviewDate = new Date(r.created_at).toLocaleDateString('vi-VN');

          let starsHtml = '';
          for (let i = 1; i <= 5; i++) {
            starsHtml += `<span class="${i <= r.rating ? 'text-amber-400' : 'text-gray-200'}">★</span>`;
          }

          tbody.innerHTML += `
            <tr class="text-xs border-b border-gray-100 hover:bg-gray-50/50 transition">
              <td class="py-3 px-2 font-semibold text-gray-800">${prodName}</td>
              <td class="py-3 px-2 text-gray-700">${r.user ? r.user.full_name : 'Ẩn danh'}</td>
              <td class="py-3 px-2 text-center text-sm font-bold text-amber-500">${starsHtml}</td>
              <td class="py-3 px-2 text-gray-600 max-w-xs truncate" title="${r.comment || ''}">${r.comment || '<span class="italic text-gray-400">Không có bình luận</span>'}</td>
              <td class="py-3 px-2 text-center text-gray-500">${reviewDate}</td>
              <td class="py-3 px-2 text-center">
                <button onclick="deleteAdminReview('${r.id}')" class="p-1 text-gray-400 hover:text-red-500 transition" title="Xóa bình luận"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
              </td>
            </tr>`;
        });
        lucide.createIcons();
      } catch (err) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-rose-500">Lỗi tải danh sách đánh giá.</td></tr>';
      }
    }

    async function deleteAdminReview(id) {
      if (!confirm('Bạn có chắc chắn muốn xóa đánh giá này?')) return;
      try {
        const res = await fetch('/api/admin/reviews/' + id, {
          method: 'DELETE',
          headers
        });
        const data = await res.json();
        if (res.ok) {
          showToast('Xóa đánh giá và cập nhật điểm trung bình thành công!');
          await loadAdminReviews();
        } else {
          showToast(data.message || 'Lỗi khi xóa đánh giá', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    // --- PRODUCT FORM SUBMIT (create/update) ---
    document.getElementById('admin-product-form').onsubmit = async (e) => {
      e.preventDefault();

      const id = document.getElementById('admin-prod-id').value;
      const name = document.getElementById('admin-prod-name').value;
      const price = parseFloat(document.getElementById('admin-prod-price').value);
      const oldPriceVal = document.getElementById('admin-prod-old-price').value;
      const old_price = oldPriceVal ? parseFloat(oldPriceVal) : null;
      const categorySlug = document.getElementById('admin-prod-category').value;
      const tag = document.getElementById('admin-prod-tag').value;
      const stock = parseInt(document.getElementById('admin-prod-stock').value) || 0;

      let thumbnail_url = document.getElementById('admin-prod-image').value.trim();
      if (thumbnail_url === '') {
        thumbnail_url = 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&auto=format&fit=crop&q=80';
      }

      const sizes = document.getElementById('admin-prod-sizes').value;
      const colors = document.getElementById('admin-prod-colors').value;
      const description = document.getElementById('admin-prod-desc').value;

      const matchedCategory = categoriesState.find(cat => cat.slug === categorySlug);
      const category_id = matchedCategory ? matchedCategory.id : null;

      const bodyData = {
        name,
        price,
        old_price,
        category_id,
        tag,
        thumbnail_url,
        sizes,
        colors,
        description,
        stock
      };

      try {
        let url = '/api/admin/products';
        let method = 'POST';
        if (id) {
          url = '/api/admin/products/' + id;
          method = 'PUT';
        }

        const res = await fetch(url, {
          method,
          headers,
          body: JSON.stringify(bodyData)
        });

        const data = await res.json();

        if (res.ok) {
          showToast(id ? 'Cập nhật sản phẩm thành công!' : 'Thêm sản phẩm mới thành công!');
          resetAdminProductForm();
          await renderAdminPage();
        } else {
          showToast(data.message || 'Lỗi lưu sản phẩm', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    };

    function editAdminProduct(prodId) {
      const p = adminProducts.find(x => x.id.toString() === prodId.toString());
      if (!p) return;

      document.getElementById('admin-prod-form-title').textContent = 'Sửa Sản Phẩm (ID: ' + p.id + ')';
      document.getElementById('admin-prod-id').value = p.id;
      document.getElementById('admin-prod-name').value = p.name;
      document.getElementById('admin-prod-price').value = p.price;
      document.getElementById('admin-prod-old-price').value = p.old_price || '';

      const catSlug = p.category ? p.category.slug : 'shirt';
      document.getElementById('admin-prod-category').value = catSlug;
      document.getElementById('admin-prod-tag').value = p.tag || '';
      document.getElementById('admin-prod-image').value = p.thumbnail_url || '';
      document.getElementById('admin-prod-sizes').value = p.sizes || 'S, M, L, XL';
      document.getElementById('admin-prod-colors').value = p.colors || 'Trắng, Đen';
      document.getElementById('admin-prod-desc').value = p.description || '';
      document.getElementById('admin-prod-stock').value = p.stock !== undefined ? p.stock : 50;

      document.getElementById('btn-admin-prod-submit').textContent = 'Cập nhật sản phẩm';
      document.getElementById('admin-product-form').scrollIntoView({ behavior: 'smooth' });
    }

    async function deleteAdminProduct(prodId) {
      if (confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi hệ thống?')) {
        try {
          const res = await fetch('/api/admin/products/' + prodId, {
            method: 'DELETE',
            headers
          });

          if (res.ok) {
            await renderAdminPage();
            showToast('Đã xóa sản phẩm khỏi hệ thống.', 'info');
          } else {
            showToast('Không thể xóa sản phẩm lúc này', 'info');
          }
        } catch (err) {
          showToast('Lỗi kết nối máy chủ', 'info');
        }
      }
    }

    function resetAdminProductForm() {
      document.getElementById('admin-prod-form-title').textContent = 'Thêm Sản Phẩm Mới';
      document.getElementById('admin-prod-id').value = '';
      document.getElementById('admin-product-form').reset();
      document.getElementById('admin-prod-stock').value = 50;
      document.getElementById('btn-admin-prod-submit').textContent = 'Lưu sản phẩm';
    }

    async function restoreDefaultProducts() {
      if (confirm('Bạn có muốn khôi phục danh sách sản phẩm thời trang mặc định ban đầu? (Thao tác này sẽ xóa toàn bộ sản phẩm và đơn hàng hiện tại)')) {
        try {
          const res = await fetch('/api/admin/products/restore-defaults', {
            method: 'POST',
            headers
          });

          if (res.ok) {
            await renderAdminPage();
            showToast('Đã khôi phục dữ liệu mặc định thành công!', 'success');
          } else {
            showToast('Không thể khôi phục dữ liệu mẫu', 'info');
          }
        } catch (err) {
          showToast('Lỗi kết nối máy chủ', 'info');
        }
      }
    }

    async function updateAdminOrderStatus(orderId, newStatus) {
      try {
        const res = await fetch(`/api/admin/orders/${orderId}/status`, {
          method: 'PUT',
          headers,
          body: JSON.stringify({ status: newStatus })
        });

        if (res.ok) {
          showToast('Cập nhật trạng thái đơn hàng #' + orderId + ' thành công!');
          await renderAdminPage();
        } else {
          showToast('Lỗi cập nhật trạng thái đơn hàng', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    let currentAdminOrderId = null;
    async function viewAdminOrderDetails(orderId) {
      const order = adminOrders.find(o => o.id.toString() === orderId.toString());
      if (!order) return;

      currentAdminOrderId = orderId;

      document.getElementById('admin-modal-order-id').innerText = '#' + order.id;
      document.getElementById('admin-modal-cust-name').innerText = order.customer_name;
      document.getElementById('admin-modal-cust-phone').innerText = order.customer_phone;
      document.getElementById('admin-modal-cust-address').innerText = order.customer_address;
      document.getElementById('admin-modal-cust-note').innerText = order.customer_note || 'Không có';

      const orderDate = new Date(order.created_at).toLocaleString('vi-VN');
      document.getElementById('admin-modal-order-date').innerText = orderDate;
      document.getElementById('admin-modal-order-method').innerText = order.payment_method === 'cod' ? 'COD' : 'Chuyển khoản / Trực tuyến';
      document.getElementById('admin-modal-order-payment-status').innerText = order.payment_status || 'Chưa thanh toán';

      // Status select logic
      const select = document.getElementById('admin-modal-order-status-select');
      select.innerHTML = '';

      const states = [
        { val: 'Pending', name: 'Chờ xử lý' },
        { val: 'Processing', name: 'Đang xử lý' },
        { val: 'Shipping', name: 'Đang giao' },
        { val: 'Completed', name: 'Đã giao' },
        { val: 'Cancelled', name: 'Đã hủy' }
      ];

      if (order.status === 'Completed' || order.status === 'Cancelled') {
        select.innerHTML = `<option value="${order.status}" selected>${order.status === 'Completed' ? 'Đã giao' : 'Đã hủy'}</option>`;
        select.disabled = true;
      } else {
        select.disabled = false;
        states.forEach(s => {
          const selectedAttr = order.status === s.val ? 'selected' : '';
          select.innerHTML += `<option value="${s.val}" ${selectedAttr}>${s.name}</option>`;
        });
      }

      // Items table
      const tbody = document.getElementById('admin-modal-order-items-tbody');
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
          <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
            <td class="py-2.5 px-3">
              <img src="${img}" class="w-8 h-10 object-cover rounded shadow-sm">
            </td>
            <td class="py-2.5 px-3 font-semibold text-gray-800">${name}</td>
            <td class="py-2.5 px-3 text-gray-500">${size} · ${color}</td>
            <td class="py-2.5 px-3 text-right font-bold text-gray-700">${formatVND(itemPrice)}</td>
            <td class="py-2.5 px-3 text-center">${qty}</td>
            <td class="py-2.5 px-3 text-right font-bold text-gray-700">${formatVND(total)}</td>
          </tr>`;
      });

      // Discount & total
      let discount = 0;
      if (order.voucher) {
        discount = Math.min(order.voucher.max_discount || subtotal, Math.round(subtotal * order.voucher.discount_percent / 100));
      }
      document.getElementById('admin-modal-order-discount').innerText = '-' + formatVND(discount);
      document.getElementById('admin-modal-order-total').innerText = formatVND(order.total_amount);

      document.getElementById('admin-order-detail-modal').classList.remove('hidden');
      lucide.createIcons();
    }

    function closeAdminOrderDetailModal() {
      document.getElementById('admin-order-detail-modal').classList.add('hidden');
    }

    async function updateAdminOrderStatusFromModal(newStatus) {
      if (!currentAdminOrderId) return;
      try {
        const res = await fetch(`/api/admin/orders/${currentAdminOrderId}/status`, {
          method: 'PUT',
          headers,
          body: JSON.stringify({ status: newStatus })
        });
        const data = await res.json();
        if (res.ok) {
          showToast('Cập nhật trạng thái đơn hàng thành công!');
          closeAdminOrderDetailModal();
          await renderAdminPage();
        } else {
          showToast(data.message || 'Lỗi cập nhật trạng thái', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }

    async function deleteAdminOrderFromModal() {
      if (!currentAdminOrderId) return;
      if (!confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đơn hàng này?')) return;
      try {
        const res = await fetch(`/api/admin/orders/${currentAdminOrderId}`, {
          method: 'DELETE',
          headers
        });
        const data = await res.json();
        if (res.ok) {
          showToast('Xóa đơn hàng thành công!');
          closeAdminOrderDetailModal();
          await renderAdminPage();
        } else {
          showToast(data.message || 'Lỗi khi xóa đơn hàng', 'info');
        }
      } catch (err) {
        showToast('Lỗi kết nối máy chủ', 'info');
      }
    }
  </script>
 </body>
</html>
