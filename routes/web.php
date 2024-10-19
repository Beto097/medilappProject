<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\caracteristica_examen_controller;
use App\Http\Controllers\loginController;
use App\Http\Controllers\medicoController;
use App\Http\Controllers\ordenLaboratorioController;
use App\Http\Controllers\pacienteController;
use App\Http\Controllers\tipoexamenController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\resultadoController;
use App\Http\Controllers\roldepantallaController;
use App\Http\Controllers\examenController;
use App\Http\Controllers\usuarioController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/ordenCliente/{id}", [Controller::class, 'ordenCliente']);

//LOGIN
Route::get("/login", [loginController::class, 'index'])->name("login.index");
Route::post("/login", [loginController::class, 'login'])->name("login.login");
Route::get("/cerrar", [loginController::class, 'cerrar'])->name("login.cerrar");

Route::get("/cufe", [Controller::class, 'verCufe']);
Route::POST("/cufe", [Controller::class, 'prueba'])->name('cufe.insert');

Route::get("/pruebas", [Controller::class, 'generarPassword']);


Route::post("/mail/pdf/", [mailController::class, 'enviarcorreo'])->name("enviar.correo");
Route::post("/mail/pdfGrupo/", [mailController::class, 'enviarcorreoGrupo'])->name("enviar.correoGrupo");

Route::get("/seleccionar/compañia/{id}", [Controller::class, 'seleccionarCompany'])->name("seleccionar.company");



//PDF
Route::get("/imprimir/pdf/{id}", [pdfController::class, 'pdfResultado'])->name("imprimir.resultado");
Route::get("/imprimir/orden/{id}", [pdfController::class, 'imprimirOrden'])->name("imprimir.orden");
Route::get("/imprimir/X/{id}/{tipo}", [pdfController::class, 'pdfResultadoGrupo'])->name("imprimir.XGrupo");
Route::get("/mail/imprimir/pdf/{id}", [pdfController::class, 'pdfMailResultado'])->name("imprimir.mail.resultado");




//PANTALLAS Y ROLES
Route::get("/pantalla", [roldepantallaController::class,'index'])->name("pantalla.index");
Route::get("/pantalla/create", [roldepantallaController::class, 'create'])->name("pantalla.create");
Route::post("/pantalla/create", [roldepantallaController::class, 'insert'])->name("pantalla.insert");
Route::get("rol/pantalla/{id}", [roldepantallaController::class,'rolPantalla'])->name("rol.pantallas");
Route::get("/pantalla/delete/{id}",[roldepantallaController::class,'elimina'])->name("pantalla.delete");
Route::get("/pantalladmin/update/{id}",[roldepantallaController::class,'update'])->name("pantalla.update");
Route::post("/pantalladmin/update",[roldepantallaController::class,'save'])->name("pantalla.save");
Route::post("/rol/pantalla/save",[roldepantallaController::class,'pantallaSave'])->name("rolPantalla.save");
Route::get("roles/pantalla/{id}", [roldepantallaController::class,'rolesPantalla'])->name("roles.pantallas");
Route::get("roles/pantallas", [roldepantallaController::class,'rolesPantallas'])->name("roles.pantallas.index");
Route::get("/rol", [roldepantallaController::class,'rolIndex'])->name("rol.index");
Route::POST("/rol/create", [roldepantallaController::class,'rolInsert'])->name("rol.insert");
Route::POST("/rol/save", [roldepantallaController::class,'rolSave'])->name("rol.save");
Route::get("/rol/delete/{id}", [roldepantallaController::class,'rolDelete'])->name("rol.delete");
Route::get("/rol/unlock/{id}", [roldepantallaController::class,'rolUnlock'])->name("rol.desbloquear");

//USUARIO
Route::get("/usuario", [usuarioController::class, 'index'])->name("usuario.index");
Route::get("/usuario/create", [usuarioController::class, 'create'])->name("usuario.create");
Route::post("/usuario/create", [usuarioController::class, 'insert'])->name("usuario.insert");
Route::get("/usuario/update/{id}", [usuarioController::class, 'update'])->name("usuario.update");
Route::post("/usuario/update", [usuarioController::class, 'save'])->name("usuario.save");
Route::get("/usuario/delete/{id}", [usuarioController::class, 'delete'])->name("usuario.delete");
Route::get("/usuario/desbloquear/{id}", [usuarioController::class, 'desbloquear'])->name("usuario.desbloquear");
Route::get("/usuario/bloquear/{id}", [usuarioController::class, 'bloquear'])->name("usuario.bloquear");
Route::get("/usuario/nuevaPassword/{id}", [usuarioController::class, 'updatePassword'])->name("usuario.update.password");
Route::post("/usuario/nuevaPassword/{id}", [usuarioController::class, 'updatePasswordSave'])->name("usuario.update.password.save");
Route::get("/userName/{usuario}", [usuarioController::class, 'userName'])->name("userName.usuario");
Route::get("/email/{correo}", [usuarioController::class, 'Correo'])->name("Correo.usuario");

//VALIDACIONES
Route::get("/consultar/{cedula}", [Controller::class, 'consultar'])->name("consultar.cedula");
Route::get("/consultarRegistro/{registro}", [Controller::class, 'consultarRegistro'])->name("consultar.registro");

//NOTIFICACIONES
Route::get("/notificacion/{id}", [resultadoController::class, 'notificacion'])->name("notificacion.orden");
Route::get("/notificacion/ordenTerminada/{id}", [resultadoController::class, 'ordenTerminada'])->name("notificacion.ordenTerminada");
Route::get("/notificacion/borrar/todas", [Controller::class, 'notificacionBorrarTodas'])->name("notificacion.borrarTodas");

Route::middleware('dynamic_database')->group(function () {

    Route::get('/', [Controller::class, 'index'])->name('index');

    //Pacientes
    Route::get("/paciente/buscar", [pacienteController::class, 'busqueda'])->name("paciente.busqueda");
    Route::post("/paciente/buscar", [pacienteController::class, 'buscar'])->name("paciente.buscar");
    Route::get("/paciente", [pacienteController::class, 'index'])->name("paciente.index");
    Route::get("/paciente/create", [pacienteController::class, 'create'])->name("paciente.create");
    Route::post("/paciente/create", [pacienteController::class, 'insert'])->name("paciente.insert");
    Route::get("/paciente/update/{id}", [pacienteController::class, 'update'])->name("paciente.update");
    Route::post("/paciente/update", [pacienteController::class, 'save'])->name("paciente.save");
    Route::get("/paciente/delete/{id}", [pacienteController::class, 'eliminar'])->name("paciente.delete");
    Route::get("/paciente/desbloquear/{id}", [pacienteController::class, 'desbloquear'])->name("paciente.desbloquear");
    Route::get("/paciente/verPassword/{id}", [pacienteController::class, 'verPassword'])->name("paciente.verPassword");
    Route::get("/paciente/historial/{id}", [ordenLaboratorioController::class, 'verHistorial'])->name("paciente.verHistorial");
    Route::get("/consultar/{cedula}", [ordenLaboratorioController::class, 'consultar'])->name("consultar.cedula");
    Route::get("/consultarRegistro/{registro}", [ordenLaboratorioController::class, 'consultarRegistro'])->name("consultar.registro");

    //MEDICO
    Route::get("/medico", [medicoController::class, 'index'])->name("medico.index");
    Route::get("/medico/create", [medicoController::class, 'create'])->name("medico.create");
    Route::get("/medico/crear", [medicoController::class, 'create'])->name("medico.crear");
    Route::post('/medico/create', [medicoController::class, 'insert'])->name("medico.insert") ;
    Route::post('/medico/crear', [medicoController::class, 'insert'])->name("medico.insertar");
    Route::get("/medico/update/{id}", [medicoController::class, 'update'])->name("medico.update");
    Route::post("/medico/update", [medicoController::class, 'save'])->name("medico.save");
    Route::get("/medico/delete/{id}", [medicoController::class, 'delete'])->name("medico.delete");
    Route::get("/medico/desbloquear/{id}", [medicoController::class, 'desbloquear'])->name("medico.desbloquear");

    //EXAMEN
    Route::get("/examen", [examenController::class, 'index'])->name("examen.index");
    Route::get("/examen/create", [examenController::class, 'crear'])->name("examen.create");
    Route::get("/examen/create/{id}", [examenController::class, 'crear2'])->name("examen.crear2");
    Route::get("/examen/create/ordenar/{id}", [examenController::class, 'crear3'])->name("examen.crear3");
    Route::post("/examen/create/ordenar", [examenController::class, 'insert3'])->name("examen.insert3");
    Route::post("/examen/create", [examenController::class, 'insert'])->name("examen.insert");
    Route::post("/examen/create2", [examenController::class, 'insert2'])->name("examen.insert2");
    Route::post("/examen/save", [examenController::class, 'save'])->name("examen.save");
    Route::post("/examen/save2", [examenController::class, 'save2'])->name("examen.save2");
    Route::get("/examen/update/{id}", [examenController::class, 'update'])->name("examen.update");
    Route::get("/examen/update2/{id}", [examenController::class, 'update2'])->name("examen.update2");
    Route::get("/examen/delete/{id}", [examenController::class, 'delete'])->name("examen.delete");

    //TIPO DE EXAMEN
    Route::get("/tipoexamen", [tipoexamenController::class, 'index'])->name("tipoexamen.index");
    Route::get("/tipoexamen/create", [tipoexamenController::class, 'create'])->name("tipoexamen.create");
    Route::post("/tipoexamen/create", [tipoexamenController::class, 'insert'])->name("tipoexamen.insert");
    Route::get("/tipoexamen/update/{id}", [tipoexamenController::class, 'update'])->name("tipoexamen.update");
    Route::post("/tipoexamen/update", [tipoexamenController::class, 'save'])->name("tipoexamen.save");
    Route::get("/tipoexamen/delete/{id}", [tipoexamenController::class, 'delete'])->name("tipoexamen.delete");
    Route::get("/tipoexamen/desbloquear/{id}", [tipoexamenController::class, 'desbloquear'])->name("tipoexamen.desbloquear");

    //CARACTERISTICAS DE EXAMEN
    Route::get("/caracteristicaExamen",[caracteristica_examen_controller::class,'index'])->name("caracteristica_examen.index");
    Route::get("/caracteristicaExamen/create",[caracteristica_examen_controller::class,'create'])->name("caracteristica_examen.create");
    Route::post("/caracteristicaExamen/create",[caracteristica_examen_controller::class,'insert'])->name("caracteristica_examen.insert");
    Route::get("/caracteristicaExamen/update/{id}",[caracteristica_examen_controller::class,'update'])->name("caracteristica_examen.update");
    Route::post("/caracteristicaExamen/update", [caracteristica_examen_controller::class, 'save'])->name("caracteristica_examen.save");
    Route::get("/caracteristicaExamen/delete/{id}", [caracteristica_examen_controller::class, 'delete'])->name("caracteristica_examen.eliminar");
    Route::get("/caracteristicaExamen/desbloquear/{id}", [caracteristica_examen_controller::class, 'desbloquear'])->name("caracteristica_examen.desbloquear");

    //ORDEN DE LABORATORIO
    Route::get("/orden_laboratorio", [ordenLaboratorioController::class, 'index'])->name("orden_laboratorio.index");
    Route::get("/orden_laboratorio/create", [ordenLaboratorioController::class, 'create'])->name("orden_laboratorio.create");
    Route::get("/orden_laboratorio/create/{id}", [ordenLaboratorioController::class, 'create2'])->name("orden_laboratorio.create2");
    Route::post("/orden_laboratorio/create", [ordenLaboratorioController::class, 'insert'])->name("orden_laboratorio.insert");
    Route::get("/orden_laboratorio/createnext", [ordenLaboratorioController::class, 'createnext'])->name("orden_laboratorio.createnext");
    Route::post("/orden_laboratorio/next", [ordenLaboratorioController::class, 'createnext'])->name("orden_laboratorio.next");
    Route::get("/orden_laboratorio/delete/{id}", [ordenLaboratorioController::class, 'delete'])->name("orden_laboratorio.delete");
    Route::get("/orden_laboratorio/desbloquear/{id}", [ordenLaboratorioController::class, 'desbloquear'])->name("orden_laboratorio.desbloquear");
    Route::get("/orden_laboratorio/update/{id}", [ordenLaboratorioController::class, 'update'])->name("orden_laboratorio.update");
    Route::post("/orden_laboratorio/update", [ordenLaboratorioController::class, 'save'])->name("orden_laboratorio.save");
    Route::post("/orden_laboratorio/updatenext", [ordenLaboratorioController::class, 'updatenext'])->name("orden_laboratorio.updatenext");

    //RESULTADOS
    Route::get("/ordenesLaboratorio", [resultadoController::class, 'index'])->name("resultado.index");
    Route::get("/ordenesLaboratorio/ver", [resultadoController::class, 'index'])->name("resultado.ver");
    Route::get("/ordenesLaboratorio/generarOrden/{id}", [resultadoController::class, 'generarOrden'])->name("resultado.generarOrden");
    Route::get("/ordenesLaboratorio/examenes/{id}", [resultadoController::class, 'examenes'])->name("ordenLaboratorio.examenes");
    Route::get("/ordenesLaboratorio/resultados/{id}", [resultadoController::class, 'resultados'])->name("ordenLaboratorio.resultados");
    Route::get("/ordenesLaboratorio/resultados1/{id}", [resultadoController::class, 'resultados1'])->name("ordenLaboratorio.resultados1");
    Route::get("/ordenesLaboratorio/verResultados/{id}", [resultadoController::class, 'verResultados'])->name("ordenLaboratorio.ver.resultados");
    Route::post("/ordenesLaboratorio/resultados/{id}", [resultadoController::class, 'insertarResultados'])->name("insertar.resultados");
    Route::get("/ordenesLaboratorio/resultados/update/{id}", [resultadoController::class, 'update'])->name("ordenLaboratorio.update.resultados");
    Route::post("/ordenesLaboratorio/save}", [resultadoController::class, 'save'])->name("ordenLaboratorio.save.resultado");
    Route::get("/ordenesLaboratorio/examen/eliminar/{id}", [resultadoController::class, 'eliminarExamen'])->name("ordenLaboratorio.examen.eliminar");
    Route::get("/ordenesLaboratorio/examen/terminado/{id}", [resultadoController::class, 'examenTerminado'])->name("ordenLaboratorio.examen.terminado");
    
});