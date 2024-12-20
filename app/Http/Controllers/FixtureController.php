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
        // Correct pagination query
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])->paginate(10);
        
        return view('fixtures.index', ['fixtures' => $fixtures]);
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
    public function show(string $fixtureId)
    {
        $fixture = Fixture::with(['homeTeam', 'awayTeam', 'posts.user', 'posts.comments.user'])
                      ->findOrFail($fixtureId);

        \Log::info('Number of posts for fixture ' . $fixtureId . ': ' . $fixture->posts->count());
    
        $fixture->posts = $fixture->posts->sortByDesc('created_at'); // Sort posts by created_at in descending order

        return view('fixtures.show', compact('fixture'));
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
