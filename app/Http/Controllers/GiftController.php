<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gift::with('user')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Gift::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Gift $gift
     * @return \Illuminate\Http\Response
     */
    public function show(Gift $gift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Gift $gift
     * @return \Illuminate\Http\Response
     */
    public function edit(Gift $gift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Gift $gift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gift = Gift::find($id);
        $gift->update($request->all());

        return $gift;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Gift $gift
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gift::find($id)->delete();
    }

    public function assign(Request $request, $id)
    {
        $gift = Gift::find($id);
        $gift->update(['user_id' => Auth::user()->id]);
        return $gift;
    }

    public function unassign(Request $request, $id)
    {
        $gift = Gift::find($id);
        $gift->update(['user_id' => null]);
        return $gift;
    }
}
