<?php

use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

// Route::post('/tournaments/create', [TournamentController::class, 'newTournament'])->name('newTournament');
Route::post('/tournaments/create/male', [TournamentController::class, 'createTournamentMale'])->name('createTournamentMale');
Route::post('/tournaments/create/female', [TournamentController::class, 'createTournamentFemale'])->name('createTournamentFemale');
Route::get('/tournaments/search', [TournamentController::class, 'searchTournament'])->name('searchTournament'); 
Route::get('/tournaments/{tournament_id}', [TournamentController::class, 'getTournament'])->name('getTournament');
