<?php
namespace App\Services;
use App\Models\AuditLog; use Illuminate\Support\Facades\Auth; use Illuminate\Database\Eloquent\Model;
class AuditLogger { public static function record(string $action, ?Model $subject=null, ?string $description=null): AuditLog { return AuditLog::create(['user_id'=>Auth::id(),'action'=>$action,'subject_type'=>$subject?->getMorphClass(),'subject_id'=>$subject?->getKey(),'description'=>$description,'ip_address'=>request()->ip()]); } }
