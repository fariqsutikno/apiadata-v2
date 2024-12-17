<div>
    <form wire:submit="save" method="post">
        <div class="my-3">
            <label for="village" class="text-white">Desa</label>
            <select id="village" class="w-full mx-auto mt-2" wire:model.live="village">
            <option></option>
            </select>
        </div>

        <button type="submit" class="bg-primary py-2 px-4 rounded-xl text-white">Save</button>
    </form>
</div>


@assets
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endassets

@script
<script>

</script>
@endscript