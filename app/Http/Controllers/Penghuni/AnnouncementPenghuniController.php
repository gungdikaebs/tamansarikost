<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementPenghuniController extends Controller
{
    public function index()
    {
        // Fetch announcements and include image URLs using storage path
        $announcements = Announcement::all()->map(function ($announcement) {
            if ($announcement->image) {
                $announcement->image_url = asset('storage/' . $announcement->image);
            } else {
                $announcement->image_url = null;
            }
            return $announcement;
        });

        return inertia('Penghuni/Announcement/Index', [
            'announcements' => $announcements,
        ]);
    }

    public function show($id)
    {
        // Fetch the specific announcement by ID
        $announcement = Announcement::findOrFail($id);
        if ($announcement->image) {
            $announcement->image_url = asset('storage/' . $announcement->image);
        } else {
            $announcement->image_url = null;
        }

        return inertia('Penghuni/Announcement/Show', [
            'announcement' => $announcement,
        ]);
    }
}
