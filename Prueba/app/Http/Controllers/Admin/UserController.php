<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $users = User::with(['country', 'state', 'city'])->orderBy('created_at', 'desc')->paginate(10);
        return view('users.index', compact('users')); 
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('users.create', compact('countries')); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'identifier' => 'required|unique:users|max:20',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cedula' => 'required|string|max:20|unique:users',
            'birth_date' => 'required|date|before:today',
            'phone' => 'nullable|string|max:15',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'is_active' => 'sometimes|boolean',
            'is_admin' => 'sometimes|boolean',
        ]);

        User::create([
            'identifier' => $validated['identifier'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'cedula' => $validated['cedula'],
            'birth_date' => $validated['birth_date'],
            'phone' => $validated['phone'] ?? null,
            'country_id' => $validated['country_id'],
            'state_id' => $validated['state_id'],
            'city_id' => $validated['city_id'],
            'is_active' => $validated['is_active'] ?? false,
            'is_admin' => $validated['is_admin'] ?? false,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $user)
    {
        $user->load('country', 'state', 'city');
        return view('users.show', compact('user')); 
    }

    public function edit(User $user)
    {
        $countries = Country::orderBy('name')->get();
        $states = State::where('country_id', $user->country_id)->get();
        $cities = City::where('state_id', $user->state_id)->get();
        
        return view('users.edit', compact('user', 'countries', 'states', 'cities')); 
    }

    public function update(Request $request, User $user)
    {
        // Validación corregida
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], 
            'is_active' => 'sometimes|boolean',
            'is_admin' => 'sometimes|boolean',
        ]);

        // Preparar datos para actualizar
        $updateData = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'country_id' => $validated['country_id'],
            'state_id' => $validated['state_id'],
            'city_id' => $validated['city_id'],
            'is_active' => $validated['is_active'] ?? false,
            'is_admin' => $validated['is_admin'] ?? false,
        ];

        // Actualizar contraseña solo si se proporciona
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        // CORREGIDO: Redirección a la ruta correcta
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();
    
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    // Métodos AJAX
    public function getStates(Request $request)
    {
        $country_id = $request->get('country_id');
        $states = State::where('country_id', $country_id)->get();
        return response()->json($states);
    }

    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json($cities);
    }
}
