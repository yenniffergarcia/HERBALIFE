<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'IMEDCHI',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Sistema</b>IMEDCHI',

    'logo_mini' => '',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => '/',

    'logout_url' => 'admin/login',

    'logout_method' => null,

    'login_url' => 'login',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */
    'menuAdmin' => [
        'Administrador',
        [
            'text' => '',
            'url'  => '',
            'can'  => '',
        ],
        [
            'text'    => 'Dashboard',
            'icon'    => 'tachometer',
            'url'  => '#',
        ],        
        [
            'text'    => 'Mantenimiento',
            'icon'    => 'wrench',
            'submenu' => [
                [
                'text' => 'Profesion',
                'url'  => '/mantenimiento/profesion',
                'icon_color' => 'red',
                ],
                [
                'text' => 'Tipo Persona',
                'url'  => '/mantenimiento/tipopersona',
                'icon_color' => 'red',
                ], 
                [
                'text' => 'Genero',
                'url'  => '/mantenimiento/genero',
                'icon_color' => 'red',
                ],   
                [
                'text' => 'Tipo Email',
                'url'  => '/mantenimiento/tipoemail',
                'icon_color' => 'red',
                ],   
                [
                'text' => 'Compania',
                'url'  => '/mantenimiento/compania',
                'icon_color' => 'red',
                ],  
                [
                'text' => 'Persona',
                'url'  => '/sistema/imedchi/persona',
                'icon_color' => 'red',
                ],  
                [
                'text' => 'Usuario',
                'url'  => '/sistema/imedchi/usuario',
                'icon_color' => 'red',
                ],                                                                                                
            ],
        ],
    ],
    'menuBlackboard' => [
        'Blckboard',
        [
            'text' => '',
            'url'  => '',
            'can'  => '',
        ],
        [
            'text'    => 'Dashboard',
            'icon'    => 'tachometer',
            'url'  => '/dashboard/blackboard',
        ],        
        [
            'text'    => 'Administración',
            'icon'    => 'folder',
            'submenu' => [
                [
                'text'    => 'Contenido Educativo',
                'url'     => '#',
                'icon_color' => 'red',
                'submenu' => [
                    [
                        'text' => 'Cargar Contenido',
                        'url'  => '/plataforma/blackboard/cargar/contenido_educativo/catedratico',
                        'icon_color' => 'red',
                    ],
                    [
                        'text' => 'Contenido Historico',
                        'url'  => '/plataforma/blackboard/contenido_educativo/catedratico/historico', 'CatedraticoContenidoEducativoController@index_historico',
                        'icon_color' => 'red',
                    ],                    
                ],
                ],
                [
                'text'    => 'Contenido Educativo',
                'url'     => '#',
                'icon_color' => 'yellow',
                'submenu' => [
                    [
                        'text' => 'Cargar Contenido',
                        'url'  => '/plataforma/blackboard/cargar/contenido_educativo/alumno',
                        'icon_color' => 'yellow',
                    ],
                    [
                        'text' => 'Contenido Historico',
                        'url'  => '/plataforma/blackboard/contenido_educativo/alumno/historico',
                        'icon_color' => 'yellow',
                    ],                      
                ],
                ],                
            ],
        ],
        [
            'text'    => 'Evaluación',
            'icon'    => 'file',
            'submenu' => [
                [
                'text'    => 'Crear Cuestionario',
                'url'     => '#',
                'icon_color' => 'red',
                'submenu' => [
                    [
                        'text' => 'Cuestionario',
                        'url'  => '/plataforma/blackboard/cuestionario',
                        'icon_color' => 'red',
                    ],
                    [
                        'text'    => 'Cuestionarios Finalizados',
                        'url'     => '/plataforma/blackboard/cuestionario/historicos/catedraticohistorico',
                        'icon_color' => 'red',
                    ],
                ],
                ],

                [
                'text'    => 'Bandeja de Cuestionario',
                'url'     => '#',
                'icon_color' => 'yellow',
                'submenu' => [
                    [
                        'text' => 'Responder Cuestionario',
                        'url'  => '/plataforma/blackboard/bandeja/responder/cuestionario',
                        'icon_color' => 'yellow',
                    ],
                    [
                        'text'    => 'Cuestionarios Resueltos',
                        'url'     => '/plataforma/blackboard/cuestionario/historicos/alumnohistorico',
                        'icon_color' => 'yellow',
                    ],
                ],
                ],
            ],                       
        ],
    ],

    'menuGestionAcademica' => [
        'Gestion Académica',
        [
            'text' => '',
            'url'  => '',
            'can'  => '',
        ],
        [
            'text'    => 'Dashboard',
            'icon'    => 'tachometer',
            'url'  => '#',
        ],        
        [
            'text'    => 'Administración Estudiantil',
            'icon'    => 'archive',
            'submenu' => [
                [
                'text' => 'Ingreso de Alumnos',
                'url'  => '/academico/estudiante/estudiante',
                'icon_color' => 'red',
                ],
                [
                'text'    => 'Ingreso de Encargados',
                'url'     => '/academico/encargado/encargado',
                'icon_color' => 'red',
                ],
                [
                'text'    => 'Ingreso de Docentes',
                'url'     => '/academico/docente/docente',
                'icon_color' => 'yellow',
                ],
                [
                'text'    => 'Cursos Docentes',
                'url'     => '/academico/catedraticocurso/catedraticocurso',
                'icon_color' => 'yellow',
                ],
            ],
        ],
        [
            'text'    => 'Administración Académica',
            'icon'    => 'suitcase',
            'submenu' => [
                [
                'text' => 'Inscripción de Alumnos',
                'url'  => '/academico/inscripcion/inscripcion',
                'icon_color' => 'red',
                ],
                  [
                'text' => 'Planificación de Actividades',
                'url'  => '#',
                'icon_color' => 'yellow',
                'submenu' => [
                    [
                        'text' => 'Calendarización',
                        'url'  => '/academico/agenda/agenda',
                        'icon_color' => 'yellow',
                    ],
                      [
                        'text' => 'Tipo de actividad ',
                        'url'  => '/academico/tipoactividad/tipoactividad',
                        'icon_color' => 'yellow',
                    ],             
                ],                
                ],
                [
                'text' => 'Administración de Notas',
                'url'  => '#',
                'icon_color' => 'aqua',
                'submenu' => [
                    [
                        'text' => 'Control de Notas',
                        'url'  => '/academico/nota/nota',
                        'icon_color' => 'aqua',
                    ],
                      [
                        'text' => 'Cantidad de Alumnos ',
                        'url'  => '/mantenimiento/cantidadalumno',
                        'icon_color' => 'aqua',
                    ],
                    [
                        'text' => 'Período Académico',
                        'url'  => '/mantenimiento/periodoacademico',
                        'icon_color' => 'aqua',
                    ],
                    [
                        'text' => 'Carreras y cursos',
                        'url'  => '/mantenimiento/carreracurso',
                        'icon_color' => 'aqua',
                    ],
                    [
                        'text' => 'Carreras y grados',
                        'url'  => '/mantenimiento/carreragrado',
                        'icon_color' => 'aqua',
                    ],
                    [
                        'text'    => 'Carreras',
                        'url'     => '/mantenimiento/carrera',
                        'icon_color' => 'aqua',
                    ],
                    [
                        'text' => 'Grado',
                        'url'  => '/mantenimiento/grado',
                        'icon_color' => 'aqua',
                    ],
                    [
                    'text' => 'Cursos',
                    'url'  => '/mantenimiento/curso',
                    'icon_color' => 'aqua',
                    ],                     
                ],                
                ],                           
            ],
        ],        
    ],    

    'menuSistemaAdministrativo' => [
        'Administrativo',
        [
            'text' => '',
            'url'  => '',
            'can'  => '',
        ], 
        [
            'text'    => 'Dashboard',
            'icon'    => 'tachometer',
            'url'  => '#',
        ],                 
        [
            'text'    => 'Solvencia Alumno',
            'icon'    => 'book',
            'submenu' => [
                [
                'text' => 'Consulta de Estado',
                'url'  => '#',
                'icon_color' => 'red',
                ],
            ],  
        ],        
        [             
            'text'    => 'Pagos',
            'icon'    => 'cc',
            'submenu' => [
            [    
                'text' => 'Planilla',
                'url'  => '#',
                'icon_color' => 'red',
                'submenu' => [
                    [
                        'text' => 'Salario',
                        'url'  => 'gestionadministrativa/controlpago/salario',
                        'icon_color' => 'red',
                    ],
                                                      
                ],
            ],
            [
                'text'    => 'Académico',
                'url'     => '#',
                'icon_color' => 'yellow',
                'submenu' => [
                    [
                        'text' => 'Mensualidad',
                        'url'  => 'gestionadministrativa/controlpago/pago',
                        'icon_color' => 'yellow',
                    ],
                    [
                        'text'    => 'Tipo Pago',
                        'url'     => 'gestionadministrativa/controlpago/tipopago',
                        'icon_color' => 'yellow',
                    ],                    
                ],                 
            ],
            ], 
        ],        
        [              
            'text'    => 'Caja Chica',
            'icon'    => 'fax',
            'submenu' => [
                [
                'text' => 'Saldo',
                'url'  => '#',
                'icon_color' => 'red',
                ],
                [
                'text'    => 'Movimiento',
                'url'     => '#',
                'icon_color' => 'yellow',
                ],
                [
                'text'    => 'Ajuste',
                'url'     => '#',
                'icon_color' => 'aqua',
                ],                
            ], 
        ],
        [
            'text'    => 'Reportería',
            'icon'    => 'folder-open',
            'submenu' => [
                [
                'text' => 'Ver Stock',
                'url'  => '#',
                'icon_color' => 'red',
                ],
                [
                'text'    => 'Solvencias',
                'url'     => '#',
                'icon_color' => 'yellow',
                ],
                [
                'text'    => 'Pagos',
                'url'     => '#',
                'icon_color' => 'aqua',
                ],                
            ],                                                       
        ], 

        [
            'text'    => 'Inventario',
            'icon'    => 'suitcase',
            'submenu' => [
                 [
                'text' => 'Categoría',
                'url'  => '/gestionadministrativa/inventario/categoria',
                'icon_color' => 'red',
                ],
                [
                'text' => 'Producto',
                'url'  => '/gestionadministrativa/inventario/producto',
                'icon_color' => 'red',
                ],
                [
                'text'    => 'Alta Producto',
                'url'     => '/gestionadministrativa/inventario/altaproducto',
                'icon_color' => 'yellow',
                ],     
                [
                'text'    => 'Baja Producto',
                'url'     => '/gestionadministrativa/inventario/bajaproducto',
                'icon_color' => 'yellow',
                ], 
                [
                'text'    => 'Stock',
                'url'     => '/gestionadministrativa/inventario/stock',
                'icon_color' => 'yellow',
                ],      
            ],                                                       
        ],
    ],    

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
