<?php
use App\Models\Post;
use App\Models\Publication;
use App\Models\OrganicUnit;
use App\Models\Page;
use Illuminate\Support\Facades\Route;
use App\Livewire\PublicationRepository;
use App\Livewire\PublicationSubmission;
use App\Livewire\CourseCatalog;
use App\Livewire\ResearchLinesExplorer;
use App\Livewire\EventExplorer;
use App\Livewire\EventSubmission;
use App\Models\Event;
use App\Livewire\ProjectExplorer;
use App\Livewire\ProjectSubmission;
use App\Models\ResearchProject;

Route::get('/projectos', ProjectExplorer::class)->name('projects.index');

Route::get('/projectos/submeter-proposta', ProjectSubmission::class)->name('projects.submit');

Route::get('/projecto/{id}', function ($id) {

    $project = ResearchProject::with(['coordinator', 'organicUnit', 'knowledgeArea', 'teamMembers'])
        ->where('is_public', true)
        ->findOrFail($id);

    return view('project-detail', [
        'project' => $project
    ]);
})->name('projects.show');

Route::get('/evento/{slug}', function ($slug) {
    // Busca o evento ou retorna erro 404 se não existir
    $event = Event::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    return view('event-detail', compact('event'));
})->name('event.show');
Route::get('/agenda/propor-evento', EventSubmission::class)->name('event.submit');

Route::get('/agenda', EventExplorer::class)->name('agenda');

Route::get('/evento/{slug}', function ($slug) {
    $event = \App\Models\Event::where('slug', $slug)->firstOrFail();
    return view('event-detail', compact('event'));
});

Route::get('/investigacao/linhas', ResearchLinesExplorer::class)->name('research.lines');
Route::get('/cursos', CourseCatalog::class)->name('cursos');

Route::get('/submeter', PublicationSubmission::class)->name('submeter')->middleware('auth'); 

Route::get('/repositorio/{slug}', function ($slug) {
    $publication = Publication::where('slug', $slug)
        ->with(['documentType', 'knowledgeArea', 'organicUnit', 'course', 'user'])
        ->firstOrFail();

    return view('publication-detail', compact('publication'));
})->name('publication.show');


Route::get('/repositorio', PublicationRepository::class)->name('repositorio');

Route::get('/', function () {
    return view('welcome', [
        'news' => Post::where('type', 'news')->where('is_published', true)->latest()->take(4)->get(),
        'stats' => [
            'publications' => Publication::where('status', 'published')->count(),
            'projects' => \App\Models\ResearchProject::where('status', 'approved')->count(),
            'units' => OrganicUnit::count(),
        ]
    ]);
});

// Rota para páginas dinâmicas (Historial, etc)
Route::get('/pagina/{slug}', function ($slug) {
    $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
    return view('page-detail', compact('page'));
});