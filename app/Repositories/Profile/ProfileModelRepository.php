<?php
class ProfileModelRepository implements ProfileRepository
{
    public function update($user, $data)
    {
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        return $user->profile->fill($data)->save();
    }
    public function delete($user)
    {
        $user->delete();
    }
}
