<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TutorialVideo;
use Illuminate\Http\Request;

class TutorialVideoController extends Controller
{
    /**
     * Display a listing of tutorial videos.
     */
    public function index()
    {
        $videos = TutorialVideo::orderBy('created_at', 'desc')->get();
        return view('admin.tutorial-videos.index', compact('videos'));
    }

    /**
     * Store a newly created tutorial video.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url|max:255',
            'description' => 'nullable|string',
        ]);

        TutorialVideo::create($request->all());

        return redirect()->back()->with('success', 'New educational video protocol deployed.');
    }

    /**
     * Update the specified tutorial video.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url|max:255',
            'description' => 'nullable|string',
        ]);

        $video = TutorialVideo::findOrFail($id);
        $video->update($request->all());

        return redirect()->back()->with('success', 'Video protocol updated: ' . $video->title);
    }

    /**
     * Remove the specified tutorial video.
     */
    public function destroy($id)
    {
        $video = TutorialVideo::findOrFail($id);
        $video->delete();

        return redirect()->back()->with('success', 'Video protocol terminated.');
    }
}
