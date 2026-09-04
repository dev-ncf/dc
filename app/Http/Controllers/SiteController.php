<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\{Evento, OrganicUnit, Leadership};
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
{
    //  dd($units);
    return view('welcome', [
        'faculties' => \App\Models\Faculty::where('type', 'Faculdade')->get(),
        'all_units' => \App\Models\Faculty::all(),
        'leaders' => \App\Models\Leadership::orderBy('order', 'asc')->get(),
        'featured' => \App\Models\Post::where('is_featured', true)->where('is_published', true)->latest()->take(3)->get(),
        'news' => \App\Models\Post::where('type', 'news')->where('is_published', true)->latest()->take(6)->get(),
        'announcements' => \App\Models\Post::where('type', 'announcement')->where('is_published', true)->latest()->take(4)->get(),
        'events' => \App\Models\Evento::where('start_date', '<=', now())->orderBy('start_date', 'asc')->take(4)->get(),
    ]);
}  
public function organicUnit($slug)
{
    // Busca a unidade com as relações necessárias
    $unit = \App\Models\Faculty::with(['campus', 'departments.courses'])->where('slug', $slug)->firstOrFail();
    
    // Busca notícias e eventos ligados especificamente a esta unidade
    $news = \App\Models\Post::where('faculty_id', $unit->id)->where('is_published', true)->latest()->take(3)->get();
    $events = \App\Models\Evento::where('faculty_id', $unit->id)->where('start_date', '>=', now())->take(3)->get();

    return view('organic-unit', compact('unit', 'news', 'events'));
} 
public function showFaculty($slug)
{
    // O banco chama-se Faculty, mas o $unit pode ser qualquer unidade
    $unit = \App\Models\Faculty::with(['campus', 'departments.courses'])->where('slug', $slug)->firstOrFail();
    
    // Notícias relacionadas a esta "Faculdade/Unidade"
    $news = \App\Models\Post::where('faculty_id', $unit->id)->where('is_published', true)->latest()->take(3)->get();
    
    return view('organic-unit', compact('unit', 'news'));
}
}