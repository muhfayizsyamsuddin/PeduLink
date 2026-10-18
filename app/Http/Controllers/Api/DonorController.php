<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
     * Display all donors.
     */
    public function index(): JsonResponse
    {
        $donors = Donor::query()
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Donors retrieved successfully.',
            'data' => $donors,
        ]);
    }

    /**
     * Store a new donor.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $donor = Donor::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Donor created successfully.',
            'data' => $donor,
        ], 201);
    }

    /**
     * Display a single donor.
     */
    public function show(Donor $donor): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Donor retrieved successfully.',
            'data' => $donor,
        ]);
    }

    /**
     * Update an existing donor.
     */
    public function update(
        Request $request,
        Donor $donor
    ): JsonResponse {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:100'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20'],
        ]);

        $donor->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Donor updated successfully.',
            'data' => $donor->fresh(),
        ]);
    }

    /**
     * Delete a donor without donation transactions.
     */
    public function destroy(Donor $donor): JsonResponse
    {
        if ($donor->donations()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Donor cannot be deleted because they have donations.',
            ], 409);
        }

        $donor->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Donor deleted successfully.',
        ]);
    }
}