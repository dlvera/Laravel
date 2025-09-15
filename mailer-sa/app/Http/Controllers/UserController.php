<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('city')->select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('age', function($row){
                    return $row->age;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('users.edit', $row->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">Editar</a>';
                    $btn .= '<form action="'.route('users.destroy', $row->id).'" method="POST" class="inline-block">';
                    $btn .= csrf_field();
                    $btn .= method_field('DELETE');
                    $btn .= '<button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs ml-2">Eliminar</button>';
                    $btn .= '</form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
