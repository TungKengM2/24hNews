<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UpgradeController extends Controller
{
    public function index()
    {
        return view('user.upgrade', ['step' => 1]);
    }

    public function step1(Request $request)
    {
        $request->validate([
            'cccd_number' => 'required|numeric|digits:12'
        ]);

        session(['upgrade_data' => [
            'cccd_number' => $request->cccd_number
        ]]);

        return view('user.upgrade', ['step' => 2]);
    }

    public function step2(Request $request)
    {
        $request->validate([
            'cccd_front' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'cccd_back' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'reason' => 'required|min:50',
            'certificates' => 'required|array|min:1',
            'certificates.*' => 'file|mimes:jpeg,png,jpg,pdf|max:5120'
        ]);

        $upgradeData = session('upgrade_data', []);
        $upgradeData['reason'] = $request->reason;

        // Lưu ảnh CCCD
        $cccdFrontPath = $request->file('cccd_front')->store('upgrade/cccd', 'public');
        $cccdBackPath = $request->file('cccd_back')->store('upgrade/cccd', 'public');
        
        $upgradeData['cccd_front'] = $cccdFrontPath;
        $upgradeData['cccd_back'] = $cccdBackPath;

        // Lưu chứng chỉ
        $certificatePaths = [];
        foreach ($request->file('certificates') as $certificate) {
            $path = $certificate->store('upgrade/certificates', 'public');
            $certificatePaths[] = $path;
        }
        $upgradeData['certificates'] = $certificatePaths;

        session(['upgrade_data' => $upgradeData]);

        return view('user.upgrade', ['step' => 3, 'upgradeData' => $upgradeData]);
    }

    public function confirm(Request $request)
    {
        $upgradeData = session('upgrade_data');
        
        if (!$upgradeData) {
            return redirect()->route('user.upgrade')->with('error', 'Không tìm thấy dữ liệu nâng cấp.');
        }

        // Cập nhật role của user thành tác giả (role_id = 2)
        $user = Auth::user();
        $user->role_id = 2;
        $user->save();

        // Xóa session data
        session()->forget('upgrade_data');

        return redirect()->route('user.profile')->with('status', 'Nâng cấp tài khoản thành công!');
    }
} 