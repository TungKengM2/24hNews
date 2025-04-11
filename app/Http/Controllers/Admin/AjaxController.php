<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     * Lấy danh sách danh mục con dựa trên danh mục cha
     */
    public function getSubcategories(Request $request)
    {
        $parentId = $request->input('parent_id');
        
        if (!$parentId) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy danh mục cha',
                'data' => []
            ]);
        }
        
        $subcategories = Category::where('parent_id', $parentId)
            ->where('is_active', true)
            ->get(['category_id', 'name']);
            
        return response()->json([
            'success' => true,
            'data' => $subcategories
        ]);
    }
}
