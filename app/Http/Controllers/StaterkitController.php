<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class StaterkitController extends Controller
{
  protected $database;

  public function __construct()
  {
    // $this->database = \App\Services\FirebaseService::connect();
    $this->database = app('firebase')->createDatabase();
  }

  // home
  public function home(){
    $breadcrumbs = [
        ['name'=>"About"]
    ];
    $reference = $this->database->getReference('about');
    $aboutData = $reference->getValue();

    return view('/content/home', ['breadcrumbs' => $breadcrumbs, 'about' => $aboutData]);
  }

  // about
  public function about(){
    $breadcrumbs = [
        ['name'=>"About"]
    ];
    $reference = $this->database->getReference('about');
    $aboutData = $reference->getValue();

    return view('/content/home', ['breadcrumbs' => $breadcrumbs, 'about' => $aboutData]);
  }

  // Layout collapsed menu
  public function collapsed_menu(){
    $pageConfigs = ['sidebarCollapsed' => true];
    $breadcrumbs = [
        ['link'=>"home",'name'=>"Home"],['link'=>"javascript:void(0)",'name'=>"Layouts"], ['name'=>"Collapsed menu"]
    ];
    return view('/content/layout-collapsed-menu', ['breadcrumbs' => $breadcrumbs, 'pageConfigs' => $pageConfigs]);
  }

  // layout boxed
  public function layout_boxed(){
    $pageConfigs = ['layoutWidth' => 'boxed'];

    $breadcrumbs = [
        ['link'=>"home",'name'=>"Home"],['name'=>"Layouts"], ['name'=>"Layout Boxed"]
    ];
    return view('/content/layout-boxed', [ 'pageConfigs' => $pageConfigs,'breadcrumbs' => $breadcrumbs]);
  }

  // without menu
  public function without_menu(){
    $pageConfigs = ['showMenu' => false];
    $breadcrumbs = [
        ['link'=>"home",'name'=>"Home"],['link'=>"javascript:void(0)",'name'=>"Layouts"], ['name'=>"Layout without menu"]
    ];
    return view('/content/layout-without-menu', [ 'breadcrumbs' => $breadcrumbs,'pageConfigs'=>$pageConfigs]);
  }

  // Empty Layout
  public function layout_empty()
  {
    $breadcrumbs = [['link' => "/dashboard/analytics", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout Empty"]];
    return view('/content/layout-empty', ['breadcrumbs' => $breadcrumbs]);
  }
  // Blank Layout
  public function layout_blank()
  {
    $pageConfigs = ['blankPage' => true];
    $breadcrumbs = [['link' => "/dashboard/analytics", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout Blank"]];
    return view('/content/layout-blank', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs]);
  }

  public function store(Request $request)
  {
    // Validasi input
    $validatedData = $request->validate([
      'description' => 'required',
      'title' => 'required|string|max:255',
    ]);

    // Path ke mana data akan disimpan
    $reference = $this->database->getReference('about');

    // Data yang akan disimpan
    $reference->set([
      'description' => $validatedData['description'],
      'title' => $validatedData['title'],
    ]);

    // Redirect atau kembalikan respons
    return response()->json([
      'message' => 'Success'
    ], 200);
  }
}
