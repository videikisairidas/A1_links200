<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Services\UserSearchService;
use Illuminate\View\View;

class SearchController extends Controller
{
//    User Search API
    public function searchUsers(UserSearchService $userSearchService, Request $request)
    {
        $search = $request->query('search');
        info("search query: " . $search);

        $users = $userSearchService->getUserBySearch($search, 4);

        // if ($users->isEmpty()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'No users found'
        //     ]);
        // }

        // $html = view('api_render.user._searchList', [
        //     'users' => $users
        // ])->render();

        
        return response()->json([
            'status' => 'success',
            'users' => $users
        ]);
    }
}