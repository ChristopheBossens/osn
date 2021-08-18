<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container pb-5" style="background-color: white">
        <div class="row">
            <div class="col-12 text-center pt-3">
                <h4>Campaign overview</h4>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('campaigns.create') }}" class="btn btn-sm btn-outline-success">Create new campaign</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if(count($campaigns) > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->title }}</td>
                            <td style="text-align: right"><a class="btn btn-sm btn-outline-success" href="{{ route('campaigns.show', $campaign->id) }}">Go to campaign</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>You have not created any campaigns yet. Start campaigning by pressing the 'Create new campaign' button</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
