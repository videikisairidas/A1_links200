# protect public/assets foldel from hacking/excustion
Do not store user files under public/ unless they are strictly images or documents.
$path = $request->file('file')->store('uploads');

$request->validate([
    'file' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
]);

.htaccess
<FilesMatch "\.(php|php7|phtml)$">
    Deny from all
</FilesMatch>

<!-- test friends live server
small bug with second time adding from another user -<<<<<<<<>>>>>>>>windsurt -->