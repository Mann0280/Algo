<?php 
require 'vendor/autoload.php'; 
$app = require_once 'bootstrap/app.php'; 
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class); 
$kernel->bootstrap(); 

$u = App\Models\User::find(2); 
$e = now()->addDays(30); 
$u->premium_expiry = $e; 
$u->role = 'premium'; 
$u->save(); 

$h = App\Models\SubscriptionHistory::where('user_id', 2)->latest()->first(); 
if($h) { 
    $h->expires_at = $e; 
    $h->status = 'Completed'; 
    $h->save(); 
} 
echo 'OK'; 
?>
