<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:docx|max:5120' // Giới hạn 5MB
        ]);

        $file = $request->file('file');
        $filePath = $file->storeAs('uploads', $file->getClientOriginalName());

        $fullPath = storage_path('app/' . $filePath);

        // Đọc file .docx
        $phpWord = IOFactory::load($fullPath);

        // Chuyển đổi sang HTML
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        ob_start();
        $htmlWriter->save('php://output');
        $html = ob_get_clean();

        return response()->json(['html' => $html]);
    }
}

