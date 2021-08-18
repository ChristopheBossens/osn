<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }} >> Edit campaign
        </h2>
    </x-slot>

    <div class="container" style="background-color: white">
        <div class="row">
            <div class="col-12">

                <form action="{{ route('campaignmessages.update', $campaign->id) }}" method="POST">
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
