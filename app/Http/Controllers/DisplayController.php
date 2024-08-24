<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database;

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
    
    public function chatbot()
    {
        return view('/content/display/chatbot');
    }
}
