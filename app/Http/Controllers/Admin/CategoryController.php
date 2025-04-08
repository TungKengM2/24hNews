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
        // Lấy tất cả danh mục cha (parent_id = null) và sắp xếp theo thứ tự mới nhất
        $parentCategories = Category::whereNull('parent_id')
            ->latest('category_id')
            ->paginate(10);

        // Lấy ID của tất cả danh mục cha trong trang hiện tại
        $parentIds = $parentCategories->pluck('category_id')->toArray();

        // Lấy tất cả danh mục con của các danh mục cha trong trang hiện tại
        $childCategories = Category::whereIn('parent_id', $parentIds)->get();

        // Kết hợp danh mục cha và danh mục con để hiển thị
        $categories = $parentCategories;

        // Thêm thông tin về danh mục con vào collection
        $categories->childCategories = $childCategories;

        return view('admin.categories.index', compact('categories', 'childCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy danh sách các danh mục có thể trở thành danh mục con
        // Điều kiện: parent_id = null (không phải là danh mục con) và không có danh mục con nào
        $availableChildCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->whereDoesntHave('children') // Không có danh mục con nào
            ->get();

        // Debug
        // \Log::info('Available Child Categories', ['count' => $availableChildCategories->count()]);

        return view('admin.categories.create', compact('availableChildCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Kiểm tra dữ liệu gửi lên
        \Log::info('Category Store Request', [
            'all_data' => $request->all()
        ]);

        $rules = [
            'name' => 'required|unique:categories|max:100',
            'category_type' => 'required|in:parent',
            'existing_children.*' => 'nullable|exists:categories,category_id',
            'new_children.*.name' => 'nullable|max:100'
        ];

        $messages = [
            'name.unique' => 'Tên danh mục đã tồn tại. Vui lòng chọn tên khác.',
            'name.required' => 'Tên danh mục không được để trống.',
            'name.max' => 'Tên danh mục không được vượt quá :max ký tự.'
        ];

        try {
            // Thực hiện validation thủ công
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Kiểm tra xem có kiểm duyệt viên nào không
            $moderators = User::where('role_id', 3)->get();
            if ($moderators->isEmpty()) {
                return redirect()->route('categories.index')->with('error', 'Không có kiểm duyệt viên nào để gán danh mục!');
            }

            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            \DB::beginTransaction();

            // 1. Tạo danh mục cha mới
            $parentCategory = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'is_active' => $request->has('is_active'),
                'parent_id' => null // Đây là danh mục cha
            ]);

            // 2. Xử lý các danh mục con được chọn từ danh sách có sẵn
            if ($request->has('existing_children') && is_array($request->existing_children)) {
                foreach ($request->existing_children as $childId) {
                    if (!empty($childId)) {
                        $childCategory = Category::find($childId);
                        if ($childCategory) {
                            // Chỉ cập nhật parent_id, giữ nguyên slug và các thông tin khác
                            $childCategory->parent_id = $parentCategory->category_id;
                            $childCategory->save();
                        }
                    }
                }
            }

            // 3. Tạo các danh mục con mới
            if ($request->has('new_children') && is_array($request->new_children)) {
                foreach ($request->new_children as $newChild) {
                    if (!empty($newChild['name'])) {
                        Category::create([
                            'name' => $newChild['name'],
                            'slug' => Str::slug($newChild['name']),
                            'is_active' => isset($newChild['is_active']),
                            'parent_id' => $parentCategory->category_id
                        ]);
                    }
                }
            }

            // Gán kiểm duyệt viên cho danh mục
            Category::assignModerators();

            \DB::commit();

            return redirect()->route('categories.index')
                ->with('success', 'Danh mục chính và các danh mục con đã được tạo thành công!');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Lỗi khi tạo danh mục: ' . $e->getMessage());

            // Kiểm tra lỗi trùng tên danh mục
            if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'categories_name_unique') !== false) {
                // Tách tên danh mục bị trùng từ thông báo lỗi
                preg_match("/Duplicate entry '(.+)' for key/", $e->getMessage(), $matches);
                $duplicateName = $matches[1] ?? 'danh mục';

                return redirect()->back()->withInput()
                    ->with('error', "Tên danh mục '". $duplicateName ."' đã tồn tại. Vui lòng chọn tên khác.");
            }

            // Xử lý các lỗi khác
            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo danh mục. Vui lòng thử lại sau.');
        }
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
        // Nếu là danh mục cha, lấy danh sách các danh mục con của nó
        $childCategories = [];
        $nonParentCategories = [];

        if ($category->parent_id === null) {

            $childCategories = Category::where('parent_id', $category->category_id)->get();

            // Lấy danh sách các danh mục có thể trở thành danh mục con
            // Điều kiện: parent_id = null (không phải là danh mục con), không có danh mục con nào,
            // và không phải là danh mục hiện tại
            $availableChildCategories = Category::whereNull('parent_id')
                ->where('category_id', '!=', $category->category_id)
                ->where('is_active', true)
                ->whereDoesntHave('children')
                ->get();
        } else {
            $parentCategories = Category::whereNull('parent_id')
                ->where('category_id', '!=', $category->category_id)
                ->where('is_active', true)
                ->get();

            return view('admin.categories.edit', compact('category', 'parentCategories'));
        }

        return view('admin.categories.edit', compact('category', 'childCategories', 'availableChildCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Debug: Kiểm tra dữ liệu gửi lên
        \Log::info('Category Update Request', [
            'category_type' => $request->category_type,
            'all_data' => $request->all()
        ]);

        // Xử lý khác nhau cho danh mục cha và danh mục con
        if ($request->category_type === 'parent') {
            // Cập nhật danh mục cha
            $rules = [
                'name' => 'required|max:100|unique:categories,name,' . $category->category_id . ',category_id',
                'category_type' => 'required|in:parent',
                'existing_children.*' => 'nullable|exists:categories,category_id',
                'new_children.*.name' => 'nullable|max:100',
                'remove_children.*' => 'nullable|exists:categories,category_id'
            ];

            $messages = [
                'name.unique' => 'Tên danh mục đã tồn tại. Vui lòng chọn tên khác.',
                'name.required' => 'Tên danh mục không được để trống.',
                'name.max' => 'Tên danh mục không được vượt quá :max ký tự.'
            ];

            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            \DB::beginTransaction();

            try {
                // 1. Cập nhật thông tin danh mục cha
                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'is_active' => $request->has('is_active'),
                    'parent_id' => null // Đảm bảo đây là danh mục cha
                ]);

                // 2. Gỡ bỏ các danh mục con được chọn
                if ($request->has('remove_children') && is_array($request->remove_children)) {
                    foreach ($request->remove_children as $childId) {
                        if (!empty($childId)) {
                            $childCategory = Category::find($childId);
                            if ($childCategory && $childCategory->parent_id == $category->category_id) {
                                $childCategory->parent_id = null; // Gỡ bỏ liên kết với danh mục cha
                                $childCategory->save();
                            }
                        }
                    }
                }

                // 3. Thêm các danh mục con từ danh sách có sẵn
                if ($request->has('existing_children') && is_array($request->existing_children)) {
                    foreach ($request->existing_children as $childId) {
                        if (!empty($childId)) {
                            $childCategory = Category::find($childId);
                            if ($childCategory) {
                                // Chỉ cập nhật parent_id, giữ nguyên slug và các thông tin khác
                                $childCategory->parent_id = $category->category_id;
                                $childCategory->save();
                            }
                        }
                    }
                }

                // 4. Tạo các danh mục con mới
                if ($request->has('new_children') && is_array($request->new_children)) {
                    foreach ($request->new_children as $newChild) {
                        if (!empty($newChild['name'])) {
                            Category::create([
                                'name' => $newChild['name'],
                                'slug' => Str::slug($newChild['name']),
                                'is_active' => isset($newChild['is_active']),
                                'parent_id' => $category->category_id
                            ]);
                        }
                    }
                }

                \DB::commit();

                return redirect()->route('categories.index')
                    ->with('success', 'Danh mục chính và các danh mục con đã được cập nhật thành công!');

            } catch (\Exception $e) {
                \DB::rollBack();
                \Log::error('Lỗi khi cập nhật danh mục: ' . $e->getMessage());

                // Kiểm tra lỗi trùng tên danh mục
                if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'categories_name_unique') !== false) {
                    // Tách tên danh mục bị trùng từ thông báo lỗi
                    preg_match("/Duplicate entry '(.+)' for key/", $e->getMessage(), $matches);
                    $duplicateName = $matches[1] ?? 'danh mục';

                    return redirect()->back()->withInput()
                        ->with('error', "Tên danh mục '". $duplicateName ."' đã tồn tại. Vui lòng chọn tên khác.");
                }

                // Xử lý các lỗi khác
                return redirect()->back()->withInput()
                    ->with('error', 'Có lỗi xảy ra khi cập nhật danh mục. Vui lòng thử lại sau.');
            }

        } else {
            // Cập nhật danh mục con
            $rules = [
                'name' => 'required|max:100|unique:categories,name,' . $category->category_id . ',category_id',
                'category_type' => 'required|in:child',
                'parent_id' => 'required|exists:categories,category_id'
            ];

            $messages = [
                'name.unique' => 'Tên danh mục đã tồn tại. Vui lòng chọn tên khác.',
                'name.required' => 'Tên danh mục không được để trống.',
                'name.max' => 'Tên danh mục không được vượt quá :max ký tự.',
                'parent_id.required' => 'Vui lòng chọn danh mục cha.',
                'parent_id.exists' => 'Danh mục cha không tồn tại.'
            ];

            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Kiểm tra xem danh mục cha có phải là danh mục gốc không
            $parentCategory = Category::find($request->parent_id);
            if ($parentCategory && $parentCategory->parent_id !== null) {
                return redirect()->back()->withInput()->with('error', 'Danh mục cha đã chọn không phải là danh mục gốc!');
            }

            // Kiểm tra xem danh mục cha có đang hoạt động không
            if ($parentCategory && !$parentCategory->is_active) {
                return redirect()->back()->withInput()->with('error', 'Danh mục cha đã chọn không hoạt động!');
            }

            // Cập nhật danh mục con
            try {
                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'is_active' => $request->has('is_active'),
                    'parent_id' => $request->parent_id
                ]);

                return redirect()->route('categories.index')
                    ->with('success', 'Danh mục con đã được cập nhật thành công!');
            } catch (\Exception $e) {
                \Log::error('Lỗi khi cập nhật danh mục con: ' . $e->getMessage());

                // Kiểm tra lỗi trùng tên danh mục
                if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'categories_name_unique') !== false) {
                    // Tách tên danh mục bị trùng từ thông báo lỗi
                    preg_match("/Duplicate entry '(.+)' for key/", $e->getMessage(), $matches);
                    $duplicateName = $matches[1] ?? 'danh mục';

                    return redirect()->back()->withInput()
                        ->with('error', "Tên danh mục '". $duplicateName ."' đã tồn tại. Vui lòng chọn tên khác.");
                }

                // Xử lý các lỗi khác
                return redirect()->back()->withInput()
                    ->with('error', 'Có lỗi xảy ra khi cập nhật danh mục. Vui lòng thử lại sau.');
            }
        }
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
