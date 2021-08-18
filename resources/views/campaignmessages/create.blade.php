<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a> >> <a href="{{route('campaigns.show', $campaign->id)}}">{{ $campaign->title }}</a> >> Create new message
        </h2>
    </x-slot>

    <div class="container" style="background-color: white">
        <div class="row">
            <div class="col-12">
                <form>

                    <div class="form-group">
                        <label for="url">Enter the url of the link you want to share</label>
                        <input type="url" name="url" id="url" class="form-control" required>

                    </div>

                    <button type="submit" class="btn btn-outline-success">Create new message</button>
                </form>
        </div>

        </div>
    </div>
</x-app-layout>
