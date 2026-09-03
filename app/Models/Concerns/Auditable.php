<?php
namespace App\Models\Concerns;
use App\Services\AuditLogger;
trait Auditable
{
 public static function bootAuditable(): void
 {
  static::created(fn($model)=>AuditLogger::record('created',class_basename($model).' created',$model));
  static::updated(fn($model)=>AuditLogger::record('updated',class_basename($model).' updated',$model));
  static::deleted(fn($model)=>AuditLogger::record('deleted',class_basename($model).' deleted',$model));
 }
}
