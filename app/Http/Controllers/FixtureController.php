<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fixture;

class FixtureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fixtures = Fixture::paginate(10);
        return view('fixtures.index', ['fixtures'=> $fixtures]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fixtures = Fixture::findOrFail($id);
        return view('fixtures.show', ['fixtures'=> $fixtures]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
