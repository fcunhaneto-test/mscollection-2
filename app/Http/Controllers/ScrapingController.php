<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScrapingController extends Controller
{
    public function imdbScrapping(Request $request)
    {
        // Initialising cURL session
        $ch = curl_init();

        // Setting cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $request->html);
        $results = curl_exec($ch);
        curl_close($ch);
        return response()->json($results, 200);
    }
}
