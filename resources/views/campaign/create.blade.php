<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }} >> Create campaign
        </h2>
    </x-slot>

    <div class="container" style="background-color: white">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('campaigns.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title') }}">
                        @error('title')
                        <div class="invalid-feedback">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-outline-success">Create new campaign</button>
                </form>
        </div>

        </div>
    </div>
</x-app-layout>
