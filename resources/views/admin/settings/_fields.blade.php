@foreach ($fields as [$name, $label, $type])
    <div>
        <label class="block text-sm font-medium mb-1">{{ $label }}</label>
        @if ($type === 'textarea')
            <textarea name="{{ $name }}" rows="3"
                      class="w-full rounded-xl border border-slate-200 px-4 py-2.5">{{ old($name, $biz[$name] ?? '') }}</textarea>
        @else
            <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $biz[$name] ?? '') }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5">
        @endif
        @error($name) <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
@endforeach
