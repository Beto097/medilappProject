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
use App\Http\Controllers\examenController;
use App\Http\Controllers\caracteristicaController;
use App\Http\Controllers\archivoController;
use App\Http\Controllers\ordenlaboratorioController;
use App\Http\Controllers\resultadoController;
use App\Http\Controllers\tipoexamenController;

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

/*Orden laboratorio*/
Route::get("/ordenlaboratorio", [ordenlaboratorioController::class, 'index'])->name("ordenlaboratorio.index");
Route::get("/ordenlaboratorio/create", [ordenlaboratorioController::class, 'create'])->name("ordenlaboratorio.create");
Route::get("/ordenlaboratorio/create/{id}", [ordenlaboratorioController::class, 'create2'])->name("ordenlaboratorio.create2");
Route::post("/ordenlaboratorio/create", [ordenlaboratorioController::class, 'insert'])->name("ordenlaboratorio.insert");
Route::get("/ordenlaboratorio/createnext", [ordenlaboratorioController::class, 'createnext'])->name("ordenlaboratorio.createnext");
Route::post("/ordenlaboratorio/next", [ordenlaboratorioController::class, 'createnext'])->name("ordenlaboratorio.next");
Route::get("/ordenlaboratorio/delete/{id}", [ordenlaboratorioController::class, 'delete'])->name("ordenlaboratorio.delete");
Route::get("/ordenlaboratorio/desbloquear/{id}", [ordenlaboratorioController::class, 'desbloquear'])->name("ordenlaboratorio.desbloquear");
Route::get("/ordenlaboratorio/update/{id}", [ordenlaboratorioController::class, 'update'])->name("ordenlaboratorio.update");
Route::post("/ordenlaboratorio/update", [ordenlaboratorioController::class, 'save'])->name("ordenlaboratorio.save");
Route::post("/ordenlaboratorio/updatenext", [ordenlaboratorioController::class, 'updatenext'])->name("ordenlaboratorio.updatenext");
Route::get("/consultar/{cedula}", [ordenlaboratorioController::class, 'consultar'])->name("consultar.cedula");
Route::get("/consultarRegistro/{registro}", [ordenlaboratorioController::class, 'consultarRegistro'])->name("consultar.registro");
Route::get("/ordenesLaboratorio", [resultadoController::class, 'index'])->name("resultado.index");
Route::get("/ordenesLaboratorio/ver", [resultadoController::class, 'index'])->name("resultado.ver");
Route::get("/ordenesLaboratorio/historial", [resultadoController::class, 'historial'])->name("resultado.historial");
Route::get("/ordenesLaboratorio/examenes/{id}", [resultadoController::class, 'examenes'])->name("ordenLaboratorio.examenes");
Route::get("/ordenesLaboratorio/resultados/{id}", [resultadoController::class, 'resultados'])->name("ordenLaboratorio.resultados");
Route::get("/ordenesLaboratorio/resultados1/{id}", [resultadoController::class, 'resultados1'])->name("ordenLaboratorio.resultados1");
Route::get("/ordenesLaboratorio/verResultados/{id}", [resultadoController::class, 'verResultados'])->name("ordenLaboratorio.ver.resultados");
Route::post("/ordenesLaboratorio/resultados/{id}", [resultadoController::class, 'insertarResultados'])->name("insertar.resultados");
Route::get("/ordenesLaboratorio/resultados/update/{id}", [resultadoController::class, 'update'])->name("ordenLaboratorio.update.resultados");
Route::post("/ordenesLaboratorio/save", [resultadoController::class, 'save'])->name("ordenLaboratorio.save.resultado");
Route::post("/ordenesLaboratorio/guardar", [resultadoController::class, 'guardar'])->name("ordenLaboratorio.guardar");
Route::get("/ordenesLaboratorio/examen/eliminar/{id}", [resultadoController::class, 'eliminarExamen'])->name("ordenLaboratorio.examen.eliminar");
Route::get("/ordenesLaboratorio/examen/terminado/{id}", [resultadoController::class, 'examenTerminado'])->name("ordenLaboratorio.examen.terminado");
Route::Post("/ordenesLaboratorio/examen/subir", [resultadoController::class, 'subirArchivo'])->name("ordenLaboratorio.examen.subirResultado");


Route::get("/pruebaReceta", [consultaController::class, 'prueba']);


/*caracteristica examen*/
Route::get("/caracteristicaExamen",[caracteristicaController::class,'index'])->name("caracteristica_examen.mostrar");
Route::get("/caracteristicaExamen/create",[caracteristicaController::class,'create'])->name("caracteristica_examen.create");
Route::post("/caracteristicaExamen/create",[caracteristicaController::class,'insert'])->name("caracteristica_examen.insert");
Route::get("/caracteristicaExamen/update/{id}",[caracteristicaController::class,'update'])->name("caracteristica_examen.update");
Route::post("/caracteristicaExamen/update", [caracteristicaController::class, 'save'])->name("caracteristica_examen.save");
Route::get("/caracteristicaExamen/delete/{id}", [caracteristicaController::class, 'delete'])->name("caracteristica_examen.delete");
Route::get("/caracteristicaExamen/desbloquear/{id}", [caracteristicaController::class, 'desbloquear'])->name("caracteristica_examen.desbloquear");

//Rutas Examen por Jahaziel De Salas
Route::get("/examen", [examenController::class, 'index'])->name("examen.index");
Route::get("/examen/create", [examenController::class, 'crear'])->name("examen.crear");
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


/*tipoexamen*/
Route::get("/tipoexamen", [tipoexamenController::class, 'index'])->name("tipoexamen.index");
Route::get("/tipoexamen/create", [tipoexamenController::class, 'create'])->name("tipoexamen.create");
Route::post("/tipoexamen/create", [tipoexamenController::class, 'insert'])->name("tipoexamen.insert");
Route::get("/tipoexamen/update/{id}", [tipoexamenController::class, 'update'])->name("tipoexamen.update");
Route::post("/tipoexamen/update", [tipoexamenController::class, 'save'])->name("tipoexamen.save");
Route::get("/tipoexamen/delete/{id}", [tipoexamenController::class, 'delete'])->name("tipoexamen.delete");
Route::get("/tipoexamen/desbloquear/{id}", [tipoexamenController::class, 'desbloquear'])->name("tipoexamen.desbloquear");


