@props(['id', 'name', 'label' => null, 'required' => false])

<div class="mb-4">
    @if ($label)
        <label class="block text-gray-700 mb-1" for="{{ $id }}">{{ $label }}</label>
    @endif

    <div class="flex items-center space-x-4">
        <label
            for="{{ $id }}"
            class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded cursor-pointer"
        >
            Pilih File
        </label>

        <span id="{{ $id }}-filename" class="text-md text-gray-600">Belum ada file</span>
    </div>

    <input
        id="{{ $id }}"
        type="file"
        name="{{ $name }}"
        class="hidden"
        {{ $required ? 'required' : '' }}
    />

    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<script>
    document.getElementById('{{ $id }}').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name ?? 'Belum ada file';
        document.getElementById('{{ $id }}-filename').textContent = fileName;
    });
</script>