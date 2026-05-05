<?php
interface ProfileRepository {
    public function update($user,$data);
    public function delete($user);
}