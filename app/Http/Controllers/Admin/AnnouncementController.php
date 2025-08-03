<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::all();

        return inertia('Admin/Announcements/Index', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Announcements/AddAnnouncement');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $image_path = null;

        // Pastikan file ada sebelum diproses penyimpanan
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('announcement_photos', 'public');
        }

        // Gabungkan validated data dan path gambar jika ada
        Announcement::create(
            [
                'title' => $validated['title'],
                'content' => $validated['content'],
                'image' => $image_path,
            ]
        );

        return Inertia::location(route('announcements.index'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = Announcement::findOrFail($id);

        return inertia('Admin/Announcements/EditAnnouncement', [
            'announcement' => $announcement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $announcement = Announcement::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Hapus gambar lama jika ada dan ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $validated['image'] = $request->file('image')->store('announcement_photos', 'public');
        } else {
            $validated['image'] = $announcement->image; // Tetap gunakan gambar lama jika tidak ada yang diunggah
        }

        $announcement->update($validated);

        return Inertia::location(route('announcements.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::findOrFail($id);
        // Hapus gambar jika ada
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }
        // Hapus pengumuman
        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
