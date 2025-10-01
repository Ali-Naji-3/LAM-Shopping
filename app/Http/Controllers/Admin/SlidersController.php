<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SlidersController extends Controller
{
    /**
     * Display a listing of sliders.
     */
    public function index(Request $request)
    {
        $query = Slider::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('button_text', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->currentlyActive();
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'scheduled':
                    $query->scheduled();
                    break;
                case 'expired':
                    $query->expired();
                    break;
            }
        }

        $sliders = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(20);

        // Calculate statistics
        $statistics = [
            'total_sliders' => Slider::count(),
            'active_sliders' => Slider::currentlyActive()->count(),
            'scheduled_sliders' => Slider::scheduled()->count(),
            'expired_sliders' => Slider::expired()->count(),
            'inactive_sliders' => Slider::where('is_active', false)->count(),
        ];

        return view('admin.sliders.index', compact('sliders', 'statistics'));
    }

    /**
     * Show the form for creating a new slider.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created slider.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:hero,brand,banner',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'priority' => 'nullable|integer|min:0|max:10',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('sliders', $filename, 'public');
            $validated['image'] = $path;
        }

        // Set defaults
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['order'] = $validated['order'] ?? 0;
        $validated['priority'] = $validated['priority'] ?? 0;

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider created successfully!');
    }

    /**
     * Display the specified slider.
     */
    public function show(Slider $slider)
    {
        return view('admin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified slider.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified slider.
     */
    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'type' => 'required|in:hero,brand,banner',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'priority' => 'nullable|integer|min:0|max:10',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('sliders', $filename, 'public');
            $validated['image'] = $path;
        }

        // Set defaults
        $validated['is_active'] = $validated['is_active'] ?? false;
        $validated['order'] = $validated['order'] ?? 0;
        $validated['priority'] = $validated['priority'] ?? 0;

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully!');
    }

    /**
     * Remove the specified slider.
     */
    public function destroy(Slider $slider)
    {
        // Delete associated image
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider deleted successfully!');
    }

    /**
     * Handle bulk actions for sliders.
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'selected_sliders' => 'required|array|min:1',
            'selected_sliders.*' => 'exists:sliders,id'
        ]);

        $sliders = Slider::whereIn('id', $request->selected_sliders);

        switch ($request->action) {
            case 'activate':
                $sliders->update(['is_active' => true]);
                return redirect()->back()->with('success', 'Selected sliders activated successfully!');
                
            case 'deactivate':
                $sliders->update(['is_active' => false]);
                return redirect()->back()->with('success', 'Selected sliders deactivated successfully!');
                
            case 'delete':
                // Delete associated images
                foreach ($sliders->get() as $slider) {
                    if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                        Storage::disk('public')->delete($slider->image);
                    }
                }
                $sliders->delete();
                return redirect()->back()->with('success', 'Selected sliders deleted successfully!');
        }
    }

    /**
     * Toggle slider active status.
     */
    public function toggleStatus(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);
        
        $status = $slider->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Slider {$status} successfully!");
    }

    /**
     * Reorder sliders.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'slider_ids' => 'required|array',
            'slider_ids.*' => 'exists:sliders,id'
        ]);

        foreach ($request->slider_ids as $index => $sliderId) {
            Slider::where('id', $sliderId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Sliders reordered successfully!']);
    }

    /**
     * Show analytics for sliders.
     */
    public function analytics()
    {
        $analytics = [
            'total_sliders' => Slider::count(),
            'active_sliders' => Slider::currentlyActive()->count(),
            'scheduled_sliders' => Slider::scheduled()->count(),
            'expired_sliders' => Slider::expired()->count(),
            'inactive_sliders' => Slider::where('is_active', false)->count(),
            'sliders_with_links' => Slider::whereNotNull('link')->count(),
            'sliders_with_buttons' => Slider::whereNotNull('button_text')->count(),
            'average_duration' => $this->calculateAverageDuration(),
            'upcoming_expirations' => Slider::where('end_date', '>=', now()->toDateString())
                ->where('end_date', '<=', now()->addDays(7)->toDateString())
                ->orderBy('end_date')
                ->get(),
            'recent_sliders' => Slider::orderBy('created_at', 'desc')->limit(5)->get(),
        ];

        return view('admin.sliders.analytics', compact('analytics'));
    }

    /**
     * Calculate average duration of sliders with date ranges.
     */
    private function calculateAverageDuration()
    {
        $slidersWithDates = Slider::whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->get();

        if ($slidersWithDates->isEmpty()) {
            return 0;
        }

        $totalDays = 0;
        foreach ($slidersWithDates as $slider) {
            $start = \Carbon\Carbon::parse($slider->start_date);
            $end = \Carbon\Carbon::parse($slider->end_date);
            $totalDays += $start->diffInDays($end) + 1;
        }

        return round($totalDays / $slidersWithDates->count(), 1);
    }
}