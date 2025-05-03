<?php

namespace App\Http\Controllers;

use App\Models\Relationship;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{

    public function index()
    {
        // dd(Relationship::all());
        if (request()->ajax()) {
            // Truy vấn dữ liệu từ model Relationship
            $query = Relationship::query(); // Sử dụng model mặc định

            return DataTables::of($query)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="row-checkbox form-check-input" value="' . $row->id . '">';
            })
            ->editColumn('link', function ($row) {
                return "<strong class='edit' data-link='{$row->link}' data-image='{$row->image}'>{$row->link}</strong>";
            })
            ->editColumn('image', function ($row) {
                return "<img src='" . asset('storage/' . $row->image) . "' width='60' />";
            })
            ->rawColumns(['checkbox', 'link', 'image'])
            ->make(true);

        }

        return view('backend.relationship.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $relationship = new Relationship();
        $relationship->link = $request->link;

        if ($request->hasFile('image')) {
            $relationship->image = saveImages($request, 'image', 'relationships');
        }

        // Lưu vào database
        $relationship->save();

        return handleResponse("thành công", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $relationship = Relationship::find($request->id);
        if (!$relationship) {
            return handleResponse("không tìm thấy", 404);
        }

        $relationship->link = $request->link;


        if ($request->hasFile('image')) {
            $relationship->image = saveImages($request, 'image', 'relationships');
        }

        $relationship->save();

        return handleResponse("thành công", 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
