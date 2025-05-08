<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fixture;
use App\Models\Post;

class FixtureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Correct pagination query
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])->paginate(12);

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
    public function show(Fixture $fixture)
    {
        $fixture-> load(['homeTeam', 'awayTeam']);

        $posts = Post::where('fixture_id', $fixture->id)
                ->with(['user', 'comments.user'])
                ->orderBy('created_at', 'desc')
                ->get();

        \Log::info('Number of posts for fixture ' . $fixture->id . ': ' . $fixture->posts->count());

        return view('fixtures.show', compact('fixture', 'posts'));
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
