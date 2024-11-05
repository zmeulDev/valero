<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminPartnersController extends Controller
{
    public const POSITIONS = [
        'sidebar' => 'Sidebar',
        'header' => 'Header',
        'footer' => 'Footer'
    ];

    public const STATUS_OPTIONS = [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'archived' => 'Archived'
    ];

    public function getActivePartnerByPosition($position)
    {
        return Partner::where('position', $position)
            ->where(function($query) {
                $now = now()->startOfDay();
                $query->where(function($q) use ($now) {
                    $q->whereNull('start_date')
                      ->orWhere('start_date', '<=', $now);
                })
                ->where(function($q) use ($now) {
                    $q->whereNull('expiration_date')
                      ->orWhere('expiration_date', '>=', $now);
                });
            })
            ->inRandomOrder()
            ->first();
    }

    public function getPartnerStatus($partner)
    {
        if ($partner->trashed()) {
            return [
                'status' => 'archived',
                'label' => 'Archived',
                'icon' => 'archive',
                'classes' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300'
            ];
        }

        $now = now()->startOfDay();
        $isActive = (!$partner->start_date || $partner->start_date <= $now) 
                    && (!$partner->expiration_date || $partner->expiration_date >= $now);

        return $isActive ? 
            [
                'status' => 'active',
                'label' => 'Active',
                'icon' => 'check-circle',
                'classes' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300'
            ] : 
            [
                'status' => 'inactive',
                'label' => 'Inactive',
                'icon' => 'x-circle',
                'classes' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300'
            ];
    }

    public function index(Request $request)
    {
        // Start with a base query that includes soft deleted records
        $query = Partner::withTrashed();

        // Handle trashed filter
        if ($request->has('trashed')) {
            switch ($request->trashed) {
                case 'with':
                    $query->withTrashed();
                    break;
                case 'only':
                    $query->onlyTrashed();
                    break;
                case 'without':
                    $query->withoutTrashed();
                    break;
            }
        }

        // Handle search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('text', 'like', "%{$search}%")
                  ->orWhere('link', 'like', "%{$search}%");
            });
        }

        // Handle status filter
        if ($request->filled('status')) {
            $now = now()->startOfDay();
            switch ($request->status) {
                case 'active':
                    $query->where(function($q) use ($now) {
                        $q->where(function($q) use ($now) {
                            $q->whereNull('start_date')
                              ->orWhere('start_date', '<=', $now);
                        })
                        ->where(function($q) use ($now) {
                            $q->whereNull('expiration_date')
                              ->orWhere('expiration_date', '>=', $now);
                        });
                    })->whereNull('deleted_at');
                    break;
                case 'expired':
                    $query->where(function($q) use ($now) {
                        $q->whereNotNull('expiration_date')
                          ->where('expiration_date', '<', $now);
                    })->whereNull('deleted_at');
                    break;
                case 'scheduled':
                    $query->where(function($q) use ($now) {
                        $q->whereNotNull('start_date')
                          ->where('start_date', '>', $now);
                    })->whereNull('deleted_at');
                    break;
                case 'archived':
                    $query->onlyTrashed();
                    break;
            }
        }

        // Handle position filter
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        $statusOptions = [
            'active' => 'Active',
            'expired' => 'Expired',
            'scheduled' => 'Scheduled',
            'archived' => 'Archived'
        ];

        $trashedOptions = [
            'without' => 'Active Partners',
            'with' => 'All Partners',
            'only' => 'Archived Partners'
        ];

        $partners = $query->latest()->paginate(10)->withQueryString();

        return view('admin.partners.index', [
            'partners' => $partners,
            'statusOptions' => $statusOptions,
            'positionOptions' => self::POSITIONS,
            'trashedOptions' => $trashedOptions,
            'controller' => $this
        ]);
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'text' => 'nullable|string',
            'position' => ['required', Rule::in(array_keys(self::POSITIONS))],
            'start_date' => 'nullable|date',
            'expiration_date' => 'nullable|date|after_or_equal:start_date',
            'seo.target' => ['required', Rule::in(['_blank', '_self'])],
            'seo.rel' => 'nullable|array',
            'seo.rel.*' => 'string',
            'seo.utm_source' => 'nullable|string|max:255',
            'seo.utm_medium' => 'nullable|string|max:255',
            'seo.utm_campaign' => 'nullable|string|max:255',
            'seo.utm_term' => 'nullable|string|max:255',
        ]);

        try {
            // Handle Image Upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('partners', 'public');
                $validatedData['image'] = $imagePath;
            }

            Partner::create($validatedData);

            return redirect()
                ->route('admin.partners.index')
                ->with('success', 'Partner added successfully.');
        } catch (\Exception $e) {
            // Delete uploaded image if partner creation fails
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to create partner: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $partner = Partner::withTrashed()->findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::withTrashed()->findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'text' => 'nullable|string',
            'position' => ['required', Rule::in(array_keys(self::POSITIONS))],
            'start_date' => 'nullable|date',
            'expiration_date' => 'nullable|date|after_or_equal:start_date',
            'seo.target' => ['required', Rule::in(['_blank', '_self'])],
            'seo.rel' => 'nullable|array',
            'seo.rel.*' => 'string',
            'seo.utm_source' => 'nullable|string|max:255',
            'seo.utm_medium' => 'nullable|string|max:255',
            'seo.utm_campaign' => 'nullable|string|max:255',
            'seo.utm_term' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            if ($partner->image) {
                Storage::disk('public')->delete($partner->image);
            }
            $validatedData['image'] = $request->file('image')->store('partners', 'public');
        }

        $partner->update($validatedData);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        try {
            // Only soft delete the partner
            // Don't delete the image
            $partner->delete();

            return redirect()
                ->route('admin.partners.index')
                ->with('success', 'Partner archived successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to archive partner: ' . $e->getMessage());
        }   
    }

    public function forceDelete($id)
    {
        try {
            $partner = Partner::withTrashed()->findOrFail($id);
            
            // Delete image if exists
            if ($partner->image && Storage::disk('public')->exists($partner->image)) {
                Storage::disk('public')->delete($partner->image);
            }

            $partner->forceDelete();

            return redirect()
                ->route('admin.partners.index')
                ->with('success', 'Partner permanently deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete partner: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $partner = Partner::withTrashed()->findOrFail($id);
            $partner->restore();
            
            // Reset dates if they were expired
            if ($partner->expiration_date && $partner->expiration_date->isPast()) {
                $partner->update([
                    'expiration_date' => now()->addDays(-30),
                    'start_date' => now()->addDays(-30)
                ]);
            }

            return redirect()
                ->route('admin.partners.index')
                ->with('success', 'Partner reactivated successfully. Check dates.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reactivate partner: ' . $e->getMessage());
        }
    }

    public function archive(Partner $partner)
    {
        try {
            $partner->delete();
            return redirect()
                ->route('admin.partners.index')
                ->with('success', 'Partner archived successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to archive partner: ' . $e->getMessage());
        }
    }
}