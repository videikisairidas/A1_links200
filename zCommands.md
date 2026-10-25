php artisan migrate:fresh 
php artisan migrate:fresh --seed



#This is crucial if you renamed folders or moved classes:
composer dump-autoload
//clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan optimize:clear


//debugging command
Clear-Content storage/logs/laravel.log
Get-Content storage/logs/laravel.log -Wait
info('This will print in terminal!', $data); <---contoller

return redirect()->back()->with('success', 'Friend deleted successfully!');
return redirect()->back()->with('error', 'Something went wrong!');
return redirect()->back()->with('warning', 'Warning message!');
return redirect()->back()->with('info', 'Informational message.');

psql "host=aws-1-eu-west-1.pooler.supabase.com port=5432 dbname=postgres user=postgres.ilmppmzgelpvmfdhnrkx password=uu1O4083bPbnK6DM sslmode=require"

## method 1 (1 action only)
fetch(`/friends/${friendId}/delete`, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': csrfToken
    }
});
public function delete(int $id) {
    // $id is available directly
}

## method 2 (posibility multiple action at once) ids: [id1, id2]
fetch('/friends/delete', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({ id: friendId })
});
public function delete(Request $request) {
    $id = $request->id;
}

## 'Content-Type': '', what i send to the server
'Content-Type'

## 'accept' FROM server
## 'Accept': 'application/json', i want json response
## 'Accept': 'text/html',

## if i need controller request->ajax
# 'X-Requested-With': 'XMLHttpRequest', -->>  controller request->ajax


| 📝 | Content-type (SENDER)         |        |
|----|-------------------------------|-------|
|    | **application/json**                     | body: JSON.stringify({name: "John"}) | Request $request->input('name')
|    | **application/x-www-form-urlencoded**    | body: "name=John&age=30" | Request $request->input('name') /->get('name')
|    | **multipart/form-data** (files)          | body: FormData object |
|    | **text/plain**                           | body: "Hello world" |
|    | **application/xml**                     | body: JSON.stringify({name: "John"}) |

| 📝 | ACCEPT (Receiver)         |        |
|----|-------------------------------|-------|
|    | **application/json**         | { "status" : "success" , ....} |
|    | **text/html**                | <body></body> |
|    | **application/xml**         | <user><name>John</name></user> |
|    | ** */* **         | accept anything |


## POstgresql
$query->where(function ($q) use ($searchTerm) {
    $q->where('users.email', 'ILIKE', "%{$searchTerm}%")
        ->orWhere('user_profile.username', 'ILIKE', "%{$searchTerm}%")
        ->orWhere('user_profile.first_name', 'ILIKE', "%{$searchTerm}%");
});
## MYSQL 
$q->whereRaw('LOWER(users.email) LIKE ?', ["%{$searchTerm}%"])
  ->orWhereRaw('LOWER(user_profile.username) LIKE ?', ["%{$searchTerm}%"])
  ->orWhereRaw('LOWER(user_profile.first_name) LIKE ?', ["%{$searchTerm}%"]);