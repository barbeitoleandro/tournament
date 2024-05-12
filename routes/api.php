<?php

use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

Route::post('/tournaments/create', [TournamentController::class, 'createTournament']);
