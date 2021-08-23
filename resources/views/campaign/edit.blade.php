<x-app-layout>
    <x-slot name="header">
        <h5 class="h5 font-weight-bold">
            <a href="{{ route('dashboard') }}">Campaign dashboard</a> / Edit campaign
        </h5>
    </x-slot>

    <div class="container pb-5" style="background-color: white">
        <div class="row">
            <div class="col-12 pt-3">

                <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title', $campaign->title) }}">
                        @error('title')
                        <div class="invalid-feedback">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-outline-success">Update campaign</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
