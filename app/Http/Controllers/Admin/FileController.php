<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function showFile($filepath)
    {
        /** I have no money to buy a server FTP so I will save file in local, damn so broke
         * if u want, save in firebase or have money, buy aws
         */
        $filepath = base64_decode($filepath);
        // Kiểm tra sự tồn tại của file
        if (Storage::exists($filepath)) {
            // Trả về file dưới dạng response
            return response()->file(Storage::path($filepath));
        } else {
            // Nếu file không tồn tại, trả về 404 Not Found
            abort(404,'File not found');
        }
    }
}
