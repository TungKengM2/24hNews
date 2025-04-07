<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest('category_id')-> paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->where('is_active', true)->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Kiểm tra dữ liệu gửi lên
        \Log::info('Category Store Request', [
            'category_type' => $request->category_type,
            'parent_id' => $request->parent_id,
            'all_data' => $request->all()
        ]);
        $rules = [
            'name' => 'required|unique:categories|max:100',
            'category_type' => 'required|in:parent,child',
            'parent_id' => 'nullable|exists:categories,category_id'
        ];

        // Nếu là danh mục con, kiểm tra parent_id
        if ($request->category_type === 'child' && $request->parent_id) {
            // Kiểm tra xem danh mục cha có phải là danh mục gốc không
            $parentCategory = Category::find($request->parent_id);
            if ($parentCategory && $parentCategory->parent_id !== null) {
                return redirect()->back()->withInput()->with('error', 'Danh mục cha đã chọn không phải là danh mục gốc!');
            }

            // Kiểm tra xem danh mục cha có đang hoạt động không
            if ($parentCategory && !$parentCategory->is_active) {
                return redirect()->back()->withInput()->with('error', 'Danh mục cha đã chọn không hoạt động!');
            }
        }

        $request->validate($rules);

        // Kiểm tra xem có kiểm duyệt viên nào không
        $moderators = User::where('role_id', 3)->get();
        if ($moderators->isEmpty()) {
            return redirect()->route('categories.index')->with('error', 'Không có kiểm duyệt viên nào để gán danh mục!');
        }

        // Xác định parent_id
        $parent_id = null;
        if ($request->category_type === 'child' && $request->parent_id) {
            $parent_id = $request->parent_id;
        }

        // Tạo danh mục mới
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => $request->has('is_active'),
            'parent_id' => $parent_id
        ]);

        // Gán kiểm duyệt viên cho danh mục
        Category::assignModerators();

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được tạo mới thành công!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('category_id', '!=', $category->category_id)
            ->where('is_active', true)
            ->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Debug: Kiểm tra dữ liệu gửi lên
        \Log::info('Category Update Request', [
            'category_type' => $request->category_type,
            'parent_id' => $request->parent_id,
            'all_data' => $request->all()
        ]);
        $rules = [
            'name' => 'required|max:100|unique:categories,name,' . $category->category_id . ',category_id',
            'category_type' => 'required|in:parent,child',
            'parent_id' => 'nullable|exists:categories,category_id'
        ];

        // Nếu là danh mục con, kiểm tra parent_id
        if ($request->category_type === 'child' && $request->parent_id) {
            // Kiểm tra xem danh mục cha có phải là danh mục gốc không
            $parentCategory = Category::find($request->parent_id);
            if ($parentCategory && $parentCategory->parent_id !== null) {
                return redirect()->back()->withInput()->with('error', 'Danh mục cha đã chọn không phải là danh mục gốc!');
            }

            // Kiểm tra xem danh mục cha có đang hoạt động không
            if ($parentCategory && !$parentCategory->is_active) {
                return redirect()->back()->withInput()->with('error', 'Danh mục cha đã chọn không hoạt động!');
            }
        }

        // Nếu là danh mục cha, kiểm tra xem có danh mục con không
        if ($request->category_type === 'parent' && $category->parent_id !== null) {
            // Kiểm tra xem danh mục này có danh mục con không
            $hasChildren = Category::where('parent_id', $category->category_id)->exists();
            if ($hasChildren) {
                return redirect()->back()->withInput()->with('error', 'Không thể chuyển danh mục này thành danh mục cha vì nó đã có danh mục con!');
            }
        }

        $request->validate($rules);

        // Xác định parent_id
        $parent_id = null;
        if ($request->category_type === 'child' && $request->parent_id) {
            $parent_id = $request->parent_id;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => $request->has('is_active'),
            'parent_id' => $parent_id
        ]);

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được chỉnh sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Đếm số danh mục con sẽ bị vô hiệu hóa
        $childCount = 0;
        if ($category->parent_id === null) {
            $childCount = Category::where('parent_id', $category->category_id)->count();
        }

        // Đếm số bài viết sẽ bị chuyển sang trạng thái draft
        $articleCount = 0;
        if ($category->parent_id === null) {
            // Nếu là danh mục cha, đếm cả bài viết có danh mục chính và bài viết có danh mục phụ thuộc danh mục con
            $articleCount = Article::where('category_id', $category->category_id)->where('status', 'published')->count();
            $childCategories = Category::where('parent_id', $category->category_id)->get();
            $childCategoryIds = $childCategories->pluck('category_id')->toArray();
            if (!empty($childCategoryIds)) {
                $articleCount += Article::whereIn('subcategory_id', $childCategoryIds)->where('status', 'published')->count();
            }
        } else {
            // Nếu là danh mục con, chỉ đếm bài viết có danh mục phụ là danh mục này
            $articleCount = Article::where('subcategory_id', $category->category_id)->where('status', 'published')->count();
        }

        $category->delete();

        $message = 'Danh mục đã được xoá thành công!';
        if ($childCount > 0) {
            $message .= ' ' . $childCount . ' danh mục con đã bị vô hiệu hóa.';
        }
        if ($articleCount > 0) {
            $message .= ' ' . $articleCount . ' bài viết đã chuyển sang trạng thái nháp.';
        }

        return redirect()->route('categories.index')->with('success', $message);
    }
}
