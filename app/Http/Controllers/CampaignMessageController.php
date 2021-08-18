<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignMessage;
use Illuminate\Http\Request;

class CampaignMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Campaign $campaign)
    {
        return view('campaignmessages.create')->with('campaign', $campaign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampaignMessage  $campaignMessage
     * @return \Illuminate\Http\Response
     */
    public function show(CampaignMessage $campaignMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CampaignMessage  $campaignMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignMessage $campaignMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CampaignMessage  $campaignMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampaignMessage $campaignMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignMessage  $campaignMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignMessage $campaignMessage)
    {
        //
    }
}
