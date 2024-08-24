<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use GeminiAPI\Laravel\Facades\Gemini;

class DisplayController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function about()
    {
        // Ambil data dari Firebase
        $reference = $this->database->getReference('about');
        $about = $reference->getValue();

        return view('/content/display/about', compact('about'));
    }

    public function certificates()
    {
        // Ambil data dari Firebase
        $reference = $this->database->getReference('certificates');
        $certificates = $reference->getValue();

        return view('/content/display/certificates', compact('certificates'));
    }
    
    public function portfolio()
    {
        // Ambil data dari Firebase
        $reference = $this->database->getReference('portfolio');
        $portfolios = $reference->getValue();

        return view('/content/display/portfolio', compact('portfolios'));
    }
    
    public function chatbot()
    {
        return view('/content/display/chatbot');
    }

    public function getGeminiResponse(Request $request)
    {
        $gemini = Gemini::startChat();

        $userMessage = $request->input('message');

        try {
            $response = $gemini->sendMessage($userMessage);
            return response()->json(['response' => $response]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
