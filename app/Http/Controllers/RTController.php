<?php

namespace App\Http\Controllers;

use App\Models\RT;
use Illuminate\Http\Request;

class RTController extends Controller
{
    /** Display a listing of the resources. */
    public function index()
    {
        $rts = RT::latest()->get();
        return view("rts.index", compact("rts"));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        return view("rts.create");
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "rt_number" => ["required", "string", "digits:3", "unique:rts,rt_number"],
            "head_name" => "required|string|max:50",
        ]);

        RT::create($validated);

        return redirect()->route("rts.index")
            ->with("success", "RT berhasil ditambahkan.");
    }

    /** Display the specified resource. */
    public function show(RT $rt)
    {
        //
    }

    /** Show the form for editing the specified resource. */
    public function edit(RT $rt)
    {
        return view("rts.edit", compact("rt"));
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, RT $rt)
    {
        $validated = $request->validate([
            "rt_number" => "required|string|max:10|unique:rts,rt_number," . $rt->rt_id,
            "head_name" => "required|string|max:50",
            "population" => "required|integer|min:0",
            "reports_reported" => "required|integer|min:0",
            "report_type" => "required|in:category,subcategory",
        ]);

        $rt->update($validated);

        return redirect()->route("rts.index")
            ->with("success", "RT berhasil diperbarui.");
    }

    /** Remove the specified resource from storage. */
    public function destroy(RT $rt)
    {
        $rt->delete();

        return redirect()->route("rts.index")
            ->with("success", "RT berhasil dihapus.");
    }
}