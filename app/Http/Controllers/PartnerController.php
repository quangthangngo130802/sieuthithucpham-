<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Relationship;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PartnerController extends Controller
{
    //
    public function partner(){
        $relationships = Relationship::all();
        return view('contact.contact', compact('relationships'));
    }

    public function store(Request $request)
    {
       
        Contact::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        sessionFlash('success', 'Đăng nhập thành công.');
        return back()->with('success', 'Cảm ơn bạn đã liên hệ!');
    }

    public function index()
    {
        // dd(Relationship::all());
        if (request()->ajax()) {
            // Truy vấn dữ liệu từ model Relationship
            $query = Contact::query(); // Sử dụng model mặc định
            return DataTables::of($query)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="row-checkbox form-check-input" value="' . $row->id . '">';
            })
            ->rawColumns(['checkbox'])
            ->make(true);

        }

        return view('backend.contact.index');
    }
}
