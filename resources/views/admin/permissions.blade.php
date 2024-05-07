<h5>Права</h5>
<div class="form-group d-flex flex-wrap mb-3">
    @php
        $userPermissions = [];
        if (isset($user)) {
            $userPermissions = old('perms') ?? $role->permissions->keyBy('id')->keys()->toArray();
        }
    @endphp

    @foreach ($permissions as $item)
        @php $checked = in_array($item->id, $userPermissions) @endphp
        <div class="form-check-inline w-25 mr-0">
            <input class="form-check-input" type="checkbox"
                   name="perms[]" id="perm-id-{{ $item->id }}"
                   value="{{ $item->id }}" @if($checked) checked @endif>
            <label class="form-check-label" for="perm-id-{{ $item->id }}">
                {{ $item->title }}
            </label>
        </div>
    @endforeach
</div>
