<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Http\Requests\ClientRequest\Review\StoreReviewRequest;
use App\Http\Requests\ClientRequest\Review\UpdateReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreReviewRequest $request)
    {
         $user = Auth::user();
         $slug = $request->slug;


        $reviewText = $request->input('comment');

        // Call Python script to analyze sentiment
        $pythonScript = base_path('python_scripts/analyze_sentiment.py');
        $command = escapeshellcmd("python $pythonScript \"$reviewText\"");
        $sentiment = trim(shell_exec($command));

    // Use relationship method to create the review
        $review = $user->reviews()->create([
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'sentiment_type' => $sentiment,
        ]);

         return redirect()->route('product_details.show', ['slug' => $slug]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
