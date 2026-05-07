<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use App\Models\Propietario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // Dashboard - listar propiedades
    public function index()
    {
        $propiedades = Propiedad::with('propietario')->orderBy('id', 'desc')->get();
        return view('admin.dashboard', compact('propiedades'));
    }

    // Mostrar formulario crear
    public function create()
    {
        $propietarios = Propietario::orderBy('nombre')->get();
        return view('admin.crear', compact('propietarios'));
    }

    // Guardar nueva propiedad
    public function store(Request $request)
    {
        $request->validate([
            'titulo'             => 'required|string|max:150',
            'zona'               => 'required|string',
            'tipo_inmueble'      => 'required|in:Casa,Edificio,Local,Garage',
            'precio'             => 'required|numeric|min:0',
            'metros_cuadrados'   => 'required|integer|min:0',
            'fecha_construccion' => 'required|date',
            'propietario_id'     => 'required|exists:propietarios,id',
        ]);

        Propiedad::create([
            'propietario_id'     => $request->propietario_id,
            'titulo'             => $request->titulo,
            'zona'               => $request->zona,
            'precio'             => $request->precio,
            'metros_cuadrados'   => $request->metros_cuadrados,
            'num_habitaciones'   => $request->num_habitaciones ?: null,
            'fecha_construccion' => $request->fecha_construccion,
            'amueblada'          => $request->boolean('amueblada'),
            'tipo_inmueble'      => $request->tipo_inmueble,
            'descripcion'        => $request->descripcion,
            'imagen'             => $request->imagen,
        ]);

        return redirect()->route('admin.dashboard')->with('ok', 'creada');
    }

    // Mostrar formulario editar
    public function edit($id)
    {
        $propiedad    = Propiedad::findOrFail($id);
        $propietarios = Propietario::orderBy('nombre')->get();
        return view('admin.editar', compact('propiedad', 'propietarios'));
    }

    // Guardar cambios
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo'             => 'required|string|max:150',
            'zona'               => 'required|string',
            'tipo_inmueble'      => 'required|in:Casa,Edificio,Local,Garage',
            'precio'             => 'required|numeric|min:0',
            'metros_cuadrados'   => 'required|integer|min:0',
            'fecha_construccion' => 'required|date',
            'propietario_id'     => 'required|exists:propietarios,id',
        ]);

        $propiedad = Propiedad::findOrFail($id);
        $propiedad->update([
            'propietario_id'     => $request->propietario_id,
            'titulo'             => $request->titulo,
            'zona'               => $request->zona,
            'precio'             => $request->precio,
            'metros_cuadrados'   => $request->metros_cuadrados,
            'num_habitaciones'   => $request->num_habitaciones ?: null,
            'fecha_construccion' => $request->fecha_construccion,
            'amueblada'          => $request->boolean('amueblada'),
            'tipo_inmueble'      => $request->tipo_inmueble,
            'descripcion'        => $request->descripcion,
            'imagen'             => $request->imagen,
        ]);

        return redirect()->route('admin.dashboard')->with('ok', 'editada');
    }

    // Eliminar propiedad
    public function destroy($id)
    {
        Propiedad::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard')->with('ok', 'eliminada');
    }

    // Exportar PDF
    public function exportarPDF()
{
    $propiedades = Propiedad::with('propietario')
                            ->orderBy('zona')
                            ->orderBy('precio', 'desc')
                            ->get();

    $pdf = Pdf::loadView('admin.pdf', compact('propiedades'));
    return $pdf->download('vercetti_properties_' . date('Y-m-d') . '.pdf');
}
}