<x-app-layout>
    <x-slot name="header">
        <h5 class="h5 font-weight-bold">
            <a href="{{ route('dashboard') }}">Campaign dashboard</a> / {{ $campaign->title }}
        </h5>
    </x-slot>

    <div class="container pb-5" style="background-color: white">
        <div class="row">
            <div class="col-3 pt-3">
                <a href="{{ route('campaigns.messages.create', $campaign->id) }}" class="btn btn-outline-success">Create new message</a>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr></div>
        </div>
        <div class="row">
            <div class="col-12">
                @if(count($campaign->messages()) === 0)
                    <p class="text-center">This campaign does not have any messages yet. Press the 'Create new message' button to start spreading content</p>
                @else
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($campaign->messages() as $campaignMessage)
                            <tr>
                                <td> {{ $campaignMessage->url }}</td>
                                <td style="text-align: right">
                                    <a href="{{ route('campaigns.messages.show', [$campaign->id, $campaignMessage->id]) }}" class="btn btn-sm btn-outline-success">Show</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
