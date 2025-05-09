<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Relationship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PartnerController extends Controller
{
    //
    public function partner()
    {
        $relationships = Relationship::all();
        return view('contact.contact', compact('relationships'));
    }

    public function store(Request $request)
    {

        $now = Carbon::now();
        $fifteenMinutesAgo = $now->subMinutes(15);

        $existing = Contact::where(function ($query) use ($request) {
            $query->where('email', $request->email)
                ->orWhere('phone', $request->phone);
        })
            ->where('created_at', '<=', $fifteenMinutesAgo)
            ->first();

        if ($existing) {
            return back()->with(['success' => 'Số điện thoại hoặc email đã được liên hệ trước đó. Vui lòng quay lại sau 15 phút.']);
        }

        Contact::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

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
