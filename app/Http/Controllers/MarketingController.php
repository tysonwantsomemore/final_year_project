<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Promotion;
use App\Models\Collection;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarketingController extends Controller
{
    // ---------------- Banner ----------------
    public function getBanners()
    {
        return response()->json(Banner::orderBy('sort_order')->get());
    }

    public function createBanner(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'required|string',
            'link_url' => 'nullable|string',
            'season' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $banner = Banner::create($data);

        return response()->json(['message' => 'Thêm banner thành công!', 'banner' => $banner]);
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json(['message' => 'Banner không tồn tại'], 404);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'image_url' => 'required|string',
            'link_url' => 'nullable|string',
            'season' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $banner->update($data);

        return response()->json(['message' => 'Cập nhật banner thành công!', 'banner' => $banner]);
    }

    public function deleteBanner($id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json(['message' => 'Banner không tồn tại'], 404);
        }
        $banner->delete();

        return response()->json(['message' => 'Xóa banner thành công!']);
    }

    // ---------------- Promotion (Khuyến mãi) ----------------
    public function getPromotions()
    {
        return response()->json(Promotion::with(['category', 'product'])->orderBy('created_at', 'desc')->get());
    }

    public function createPromotion(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'discount_type' => 'required|in:percent,amount',
            'discount_value' => 'required|numeric|min:0',
            'apply_scope' => 'required|in:all,category,product',
            'category_id' => 'required_if:apply_scope,category|nullable|exists:categories,id',
            'product_id' => 'required_if:apply_scope,product|nullable|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $promotion = Promotion::create($data);

        return response()->json(['message' => 'Tạo chương trình khuyến mãi thành công!', 'promotion' => $promotion]);
    }

    public function updatePromotion(Request $request, $id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['message' => 'Khuyến mãi không tồn tại'], 404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'discount_type' => 'required|in:percent,amount',
            'discount_value' => 'required|numeric|min:0',
            'apply_scope' => 'required|in:all,category,product',
            'category_id' => 'required_if:apply_scope,category|nullable|exists:categories,id',
            'product_id' => 'required_if:apply_scope,product|nullable|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $promotion->update($data);

        return response()->json(['message' => 'Cập nhật khuyến mãi thành công!', 'promotion' => $promotion]);
    }

    public function deletePromotion($id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json(['message' => 'Khuyến mãi không tồn tại'], 404);
        }
        $promotion->delete();

        return response()->json(['message' => 'Xóa khuyến mãi thành công!']);
    }

    // ---------------- Collection (Bộ sưu tập) ----------------
    public function getCollections()
    {
        return response()->json(Collection::with('products')->orderBy('created_at', 'desc')->get());
    }

    public function createCollection(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_url' => 'nullable|string',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $collection = Collection::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . Str::random(4),
            'description' => $data['description'] ?? null,
            'thumbnail_url' => $data['thumbnail_url'] ?? null,
        ]);

        if (!empty($data['product_ids'])) {
            $collection->products()->sync($data['product_ids']);
        }

        return response()->json(['message' => 'Tạo bộ sưu tập thành công!', 'collection' => $collection->load('products')]);
    }

    public function updateCollection(Request $request, $id)
    {
        $collection = Collection::find($id);
        if (!$collection) {
            return response()->json(['message' => 'Bộ sưu tập không tồn tại'], 404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_url' => 'nullable|string',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $collection->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'thumbnail_url' => $data['thumbnail_url'] ?? null,
        ]);

        $collection->products()->sync($data['product_ids'] ?? []);

        return response()->json(['message' => 'Cập nhật bộ sưu tập thành công!', 'collection' => $collection->load('products')]);
    }

    public function deleteCollection($id)
    {
        $collection = Collection::find($id);
        if (!$collection) {
            return response()->json(['message' => 'Bộ sưu tập không tồn tại'], 404);
        }
        $collection->delete();

        return response()->json(['message' => 'Xóa bộ sưu tập thành công!']);
    }

    // ---------------- Post (Bài viết) ----------------
    public function getPosts()
    {
        return response()->json(Post::orderBy('created_at', 'desc')->get());
    }

    public function createPost(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:tin_thoi_trang,huong_dan_phoi_do,xu_huong_moi,chinh_sach_doi_tra',
            'thumbnail_url' => 'nullable|string',
            'content' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        $post = Post::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . Str::random(4),
            'category' => $data['category'],
            'thumbnail_url' => $data['thumbnail_url'] ?? null,
            'content' => $data['content'],
            'is_published' => $data['is_published'] ?? true,
        ]);

        return response()->json(['message' => 'Đăng bài viết thành công!', 'post' => $post]);
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:tin_thoi_trang,huong_dan_phoi_do,xu_huong_moi,chinh_sach_doi_tra',
            'thumbnail_url' => 'nullable|string',
            'content' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        $post->update($data);

        return response()->json(['message' => 'Cập nhật bài viết thành công!', 'post' => $post]);
    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }
        $post->delete();

        return response()->json(['message' => 'Xóa bài viết thành công!']);
    }
}
