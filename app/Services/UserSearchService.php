<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserSearchService
{
    public function getUserBySearch(string $searchInput, int $length = 5): Collection
    {
        // $searchInput = strtolower($searchInput);
        $words = array_filter(explode(' ', preg_replace('/\s+/', ' ', trim($searchInput))));

        // $query = User::query()
        //     ->select([
        //         'users.id',
        //         'users.email',
        //         'user_profile.username',
        //         'user_profile.first_name',
        //         'user_profile.middle_name',
        //         'user_profile.last_name',
        //         'user_profile.avatar_small'
        //     ])
        //     ->join('user_profile', 'user_profile.user_id', '=', 'users.id')
        //     ->leftJoin('media', function ($join) {
        //         $join->on('media.mediable_id', '=', 'users.id')
        //              ->where('media.model_type', '=', 'App\Models\User') // Adjust if your model namespace differs
        //              ->where('media.collection_name', '=', 'avatar');
        //     });
        $query = User::lightUsers();
            // ->when();
            // ->with(['userProfile', 'avatar']) 
            // ->join('user_profile', 'user_profile.user_id', '=', 'users.id')
            // ->select('users.*'); // Keeps database selection isolated to User root entities

        if (!empty($words)) {
            $query->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $searchTerm = "%{$word}%";

                    $q->where(function ($subQ) use ($searchTerm) {
                        $subQ->whereHas('userProfile', function ($p) use ($searchTerm) {
                            $p->where('first_name', 'LIKE', $searchTerm)
                            ->orWhere('middle_name', 'LIKE', $searchTerm)
                            ->orWhere('last_name', 'LIKE', $searchTerm)
                            ->orWhere('username', 'LIKE', $searchTerm);
                        })
                        ->orWhere('email', 'LIKE', $searchTerm);
                    });
                }
            });
        }
        // if (!empty($words)) {
        //     $query->where(function ($q) use ($words) {
        //         // Dynamically detect driver to stay cross-compatible between MySQL & PostgreSQL
        //         // $isPostgres = $q->getConnection()->getDriverName() === 'pgsql';
        //         // $likeOperator = $isPostgres ? 'ILIKE' : 'LIKE';
        //         $likeOperator = 'LIKE'; // Using raw to ensure compatibility across drivers

        //         foreach ($words as $word) {
        //             // Wrap each sub-word match within an isolated AND block group
        //             $q->where(function ($subQ) use ($word, $likeOperator) {
        //                 $searchTerm = "%{$word}%";

        //                 $subQ->where('user_profile.first_name', $likeOperator, $searchTerm)
        //                     ->orWhere('user_profile.middle_name', $likeOperator, $searchTerm)
        //                     ->orWhere('user_profile.last_name', $likeOperator, $searchTerm)
        //                     ->orWhere('user_profile.username', $likeOperator, $searchTerm)
        //                     ->orWhere('users.email', $likeOperator, $searchTerm);
        //             });
        //         }
        //     });
        // }
        info("Generated SQL: " . $query->toSql());
        info("Bindings: " . implode(', ', $query->getBindings()));
        info("users: " . $query->get()->toJson());

        // 4. Terminate the query sequence outside of closures and return the collection
        return $query->limit($length)->get();
    }

}