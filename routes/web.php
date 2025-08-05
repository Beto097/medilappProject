<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\loginController;
use App\Http\Controllers\usuarioController;
use App\Http\Controllers\pantallaController;
use App\Http\Controllers\rolController;
use App\Http\Controllers\sucursalController;
use App\Http\Controllers\pacienteController;
use App\Http\Controllers\medicoController;
use App\Http\Controllers\consultaController;
use App\Http\Controllers\recetaController;
use App\Http\Controllers\certificadoController;
use App\Http\Controllers\referenciaController;
use App\Http\Controllers\constanciaController;
use App\Http\Controllers\archivoController;


Route::get('/', [loginController::class, 'dashboard'])->name('index');






//Pacientes
Route::get("/paciente", [pacienteController::class, 'index'])->name("paciente.index");
Route::get("/paciente/create", [pacienteController::class, 'create'])->name("paciente.create");
Route::post("/paciente/create", [pacienteController::class, 'insert'])->name("paciente.insert");
Route::get("/paciente/update/{id}", [pacienteController::class, 'update'])->name("paciente.update");
Route::post("/paciente/update", [pacienteController::class, 'save'])->name("paciente.save");
Route::get("/paciente/delete/{id}", [pacienteController::class, 'eliminar'])->name("paciente.delete");
Route::get("/paciente/desbloquear/{id}", [pacienteController::class, 'desbloquear'])->name("paciente.desbloquear");
Route::get("/paciente/verPassword/{id}", [pacienteController::class, 'verPassword'])->name("paciente.verPassword");
Route::get("/paciente/historial/{id}", [pacienteController::class, 'verHistorial'])->name("paciente.verHistorial");
Route::get("/paciente/verArchivo/{id}", [pacienteController::class, 'verHistorial'])->name("paciente.verHistorial");
Route::get("/paciente/buscar", [pacienteController::class, 'buscar'])->name("paciente.buscar");
Route::post("/paciente/buscar", [pacienteController::class, 'search'])->name("paciente.search");
Route::get("/paciente/ajax-buscar", [pacienteController::class, 'ajaxBuscar'])->name('paciente.ajaxBuscar');

//MEDICO
Route::get("/medico", [medicoController::class, 'index'])->name("medico.index");
Route::get("/medico/create", [medicoController::class, 'create'])->name("medico.create");
Route::get("/medico/crear", [medicoController::class, 'create'])->name("medico.crear");
Route::post('/medico/create', [medicoController::class, 'insert'])->name("medico.insert") ;
Route::get("/medico/update/{id}", [medicoController::class, 'update'])->name("medico.update");
Route::post("/medico/update", [medicoController::class, 'save'])->name("medico.save");
Route::get("/medico/delete/{id}", [medicoController::class, 'delete'])->name("medico.delete");
Route::get("/medico/desbloquear/{id}", [medicoController::class, 'desbloquear'])->name("medico.desbloquear");

//SUCURSALES
Route::get("/sucursal", [sucursalController::class, 'index'])->name("sucursal.index");
Route::get("/sucursal/create", [sucursalController::class, 'create'])->name("sucursal.create");
Route::post("/sucursal/create", [sucursalController::class, 'insert'])->name("sucursal.insert");
Route::post("/sucursal/actualizar", [sucursalController::class, 'actualizar'])->name("sucursal.actualizar");
Route::post("/sucursal/save", [sucursalController::class, 'save'])->name("sucursal.save");
Route::get("/sucursal/desbloquear/{id}", [sucursalController::class, 'desbloquear'])->name("sucursal.desbloquear");
Route::get("/sucursal/delete/{id}", [sucursalController::class, 'delete'])->name("sucursal.delete");

/*Consultas*/
Route::get("/consulta", [consultaController::class, 'index'])->name("consulta.index");
Route::Post("/consulta/iniciar", [consultaController::class, 'insert'])->name("consulta.insert");
Route::get("/paciente/iniciar/consulta/{id}", [consultaController::class, 'iniciar'])->name("consulta.iniciar");
Route::get("/paciente/consulta/{id}", [consultaController::class, 'create2'])->name("consulta.create2");
Route::POST("/consulta/guardar", [consultaController::class, 'save'])->name("consulta.save");
Route::get("/consulta/historial/{id}", [consultaController::class, 'historial'])->name("consulta.historial");
Route::Post("/consulta/doctor/", [consultaController::class, 'doctor'])->name("consulta.doctor");
Route::Post("/consulta/reasignar/", [consultaController::class, 'reasignar'])->name("consulta.reasignar");
Route::get("/consulta/delete/{id}", [consultaController::class, 'delete'])->name("consulta.delete");
Route::get("/consulta/ver/historial/{id}", [consultaController::class, 'verHistorial'])->name("consulta.ver.historial");

/*Recetas*/
Route::get("/receta", [consultaController::class, 'index'])->name("consulta.index");
Route::Post("/receta/save", [recetaController::class, 'recetaSave'])->name("receta.save");
Route::Post("/receta/edit", [recetaController::class, 'edit'])->name("receta.edit");
Route::get("/receta/print/{id}", [recetaController::class, 'print'])->name("receta.print");
Route::get("/receta/printCompleto/{id}", [recetaController::class, 'printCompleto'])->name("receta.printCompleto");
Route::get("/receta/printOld/{id}", [recetaController::class, 'printOld'])->name("receta.printOld");

/*Certificado*/
Route::Post("/certificado/insert", [certificadoController::class, 'insert'])->name("certificado.insert");
Route::get("/certificado/print/{id}", [certificadoController::class, 'print'])->name("certificado.print");

/*Referencia*/

Route::Post("/referencia/insert", [referenciaController::class, 'insert'])->name("referencia.insert");
Route::get("/referencia/print/{id}", [referenciaController::class, 'print'])->name("referencia.print");

/*Constancia*/
Route::Post("/constancia/insert", [constanciaController::class, 'insert'])->name("constancia.insert");
Route::get("/constancia/print/{id}", [constanciaController::class, 'print'])->name("constancia.print");

/*Archivo*/
Route::Post("/archivo/insert", [archivoController::class, 'insert'])->name("archivo.insert");
Route::get("/archivo/delete/{id}", [archivoController::class, 'delete'])->name("archivo.delete");
Route::get("/paciente/verArchivo/{id}", [archivoController::class, 'verArchivos'])->name("paciente.verArchivo");

Route::Post("/imprimir/select", [consultaController::class, 'select'])->name("imprimir.select");
Route::Post("/imprimir/selectToPrint", [consultaController::class, 'selectToPrint'])->name("imprimir.selectToPrint");

// -----------------------------------------------------------------------------------------------------------------

 //rutas pantalla y rol de pantalla
 Route::get("/pantalla", [pantallaController::class,'index'])->name("pantalla.index");
 Route::get("/pantalla/create", [pantallaController::class, 'create'])->name("pantalla.create");
 Route::post("/pantalla/create", [pantallaController::class, 'insert'])->name("pantalla.insert");
 Route::get("rol/pantalla/{id}", [pantallaController::class,'rolPantalla'])->name("rol.pantallas");
 Route::get("/pantalla/delete/{id}",[pantallaController::class,'delete'])->name("pantalla.delete");
 Route::get("/pantalla/update/{id}",[pantallaController::class,'update'])->name("pantalla.update");
 Route::post("/pantalla/update",[pantallaController::class,'save'])->name("pantalla.save");
 Route::post("/rol/pantalla/save",[pantallaController::class,'pantallaSave'])->name("rolPantalla.save");
 Route::get("roles/pantalla/{id}", [pantallaController::class,'rolesPantalla'])->name("roles.pantallas");
 Route::get("roles/pantallas", [pantallaController::class,'rolesPantallas'])->name("roles.pantallas.index");
 Route::get("/rol", [rolController::class,'index'])->name("rol.index");
 Route::get("/rol/create", [rolController::class,'create'])->name("rol.create");
 Route::post("/rol/create", [rolController::class,'insert'])->name("rol.insert");
 Route::post("/rol/save", [rolController::class,'save'])->name("rol.save");
 Route::get("/rol/delete/{id}", [rolController::class,'delete'])->name("rol.delete");


//NOTIFICACIONES
//Route::get("/notificacion/{id}", [resultadoController::class, 'notificacion'])->name("notificacion.orden");
//Route::get("/notificacion/ordenTerminada/{id}", [resultadoController::class, 'ordenTerminada'])->name("notificacion.ordenTerminada");
//Route::get("/notificacion/borrar/todas", [Controller::class, 'notificacionBorrarTodas'])->name("notificacion.borrarTodas");

//VALIDACIONES
Route::get("/consultar/{cedula}", [pacienteController::class, 'consultar'])->name("consultar.cedula");
Route::get("/consultarRegistro/{registro}", [medicoController::class, 'consultarRegistro'])->name("consultar.registro");

//USUARIO
Route::get("/usuario", [usuarioController::class, 'index'])->name("usuario.index");
Route::get("/usuario/create", [usuarioController::class, 'create'])->name("usuario.create");
Route::post("/usuario/create", [usuarioController::class, 'insert'])->name("usuario.insert");
Route::get("/usuario/update/{id}", [usuarioController::class, 'update'])->name("usuario.update");
Route::post("/usuario/update", [usuarioController::class, 'save'])->name("usuario.save");
Route::get("/usuario/delete/{id}", [usuarioController::class, 'delete'])->name("usuario.delete");
Route::get("/usuario/desbloquear/{id}", [usuarioController::class, 'desbloquear'])->name("usuario.desbloquear");
Route::get("/usuario/bloquear/{id}", [usuarioController::class, 'bloquear'])->name("usuario.bloquear");
Route::post("/usuario/nuevaPassword/", [usuarioController::class, 'updatePassword'])->name("password.update");
Route::get("/userName/{usuario}", [usuarioController::class, 'userName'])->name("userName.usuario");
Route::get("/email/{correo}", [usuarioController::class, 'Correo'])->name("Correo.usuario");

//LOGIN
Route::get("/login", [loginController::class, 'index'])->name("login.index");
Route::post("/login", [loginController::class, 'login'])->name("login.login");
Route::get("/cerrar", [loginController::class, 'cerrar'])->name("login.cerrar");


Route::get("/pruebaReceta", [consultaController::class, 'prueba']);
