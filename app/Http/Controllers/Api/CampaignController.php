<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CampaignController extends Controller
{
    /**
     * Display all campaigns.
     */
    public function index(): JsonResponse
    {
        $paidDonations = fn ($query) => $query->where('status', 'paid');

        $campaigns = Campaign::query()
            ->where('status', 'active')
            ->withSum([
                'donations as total_donated' => $paidDonations,
            ], 'amount')
            ->withCount([
                'donations as paid_donations_count' => $paidDonations,
            ])
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Campaigns retrieved successfully.',
            'data' => $campaigns,
        ]);
    }

    /**
     * Store a new campaign.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => [
                'required',
                'string',
                'max:180',
                'alpha_dash',
                'unique:campaigns,slug',
            ],
            'description' => ['required', 'string'],
            'target_amount' => ['required', 'integer', 'min:1'],
            'start_date' => ['nullable', 'date'],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        $campaign = Campaign::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign created successfully.',
            'data' => $campaign,
        ], 201);
    }

    /**
     * Display a single campaign.
     */
    public function show(Campaign $campaign): JsonResponse
    {
        $campaignData = Campaign::query()
            ->whereKey($campaign->id)
            ->where('status', 'active')
            ->withSum([
                'donations as total_donated' => fn ($query) =>
                    $query->where('status', 'paid'),
            ], 'amount')
            ->withCount([
                'donations as paid_donations_count' => fn ($query) =>
                    $query->where('status', 'paid'),
            ])
            ->first();

        if (! $campaignData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Campaign not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign retrieved successfully.',
            'data' => $campaignData,
        ]);
    }

    /**
     * Update an existing campaign.
     */
    public function update(
        Request $request,
        Campaign $campaign
    ): JsonResponse {
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:150'],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:180',
                'alpha_dash',
                Rule::unique('campaigns', 'slug')
                    ->ignore($campaign->id),
            ],
            'description' => ['sometimes', 'required', 'string'],
            'target_amount' => [
                'sometimes',
                'required',
                'integer',
                'min:1',
            ],
            'start_date' => ['sometimes', 'nullable', 'date'],
            'end_date' => [
                'sometimes',
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'status' => [
                'sometimes',
                'required',
                Rule::in(['draft', 'active', 'completed', 'cancelled']),
            ],
        ]);

        $campaign->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign updated successfully.',
            'data' => $campaign->fresh(),
        ]);
    }

    /**
     * Delete a campaign without donations.
     */
    public function destroy(Campaign $campaign): JsonResponse
    {
        if ($campaign->donations()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Campaign cannot be deleted because it has donations.',
            ], 409);
        }

        $campaign->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign deleted successfully.',
        ]);
    }
}