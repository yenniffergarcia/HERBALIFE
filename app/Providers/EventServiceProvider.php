<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        /*'App\Events\CreatedTipoEmailEvent' => [
            'App\Listeners\CreatedTipoEmailListener',
        ],  */     
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],

        'altaproducto.created' => [
            'App\Events\AltaProductoEvent@created',
        ],
        'altaproducto.updating' => [
            'App\Events\AltaProductoEvent@updating',
        ],        
        'altaproducto.updated' => [
            'App\Events\AltaProductoEvent@updated',
        ],
        'altaproducto.deleted' => [
            'App\Events\AltaProductoEvent@deleted',
        ],

        'alumnocontenidoeducativo.created' => [
            'App\Events\AlumnoContenidoEducativoEvent@created',
        ],
        'alumnocontenidoeducativo.updating' => [
            'App\Events\AlumnoContenidoEducativoEvent@updating',
        ],        
        'alumnocontenidoeducativo.updated' => [
            'App\Events\AlumnoContenidoEducativoEvent@updated',
        ],
        'alumnocontenidoeducativo.deleted' => [
            'App\Events\AlumnoContenidoEducativoEvent@deleted',
        ],  

        'alumnocuestionariorespuesta.created' => [
            'App\Events\AlumnoCuestionarioRespuestaEvent@created',
        ],
        'alumnocuestionariorespuesta.updating' => [
            'App\Events\AlumnoCuestionarioRespuestaEvent@updating',
        ],        
        'alumnocuestionariorespuesta.updated' => [
            'App\Events\AlumnoCuestionarioRespuestaEvent@updated',
        ],
        'alumnocuestionariorespuesta.deleted' => [
            'App\Events\AlumnoCuestionarioRespuestaEvent@deleted',
        ], 

        'bajaproducto.created' => [
            'App\Events\BajaProductoEvent@created',
        ],
        'bajaproducto.updating' => [
            'App\Events\BajaProductoEvent@updating',
        ],        
        'bajaproducto.updated' => [
            'App\Events\BajaProductoEvent@updated',
        ],
        'bajaproducto.deleted' => [
            'App\Events\BajaProductoEvent@deleted',
        ],                               

        'cantidadalumno.created' => [
            'App\Events\CantidadAlumnoEvent@created',
        ],
        'cantidadalumno.updating' => [
            'App\Events\CantidadAlumnoEvent@updating',
        ],        
        'cantidadalumno.updated' => [
            'App\Events\CantidadAlumnoEvent@updated',
        ],
        'cantidadalumno.deleted' => [
            'App\Events\CantidadAlumnoEvent@deleted',
        ], 

        'carrera.created' => [
            'App\Events\CarreraEvent@created',
        ],
        'carrera.updating' => [
            'App\Events\CarreraEvent@updating',
        ],        
        'carrera.updated' => [
            'App\Events\CarreraEvent@updated',
        ],
        'carrera.deleted' => [
            'App\Events\CarreraEvent@deleted',
        ],         

        'carreracurso.created' => [
            'App\Events\CarreraCursoEvent@created',
        ],
        'carreracurso.updating' => [
            'App\Events\CarreraCursoEvent@updating',
        ],        
        'carreracurso.updated' => [
            'App\Events\CarreraCursoEvent@updated',
        ],
        'carreracurso.deleted' => [
            'App\Events\CarreraCursoEvent@deleted',
        ], 

        'carreragrado.created' => [
            'App\Events\CarreraGradoGradoEvent@created',
        ],
        'carreragrado.updating' => [
            'App\Events\CarreraGradoGradoEvent@updating',
        ],        
        'carreragrado.updated' => [
            'App\Events\CarreraGradoGradoEvent@updated',
        ],
        'carreragrado.deleted' => [
            'App\Events\CarreraGradoGradoEvent@deleted',
        ], 

        'catedraticocontenidoeducativo.created' => [
            'App\Events\CatedraticoContenidoEducativoEvent@created',
        ],
        'catedraticocontenidoeducativo.updating' => [
            'App\Events\CatedraticoContenidoEducativoEvent@updating',
        ],        
        'catedraticocontenidoeducativo.updated' => [
            'App\Events\CatedraticoContenidoEducativoEvent@updated',
        ],
        'catedraticocontenidoeducativo.deleted' => [
            'App\Events\CatedraticoContenidoEducativoEvent@deleted',
        ],  

        'catedraticocurso.created' => [
            'App\Events\CatedraticoCursoEvent@created',
        ],
        'catedraticocurso.updating' => [
            'App\Events\CatedraticoCursoEvent@updating',
        ],        
        'catedraticocurso.updated' => [
            'App\Events\CatedraticoCursoEvent@updated',
        ],
        'catedraticocurso.deleted' => [
            'App\Events\CatedraticoCursoEvent@deleted',
        ], 

        'categoria.created' => [
            'App\Events\CategoriaEvent@created',
        ],
        'categoria.updating' => [
            'App\Events\CategoriaEvent@updating',
        ],        
        'categoria.updated' => [
            'App\Events\CategoriaEvent@updated',
        ],
        'categoria.deleted' => [
            'App\Events\CategoriaEvent@deleted',
        ],    

        'ciclo.created' => [
            'App\Events\CicloEvent@created',
        ],
        'ciclo.updating' => [
            'App\Events\CicloEvent@updating',
        ],        
        'ciclo.updated' => [
            'App\Events\CicloEvent@updated',
        ],
        'ciclo.deleted' => [
            'App\Events\CicloEvent@deleted',
        ],

        'compania.created' => [
            'App\Events\CompaniaEvent@created',
        ],
        'compania.updating' => [
            'App\Events\CompaniaEvent@updating',
        ],        
        'compania.updated' => [
            'App\Events\CompaniaEvent@updated',
        ],
        'compania.deleted' => [
            'App\Events\CompaniaEvent@deleted',
        ],

        'cuestionario.created' => [
            'App\Events\CuestionarioEvent@created',
        ],
        'cuestionario.updating' => [
            'App\Events\CuestionarioEvent@updating',
        ],        
        'cuestionario.updated' => [
            'App\Events\CuestionarioEvent@updated',
        ],
        'cuestionario.deleted' => [
            'App\Events\CuestionarioEvent@deleted',
        ],  

        'curso.created' => [
            'App\Events\CursoEvent@created',
        ],
        'curso.updating' => [
            'App\Events\CursoEvent@updating',
        ],        
        'curso.updated' => [
            'App\Events\CursoEvent@updated',
        ],
        'curso.deleted' => [
            'App\Events\CursoEvent@deleted',
        ], 

        'descuento.created' => [
            'App\Events\DescuentoEvent@created',
        ],
        'descuento.updating' => [
            'App\Events\DescuentoEvent@updating',
        ],        
        'descuento.updated' => [
            'App\Events\DescuentoEvent@updated',
        ],
        'descuento.deleted' => [
            'App\Events\DescuentoEvent@deleted',
        ], 

        'email.created' => [
            'App\Events\EmailEvent@created',
        ],
        'email.updating' => [
            'App\Events\EmailEvent@updating',
        ],        
        'email.updated' => [
            'App\Events\EmailEvent@updated',
        ],
        'email.deleted' => [
            'App\Events\EmailEvent@deleted',
        ],  

        'encargadoalumno.created' => [
            'App\Events\EncargadoAlumnoEvent@created',
        ],
        'encargadoalumno.updating' => [
            'App\Events\EncargadoAlumnoEvent@updating',
        ],        
        'encargadoalumno.updated' => [
            'App\Events\EncargadoAlumnoEvent@updated',
        ],
        'encargadoalumno.deleted' => [
            'App\Events\EncargadoAlumnoEvent@deleted',
        ],  

        'estado.created' => [
            'App\Events\EstadoEvent@created',
        ],
        'estado.updating' => [
            'App\Events\EstadoEvent@updating',
        ],        
        'estado.updated' => [
            'App\Events\EstadoEvent@updated',
        ],
        'estado.deleted' => [
            'App\Events\EstadoEvent@deleted',
        ], 

        'etiqueta.created' => [
            'App\Events\EtiquetaEvent@created',
        ],
        'etiqueta.updating' => [
            'App\Events\EtiquetaEvent@updating',
        ],        
        'etiqueta.updated' => [
            'App\Events\EtiquetaEvent@updated',
        ],
        'etiqueta.deleted' => [
            'App\Events\EtiquetaEvent@deleted',
        ], 

        'formatodocumento.created' => [
            'App\Events\FormatoDocumentoEvent@created',
        ],
        'formatodocumento.updating' => [
            'App\Events\FormatoDocumentoEvent@updating',
        ],        
        'formatodocumento.updated' => [
            'App\Events\FormatoDocumentoEvent@updated',
        ],
        'formatodocumento.deleted' => [
            'App\Events\FormatoDocumentoEvent@deleted',
        ],  

        'genero.created' => [
            'App\Events\GeneroEvent@created',
        ],
        'genero.updating' => [
            'App\Events\GeneroEvent@updating',
        ],        
        'genero.updated' => [
            'App\Events\GeneroEvent@updated',
        ],
        'genero.deleted' => [
            'App\Events\GeneroEvent@deleted',
        ],     

        'grado.created' => [
            'App\Events\GradoEvent@created',
        ],
        'grado.updating' => [
            'App\Events\GradoEvent@updating',
        ],        
        'grado.updated' => [
            'App\Events\GradoEvent@updated',
        ],
        'grado.deleted' => [
            'App\Events\GradoEvent@deleted',
        ],  

        'inscripcion.created' => [
            'App\Events\InscripcionEvent@created',
        ],
        'inscripcion.updating' => [
            'App\Events\InscripcionEvent@updating',
        ],        
        'inscripcion.updated' => [
            'App\Events\InscripcionEvent@updated',
        ],
        'inscripcion.deleted' => [
            'App\Events\InscripcionEvent@deleted',
        ],  

        'inventariostockproducto.created' => [
            'App\Events\InventarioStockProductoEvent@created',
        ],
        'inventariostockproducto.updating' => [
            'App\Events\InventarioStockProductoEvent@updating',
        ],        
        'inventariostockproducto.updated' => [
            'App\Events\InventarioStockProductoEvent@updated',
        ],
        'inventariostockproducto.deleted' => [
            'App\Events\InventarioStockProductoEvent@deleted',
        ],   

        'mes.created' => [
            'App\Events\MesEvent@created',
        ],
        'mes.updating' => [
            'App\Events\MesEvent@updating',
        ],        
        'mes.updated' => [
            'App\Events\MesEvent@updated',
        ],
        'mes.deleted' => [
            'App\Events\MesEvent@deleted',
        ], 

        'monto.created' => [
            'App\Events\MontoEvent@created',
        ],
        'monto.updating' => [
            'App\Events\MontoEvent@updating',
        ],        
        'monto.updated' => [
            'App\Events\MontoEvent@updated',
        ],
        'monto.deleted' => [
            'App\Events\MontoEvent@deleted',
        ],

        'nota.created' => [
            'App\Events\NotaEvent@created',
        ],
        'nota.updating' => [
            'App\Events\NotaEvent@updating',
        ],        
        'nota.updated' => [
            'App\Events\NotaEvent@updated',
        ],
        'nota.deleted' => [
            'App\Events\NotaEvent@deleted',
        ],   

        'pago.created' => [
            'App\Events\PagoEvent@created',
        ],
        'pago.updating' => [
            'App\Events\PagoEvent@updating',
        ],        
        'pago.updated' => [
            'App\Events\PagoEvent@updated',
        ],
        'pago.deleted' => [
            'App\Events\PagoEvent@deleted',
        ],

        'paisdepartamento.created' => [
            'App\Events\PaisDepartamentoEvent@created',
        ],
        'paisdepartamento.updating' => [
            'App\Events\PaisDepartamentoEvent@updating',
        ],        
        'paisdepartamento.updated' => [
            'App\Events\PaisDepartamentoEvent@updated',
        ],
        'paisdepartamento.deleted' => [
            'App\Events\PaisDepartamentoEvent@deleted',
        ],

        'periodoacademico.created' => [
            'App\Events\PeriodoAcademicoEvent@created',
        ],
        'periodoacademico.updating' => [
            'App\Events\PeriodoAcademicoEvent@updating',
        ],        
        'periodoacademico.updated' => [
            'App\Events\PeriodoAcademicoEvent@updated',
        ],
        'periodoacademico.deleted' => [
            'App\Events\PeriodoAcademicoEvent@deleted',
        ],  

        'persona.created' => [
            'App\Events\PersonaEvent@created',
        ],
        'persona.updating' => [
            'App\Events\PersonaEvent@updating',
        ],        
        'persona.updated' => [
            'App\Events\PersonaEvent@updated',
        ],
        'persona.deleted' => [
            'App\Events\PersonaEvent@deleted',
        ],

        'personaprofesion.created' => [
            'App\Events\PersonaProfesionEvent@created',
        ],
        'personaprofesion.updating' => [
            'App\Events\PersonaProfesionEvent@updating',
        ],        
        'personaprofesion.updated' => [
            'App\Events\PersonaProfesionEvent@updated',
        ],
        'personaprofesion.deleted' => [
            'App\Events\PersonaProfesionEvent@deleted',
        ], 

        'pregunta.created' => [
            'App\Events\PreguntaEvent@created',
        ],
        'pregunta.updating' => [
            'App\Events\PreguntaEvent@updating',
        ],        
        'pregunta.updated' => [
            'App\Events\PreguntaEvent@updated',
        ],
        'pregunta.deleted' => [
            'App\Events\PreguntaEvent@deleted',
        ],

        'prioridad.created' => [
            'App\Events\PrioridadEvent@created',
        ],
        'prioridad.updating' => [
            'App\Events\PrioridadEvent@updating',
        ],        
        'prioridad.updated' => [
            'App\Events\PrioridadEvent@updated',
        ],
        'prioridad.deleted' => [
            'App\Events\PrioridadEvent@deleted',
        ],  

        'producto.created' => [
            'App\Events\ProductoEvent@created',
        ],
        'producto.updating' => [
            'App\Events\ProductoEvent@updating',
        ],        
        'producto.updated' => [
            'App\Events\ProductoEvent@updated',
        ],
        'producto.deleted' => [
            'App\Events\ProductoEvent@deleted',
        ],

        'profesion.created' => [
            'App\Events\ProfesionEvent@created',
        ],
        'profesion.updating' => [
            'App\Events\ProfesionEvent@updating',
        ],        
        'profesion.updated' => [
            'App\Events\ProfesionEvent@updated',
        ],
        'profesion.deleted' => [
            'App\Events\ProfesionEvent@deleted',
        ],  

        'registropassword.created' => [
            'App\Events\RegistroPasswordEvent@created',
        ],
        'registropassword.updating' => [
            'App\Events\RegistroPasswordEvent@updating',
        ],        
        'registropassword.updated' => [
            'App\Events\RegistroPasswordEvent@updated',
        ],
        'registropassword.deleted' => [
            'App\Events\RegistroPasswordEvent@deleted',
        ], 

        'registrosistema.created' => [
            'App\Events\RegistroSistemaEvent@created',
        ],
        'registrosistema.updating' => [
            'App\Events\RegistroSistemaEvent@updating',
        ],        
        'registrosistema.updated' => [
            'App\Events\RegistroSistemaEvent@updated',
        ],
        'registrosistema.deleted' => [
            'App\Events\RegistroSistemaEvent@deleted',
        ],

        'respuesta.created' => [
            'App\Events\RespuestaEvent@created',
        ],
        'respuesta.updating' => [
            'App\Events\RespuestaEvent@updating',
        ],        
        'respuesta.updated' => [
            'App\Events\RespuestaEvent@updated',
        ],
        'respuesta.deleted' => [
            'App\Events\RespuestaEvent@deleted',
        ],   

        'resultadocuestionario.created' => [
            'App\Events\ResultadoCuestionarioEvent@created',
        ],
        'resultadocuestionario.updating' => [
            'App\Events\ResultadoCuestionarioEvent@updating',
        ],        
        'resultadocuestionario.updated' => [
            'App\Events\ResultadoCuestionarioEvent@updated',
        ],
        'resultadocuestionario.deleted' => [
            'App\Events\ResultadoCuestionarioEvent@deleted',
        ],

        'rol.created' => [
            'App\Events\RolEvent@created',
        ],
        'rol.updating' => [
            'App\Events\RolEvent@updating',
        ],        
        'rol.updated' => [
            'App\Events\RolEvent@updated',
        ],
        'rol.deleted' => [
            'App\Events\RolEvent@deleted',
        ],       

        'seccion.created' => [
            'App\Events\SeccionEvent@created',
        ],
        'seccion.updating' => [
            'App\Events\SeccionEvent@updating',
        ],        
        'seccion.updated' => [
            'App\Events\SeccionEvent@updated',
        ],
        'seccion.deleted' => [
            'App\Events\SeccionEvent@deleted',
        ], 

        'sistema.created' => [
            'App\Events\SistemaEvent@created',
        ],
        'sistema.updating' => [
            'App\Events\SistemaEvent@updating',
        ],        
        'sistema.updated' => [
            'App\Events\SistemaEvent@updated',
        ],
        'sistema.deleted' => [
            'App\Events\SistemaEvent@deleted',
        ], 

        'sistemarol.created' => [
            'App\Events\SistemaRolEvent@created',
        ],
        'sistemarol.updating' => [
            'App\Events\SistemaRolEvent@updating',
        ],        
        'sistemarol.updated' => [
            'App\Events\SistemaRolEvent@updated',
        ],
        'sistemarol.deleted' => [
            'App\Events\SistemaRolEvent@deleted',
        ],                                                                                                                  

        'sistemarolusuario.created' => [
            'App\Events\SistemaRolUsuarioEvent@created',
        ],
        'sistemarolusuario.updating' => [
            'App\Events\SistemaRolUsuarioEvent@updating',
        ],        
        'sistemarolusuario.updated' => [
            'App\Events\SistemaRolUsuarioEvent@updated',
        ],
        'sistemarolusuario.deleted' => [
            'App\Events\SistemaRolUsuarioEvent@deleted',
        ], 

        'solvencia.created' => [
            'App\Events\SolvenciaEvent@created',
        ],
        'solvencia.updating' => [
            'App\Events\SolvenciaEvent@updating',
        ],        
        'solvencia.updated' => [
            'App\Events\SolvenciaEvent@updated',
        ],
        'solvencia.deleted' => [
            'App\Events\SolvenciaEvent@deleted',
        ], 

        'telefono.created' => [
            'App\Events\TelefonoEvent@created',
        ],
        'telefono.updating' => [
            'App\Events\TelefonoEvent@updating',
        ],        
        'telefono.updated' => [
            'App\Events\TelefonoEvent@updated',
        ],
        'telefono.deleted' => [
            'App\Events\TelefonoEvent@deleted',
        ], 

        'tipocuestionario.created' => [
            'App\Events\TipoCuestionarioEvent@created',
        ],
        'tipocuestionario.updating' => [
            'App\Events\TipoCuestionarioEvent@updating',
        ],        
        'tipocuestionario.updated' => [
            'App\Events\TipoCuestionarioEvent@updated',
        ],
        'tipocuestionario.deleted' => [
            'App\Events\TipoCuestionarioEvent@deleted',
        ], 

        'tipoemail.created' => [
            'App\Events\TipoEmailEvent@created',
        ],
        'tipoemail.updating' => [
            'App\Events\TipoEmailEvent@updating',
        ],        
        'tipoemail.updated' => [
            'App\Events\TipoEmailEvent@updated',
        ],
        'tipoemail.deleted' => [
            'App\Events\TipoEmailEvent@deleted',
        ], 

        'tipopago.created' => [
            'App\Events\TipoPagoEvent@created',
        ],
        'tipopago.updating' => [
            'App\Events\TipoPagoEvent@updating',
        ],        
        'tipopago.updated' => [
            'App\Events\TipoPagoEvent@updated',
        ],
        'tipopago.deleted' => [
            'App\Events\TipoPagoEvent@deleted',
        ],                                                   

        'tipoperiodo.created' => [
            'App\Events\TipoPeriodoEvent@created',
        ],
        'tipoperiodo.updating' => [
            'App\Events\TipoPeriodoEvent@updating',
        ],        
        'tipoperiodo.updated' => [
            'App\Events\TipoPeriodoEvent@updated',
        ],
        'tipoperiodo.deleted' => [
            'App\Events\TipoPeriodoEvent@deleted',
        ], 

        'tipopersona.created' => [
            'App\Events\TipoPersonaEvent@created',
        ],
        'tipopersona.updating' => [
            'App\Events\TipoPersonaEvent@updating',
        ],        
        'tipopersona.updated' => [
            'App\Events\TipoPersonaEvent@updated',
        ],
        'tipopersona.deleted' => [
            'App\Events\TipoPersonaEvent@deleted',
        ],  

        'user.created' => [
            'App\Events\UserEvent@created',
        ],
        'user.updating' => [
            'App\Events\UserEvent@updating',
        ],        
        'user.updated' => [
            'App\Events\UserEvent@updated',
        ],
        'user.deleted' => [
            'App\Events\UserEvent@deleted',
        ], 

        'vistacontenido.created' => [
            'App\Events\VistaContenidoEvent@created',
        ],
        'vistacontenido.updating' => [
            'App\Events\VistaContenidoEvent@updating',
        ],        
        'vistacontenido.updated' => [
            'App\Events\VistaContenidoEvent@updated',
        ],
        'vistacontenido.deleted' => [
            'App\Events\VistaContenidoEvent@deleted',
        ],  

        'comentarcontenido.created' => [
            'App\Events\ComentarContenidoEvent@created',
        ],
        'comentarcontenido.updating' => [
            'App\Events\ComentarContenidoEvent@updating',
        ],        
        'comentarcontenido.updated' => [
            'App\Events\ComentarContenidoEvent@updated',
        ],
        'comentarcontenido.deleted' => [
            'App\Events\ComentarContenidoEvent@deleted',
        ],                               
    ];


    public function boot()
    {
        parent::boot();

        //
    }
}
