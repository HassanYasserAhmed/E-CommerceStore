<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function abilities() {
        return $this->hasMany(RoleAbility::class);
    }
    public static function createWithAbilities($request) {
        DB::beginTransaction();
            try {

            $rows = [];
            $now = now();
                $role = Role::create([
                    'name' => $request->post('name')
                ]);
                foreach ($request->post('abilities') as $ability => $value) {
                $rows[] = [
                        'role_id' => $role->id,
                        'ability' => $ability,
                        'type' => $value
                ];
                };
                RoleAbility::insert($rows);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            };
        return $role;
    }

    public function updateWithAbilities($request) {
        return DB::transaction(function() use ($request) {
    $rows = [];
    $abilities = $request->post('abilities', []);
        if (!empty($abilities)) {
                
                $this->update([
                        'name' => $request->post('name')
                    ]);

                    foreach($abilities as $ability => $value) {
                    $rows[] = [
                            'role_id' => $this->id,
                            'ability' => $ability,
                            'type' => $value,
                        ];
                    };

                RoleAbility::upsert(
                    $rows,
                    ['role_id', 'ability'],   // unique key
                    ['type']   // fields to update
                    );

                // 2) حذف abilities القديمة التي لم تعد موجودة
                RoleAbility::where('role_id', $this->id)
                    ->whereNotIn('ability', array_keys($abilities))
                    ->delete();

        }else {
                RoleAbility::where('role_id', $this->id)->delete();
        }});
    }
}