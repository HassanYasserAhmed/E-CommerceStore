<?php
namespace App\Repositories\Role;
use App\Models\Role;
use App\Models\RoleAbility;
use Illuminate\Support\Facades\DB;

class RoleModelRepository implements RoleRepository
{
    public static function createWithAbilities($request)
    {
        DB::beginTransaction();
        try {

            $rows = [];
            $now = now();
            $role = Role::create([
                'name' => $request->post('name'),
            ]);
            foreach ($request->post('abilities') as $ability => $value) {
                $rows[] = [
                    'role_id' => $role->id,
                    'ability' => $ability,
                    'type' => $value,
                ];
            }
            RoleAbility::insert($rows);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $role;
    }
       public function updateWithAbilities(Role $role,$request)
    {
        return DB::transaction(function () use ($request, $role) {
            $rows = [];
            $abilities = $request->post('abilities', []);
            if (! empty($abilities)) {

                $role->update([
                    'name' => $request->post('name'),
                ]);

                foreach ($abilities as $ability => $value) {
                    $rows[] = [
                        'role_id' => $role->id,
                        'ability' => $ability,
                        'type' => $value,
                    ];
                }

                RoleAbility::upsert(
                    $rows,
                    ['role_id', 'ability'],   // unique key
                    ['type']   // fields to update
                );

                // 2) حذف abilities القديمة التي لم تعد موجودة
                RoleAbility::where('role_id', $role->id)
                    ->whereNotIn('ability', array_keys($abilities))
                    ->delete();

            } else {
                RoleAbility::where('role_id', $role->id)->delete();
            }
        });
    }
    public function destroy($id) {
          Role::destroy($id);
    }
    public function getRoleAbilities(Role $role) {
       return $role->abilities()->pluck('type', 'ability')->toArray();
    }
}
