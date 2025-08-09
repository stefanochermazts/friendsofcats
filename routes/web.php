<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PublicAdoptionsController;
use App\Http\Controllers\CatBookController;
use App\Http\Controllers\CatProfileController;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;

// Locale switching route
Route::get('/locale/{locale}', [LocaleController::class, 'changeLocale'])->name('locale.change');

Route::get('/', function () {
    // Città per adozioni: considera città dell'utente proprietario o dell'associazione (fallback), senza richiedere foto
    $adoptionCityCounts = \DB::table('cats')
        ->leftJoin('users as u', 'cats.user_id', '=', 'u.id')
        ->leftJoin('users as a', 'cats.associazione_id', '=', 'a.id')
        ->where('cats.disponibile_adozione', true)
        ->selectRaw('COALESCE(u.citta, a.citta) as citta, COUNT(cats.id) as total')
        ->whereNotNull(\DB::raw('COALESCE(u.citta, a.citta)'))
        ->groupByRaw('COALESCE(u.citta, a.citta)')
        ->orderByRaw('COALESCE(u.citta, a.citta) asc')
        ->pluck('total', 'citta');

    // Città per professionisti (non forzo details completed per non escludere città)
    $professionalCityCounts = \DB::table('users')
        ->whereIn('role', ['veterinario', 'toelettatore'])
        ->whereNotNull('citta')
        ->groupBy('citta')
        ->orderBy('citta')
        ->selectRaw('citta, COUNT(id) as total')
        ->pluck('total', 'citta');

    return view('welcome', [
        'adoptionCityCounts' => $adoptionCityCounts,
        'professionalCityCounts' => $professionalCityCounts,
    ]);
})->name('welcome');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Public adoption routes (accessible to everyone)
Route::get('/adoptions', [PublicAdoptionsController::class, 'index'])->name('public.adoptions.index');
// Cat detail constrained to numeric ID to avoid conflict with city slugs
Route::get('/adoptions/{cat}', [PublicAdoptionsController::class, 'show'])
    ->whereNumber('cat')
    ->name('public.adoptions.show');
// List all adoption cities
Route::get('/adoptions/cities', [PublicAdoptionsController::class, 'cities'])->name('public.adoptions.cities');
// Local SEO: adoptions/citta-slug (exclude pure digits)
Route::get('/adoptions/{citySlug}', [PublicAdoptionsController::class, 'byCity'])
    ->where('citySlug', '^(?!\d+$)[A-Za-z0-9\-_%]+$')
    ->name('public.adoptions.city');
Route::get('/api/featured-cats', [PublicAdoptionsController::class, 'featured'])->name('api.featured-cats');
Route::get('/api/cities/suggest', [PublicAdoptionsController::class, 'suggestCities'])->name('api.cities.suggest');
Route::post('/api/cats/{cat}/like', [PublicAdoptionsController::class, 'toggleLike'])->name('api.cats.like')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Cat profile routes (accessible to everyone)
Route::get('/cats/{id}', [CatProfileController::class, 'show'])->name('cats.show');

Route::get('/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth', 'verified', 'role'])->name('dashboard');

Route::get('/test-layout', function () {
    return view('test-layout');
})->middleware(['auth'])->name('test-layout');

// Role selection routes
Route::middleware(['auth'])->group(function () {
    Route::get('/role', [App\Http\Controllers\RoleController::class, 'show'])->name('role.show');
    Route::post('/role', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');
});

// Volunteer association setup routes
Route::middleware(['auth'])->group(function () {
    Route::get('/volunteer/association/setup', [App\Http\Controllers\VolunteerAssociationController::class, 'setup'])->name('volunteer.association.setup');
    Route::post('/volunteer/association/setup', [App\Http\Controllers\VolunteerAssociationController::class, 'store'])->name('volunteer.association.store');
    Route::get('/volunteer/association/edit', [App\Http\Controllers\VolunteerAssociationController::class, 'edit'])->name('volunteer.association.edit');
    Route::put('/volunteer/association', [App\Http\Controllers\VolunteerAssociationController::class, 'update'])->name('volunteer.association.update');
});

// Association details routes
Route::middleware(['auth'])->group(function () {
    Route::get('/association/details', [App\Http\Controllers\AssociationDetailsController::class, 'show'])->name('association.details');
    Route::post('/association/details', [App\Http\Controllers\AssociationDetailsController::class, 'store'])->name('association.details.store');
    Route::get('/association/edit', [App\Http\Controllers\AssociationDetailsController::class, 'edit'])->name('association.edit');
    Route::put('/association/edit', [App\Http\Controllers\AssociationDetailsController::class, 'update'])->name('association.edit.update');
});

// Professional details routes (veterinari e toelettatori)
Route::middleware(['auth'])->group(function () {
    Route::get('/professional/details', [App\Http\Controllers\ProfessionalDetailsController::class, 'show'])->name('professional.details');
    Route::post('/professional/details', [App\Http\Controllers\ProfessionalDetailsController::class, 'store'])->name('professional.details.store');
    Route::get('/professional/details/edit', [App\Http\Controllers\ProfessionalDetailsController::class, 'edit'])->name('professional.details.edit');
    Route::put('/professional/details', [App\Http\Controllers\ProfessionalDetailsController::class, 'update'])->name('professional.details.update');
});

// API routes for association search
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/associations/search', [App\Http\Controllers\Api\AssociationSearchController::class, 'search'])->name('api.associations.search');
    Route::get('/associations/{association}', [App\Http\Controllers\Api\AssociationSearchController::class, 'show'])->name('api.associations.show');
});

// Public API routes
Route::prefix('api')->group(function () {
    Route::get('/platform-stats', [App\Http\Controllers\Api\StatsController::class, 'platformStats'])->name('api.platform-stats');
});

// Professionals directory (public)
Route::get('/professionals', [App\Http\Controllers\ProfessionalsController::class, 'index'])->name('professionals.index');
// Professional detail constrained to numeric ID
Route::get('/professionals/{professional}', [App\Http\Controllers\ProfessionalsController::class, 'show'])
    ->whereNumber('professional')
    ->name('professionals.show');
// List all professional cities
Route::get('/professionals/cities', [App\Http\Controllers\ProfessionalsController::class, 'cities'])->name('professionals.cities');
// Local SEO: professionals/citta-slug (exclude pure digits)
Route::get('/professionals/{citySlug}', [App\Http\Controllers\ProfessionalsController::class, 'byCity'])
    ->where('citySlug', '^(?!\d+$)[A-Za-z0-9\-_%]+$')
    ->name('professionals.city');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User area routes
Route::middleware(['auth', 'verified', 'role'])->group(function () {
    Route::get('/my-cats', [UserDashboardController::class, 'cats'])->name('user.cats');
});

// CatBook routes (require authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/catbook', [CatBookController::class, 'index'])->name('catbook.index');
    Route::post('/catbook/posts', [CatBookController::class, 'store'])->name('catbook.posts.store');
    Route::post('/catbook/posts/{post}/like', [CatBookController::class, 'toggleLike'])->name('catbook.posts.like');
    Route::post('/catbook/posts/{post}/comments', [CatBookController::class, 'addComment'])->name('catbook.posts.comments');
    Route::get('/catbook/posts/{post}/comments', [CatBookController::class, 'getComments'])->name('catbook.posts.comments.get');
    Route::post('/catbook/posts/{post}/share', [CatBookController::class, 'share'])->name('catbook.posts.share');
    Route::get('/catbook/hashtag/{hashtag}', [CatBookController::class, 'hashtag'])->name('catbook.hashtag');
});

// CatBook public routes (for sharing)
Route::get('/catbook/post/{post}', [CatBookController::class, 'show'])->name('catbook.post');

// Follow system routes (require authentication)
Route::middleware(['auth', 'verified'])->prefix('follow')->name('follow.')->group(function () {
    // User follows
    Route::post('/user/{user}', [FollowController::class, 'toggleUserFollow'])->name('toggle.user');
    Route::patch('/user/{user}/notifications', [FollowController::class, 'updateUserNotifications'])->name('user.notifications');
    
    // Cat follows
    Route::post('/cat/{cat}', [FollowController::class, 'toggleCatFollow'])->name('toggle.cat');
    Route::patch('/cat/{cat}/notifications', [FollowController::class, 'updateCatNotifications'])->name('cat.notifications');
    
    // My follows and followers
    Route::get('/my-follows', [FollowController::class, 'myFollows'])->name('my.follows');
    Route::get('/my-followers', [FollowController::class, 'myFollowers'])->name('my.followers');
});

require __DIR__.'/auth.php';
