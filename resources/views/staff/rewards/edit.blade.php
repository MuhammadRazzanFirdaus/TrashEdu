@extends('templates.petugas')

@section('content')
<div class="container">
    <h1 class="mb-3">Edit Hadiah</h1>

    <form action="{{ route('rewards.update', $reward->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Hadiah</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $reward->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $reward->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="points_required" class="form-label">Point yang Dibutuhkan</label>
            <input type="number" class="form-control" id="points_required" name="points_required" value="{{ old('points_required', $reward->points_required) }}" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $reward->stock) }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Foto Hadiah</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($reward->image)
                <img src="{{ asset('storage/'.$reward->image) }}" alt="Reward Image" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('staff.rewards.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
