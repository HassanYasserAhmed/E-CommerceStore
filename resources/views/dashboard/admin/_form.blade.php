
<!---->
<div class="form-group">
        <label for="">Admin Name</label>
        <input type="text" name="name" class="form-controller" value="{{ old('name',$admin->name) }}">
    </div>

    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-controller" value="{{ old('email',$admin->email) }}">
    </div>
    @foreach ($roles as $role)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="roles[]" id="role{{ $role->id }}" value="{{ $role->id }}" @checked(in_array($role->id, $admin_roles))>
            <label class="form-check-label" for="role{{ $role->id }}">
                {{ $role->name }}
            </label>
        </div>
    @endforeach
</div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $button_label ?? 'save' }}</button>
    </div>