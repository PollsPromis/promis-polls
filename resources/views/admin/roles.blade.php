<h5>Роли</h5>
<div class="form-group d-flex flex-wrap mb-3">
    @php
        $userRoles = [];
        if (isset($user)) {
            $userRoles = old('roles') ?? $user->roles->keyBy('id')->keys()->toArray();
        }
    @endphp

    @foreach ($roles as $item)
        @php $checked = in_array($item->id, $userRoles) @endphp
        <div class="form-check-inline w-25 mr-0">
            <input class="form-check-input" type="checkbox"
                   name="roles[]" id="role-id-{{ $item->id }}"
                   value="{{ $item->id }}" @if($checked) checked @endif>
            <label class="form-check-label" for="role-id-{{ $item->id }}">
                {{ $item->title }}
            </label>
        </div>
    @endforeach
</div>
