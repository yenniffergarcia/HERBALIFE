<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\PuntoMes;
use App\PersonaNivel;
use App\EquipoExpansion;
use App\PedidoAceptado;
use App\Bonificacion;
use App\Persona;
use Auth;

class PersonaNivelEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        //
    }

    public function created_verificarnivel(PuntoMes $data)
    {
        $suma_dos_meses = 0;
        $suma_doce_meses = 0;

        $dos_meses = PuntoMes::where('fkpersona', $data->fkpersona)
            ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), date('Y'))
            ->select('punto')->orderby('punto_mes.id','DESC')->take(2)->get();     
            
        foreach ($dos_meses as $valor) 
        {
            $suma_dos_meses = $suma_dos_meses + $valor->punto;
        }

        $doce_meses = PuntoMes::where('fkpersona', $data->fkpersona)
            ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), date('Y'))
            ->select('punto')->orderby('punto_mes.id','DESC')->take(12)->get();     
            
        foreach ($doce_meses as $valor) 
        {
            $suma_doce_meses = $suma_doce_meses + $valor->punto;
        }        

        if($data->punto > 499 && $data->punto < 2501)
        {
            $this->cambiar_estado_nive($data, 1, 2);
        }
        if(count($dos_meses)>0)
        {
            if($suma_dos_meses > 2499 && $suma_dos_meses < 4001)
            {
                $this->cambiar_estado_nive($data, 2, 3);            
            }               
        }
        if(count($doce_meses)>0)
        {
            if($suma_doce_meses > 3999)
            {
                $this->cambiar_estado_nive($data, 3, 4);             
            }                 
        }           
    }    

    public function update_verificarnivel(PuntoMes $data)
    {
        $suma_dos_meses = 0;
        $suma_doce_meses = 0;

        $dos_meses = PuntoMes::where('fkpersona', $data->fkpersona)
            ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), date('Y'))
            ->select('punto')->orderby('punto_mes.id','DESC')->take(2)->get();     
            
        foreach ($dos_meses as $valor) 
        {
            $suma_dos_meses = $suma_dos_meses + $valor->punto;
        }

        $doce_meses = PuntoMes::where('fkpersona', $data->fkpersona)
            ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), date('Y'))
            ->select('punto')->orderby('punto_mes.id','DESC')->take(12)->get();     
            
        foreach ($doce_meses as $valor) 
        {
            $suma_doce_meses = $suma_doce_meses + $valor->punto;
        }        

        if($data->punto > 499 && $data->punto < 2501)
        {
            $this->cambiar_estado_nive($data, 1, 2);
        }
        if(count($dos_meses)>0)
        {
            if($suma_dos_meses > 2499 && $suma_dos_meses < 4001)
            {
                $this->cambiar_estado_nive($data, 2, 3);            
            }               
        }
        if(count($doce_meses)>0)
        {
            if($suma_doce_meses > 3999)
            {
                $this->cambiar_estado_nive($data, 3, 4);             
            }                 
        }    
    }   

    public function cambiar_estado_nive($data, $numero_actual, $numero_nuevo)
    {
        $suma = 0;
        switch ($numero_nuevo) 
        {
            case 3:
                    $puntos = PuntoMes::where('fkpersona', $data->fkpersona)
                        ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), date('Y'))
                        ->select('punto')->orderby('punto_mes.id','DESC')->take(2)->get();     
                        
                    foreach ($puntos as $valor) 
                    {
                        $suma = $suma + $valor->punto;
                    }

                    if($suma > 2500 && $suma < 4001)
                    {
                        $cambiar_nivel = PersonaNivel::where('fkpersona', $data->fkpersona)
                            ->where('fknivel', $numero_actual)
                            ->select('id')->first();  

                        if(!is_null($cambiar_nivel))
                        {
                            $update = PersonaNivel::findOrFail($cambiar_nivel->id);
                            $update->estado = 0;
                            if($update->save())
                            {
                                $cambiar_nivel = PersonaNivel::where('fkpersona', $data->fkpersona)
                                                            ->where('fknivel', $numero_nuevo)
                                                            ->select('id')->first();                                
                                
                                if(!is_null($cambiar_nivel))
                                {
                                    $update = PersonaNivel::findOrFail($cambiar_nivel->id);
                                    $update->estado = 1; 
                                    $update->save();                                      
                                }
                                else
                                {
                                    $insert = new PersonaNivel;
                                    $insert->fkpersona = $data->fkpersona;
                                    $insert->fknivel = $numero_nuevo;
                                    $insert->save();
                                }
                            }
                        } 

                    } 
                break;

            case 4:
                    $puntos = PuntoMes::where('fkpersona', $data->fkpersona)
                        ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM punto_mes p WHERE p.id = ".'punto_mes.id'.")"), date('Y'))
                        ->select('punto')->orderby('punto_mes.id','DESC')->take(12)->get();          
                        
                    foreach ($puntos as $valor) 
                    {
                        $suma = $suma + $valor->punto;
                    }

                    if($suma > 2500 && $suma < 4001)
                    {
                        $cambiar_nivel = PersonaNivel::where('fkpersona', $data->fkpersona)
                            ->where('fknivel', $numero_actual)
                            ->select('id')->first();  

                        if(!is_null($cambiar_nivel))
                        {
                            $update = PersonaNivel::findOrFail($cambiar_nivel->id);
                            $update->estado = 0;
                            if($update->save())
                            {
                                $cambiar_nivel = PersonaNivel::where('fkpersona', $data->fkpersona)
                                                            ->where('fknivel', $numero_nuevo)
                                                            ->select('id')->first();                                
                                
                                if(!is_null($cambiar_nivel))
                                {
                                    $update = PersonaNivel::findOrFail($cambiar_nivel->id);
                                    $update->estado = 1; 
                                    $update->save();                                      
                                }
                                else
                                {
                                    $insert = new PersonaNivel;
                                    $insert->fkpersona = $data->fkpersona;
                                    $insert->fknivel = $numero_nuevo;
                                    $insert->save();
                                }
                            }
                        } 
                                    
                    } 
                break;                
            
            default:
                    $cambiar_nivel = PersonaNivel::where('fkpersona', $data->fkpersona)
                        ->where('fknivel', $numero_actual)
                        ->select('id')->first();  

                    if(!is_null($cambiar_nivel))
                    {
                        $update = PersonaNivel::findOrFail($cambiar_nivel->id);
                        $update->estado = 0;
                        if($update->save())
                        {
                                $cambiar_nivel = PersonaNivel::where('fkpersona', $data->fkpersona)
                                                            ->where('fknivel', $numero_nuevo)
                                                            ->select('id')->first();                                
                                
                                if(!is_null($cambiar_nivel))
                                {
                                    $update = PersonaNivel::findOrFail($cambiar_nivel->id);
                                    $update->estado = 1; 
                                    $update->save();                                   
                                }
                                else
                                {
                                    $insert = new PersonaNivel;
                                    $insert->fkpersona = $data->fkpersona;
                                    $insert->fknivel = $numero_nuevo;
                                    $insert->save();
                                }
                        }
                    } 
                break;
        }
    }

    public function created_bonificacionred(PuntoMes $data)
    {
        $sumatoria = 0;
        $sumar = 0;
        $persona = Persona::find($data->fkpersona);
        $acumulacion_red = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
            ->join('producto', 'stock.fkproducto', 'producto.id')
            ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
            ->where('pedido.fkpersona', $persona->id_padre)
            ->where('pedido.estado', 1)
            ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM pedido p WHERE p.id = ".'pedido_aceptado.fkpedido'.")"), date('Y'))
            ->select('punto', 'precio')->get();

        foreach ($acumulacion_red as $valor) 
        {
            $sumatoria = $valor->punto + $sumatoria;
            $sumar = $valor->precio + $sumar;
        }

        if($sumatoria > 49999 && $sumatoria < 80001)
        {
            $id = 1;
            $equipo = EquipoExpansion::find($id);
            $existe_bonificacion = Bonificacion::where('fkpersona', $persona->id_padre)
                ->where('fkequipo_expansion', $id)->where('fkmes', date('n'))->where('anio', date('Y'))->first();

            if(!is_null($existe_bonificacion))
            {
                $update = Bonificacion::findOrFail($existe_bonificacion->id);
                $update->monto = $sumar * $equipo->porcentaje;
                $update->save();
            }
            else
            {
                $insert = new Bonificacion;
                $insert->fkmes = date('n');
                $insert->fkpersona = $persona->id_padre;
                $insert->fkequipo_expansion = $id;
                $insert->monto = $sumar * $equipo->porcentaje;
                $insert->anio = date('Y');
                $insert->save();
            }
        }
        if($sumatoria > 79999 && $sumatoria < 200001)
        {
            $id = 2;
            $equipo = EquipoExpansion::find($id);
            $existe_bonificacion = Bonificacion::where('fkpersona', $persona->id_padre)
                ->where('fkequipo_expansion', $id)->where('fkmes', date('n'))->where('anio', date('Y'))->first();

            if(!is_null($existe_bonificacion))
            {
                $update = Bonificacion::findOrFail($existe_bonificacion->id);
                $update->monto = $sumar * $equipo->porcentaje;
                $update->save();
            }
            else
            {
                $insert = new Bonificacion;
                $insert->fkmes = date('n');
                $insert->fkpersona = $persona->id_padre;
                $insert->fkequipo_expansion = $id;
                $insert->monto = $sumar * $equipo->porcentaje;
                $insert->anio = date('Y');
                $insert->save();
            }          
        }   
        if($sumatoria > 199999)
        {
            $id = 3;
            $equipo = EquipoExpansion::find($id);
            $existe_bonificacion = Bonificacion::where('fkpersona', $persona->id_padre)
                ->where('fkequipo_expansion', $id)->where('fkmes', date('n'))->where('anio', date('Y'))->first();

            if(!is_null($existe_bonificacion))
            {
                $update = Bonificacion::findOrFail($existe_bonificacion->id);
                $update->monto = $sumar * $equipo->porcentaje;
                $update->save();
            }
            else
            {
                $insert = new Bonificacion;
                $insert->fkmes = date('n');
                $insert->fkpersona = $persona->id_padre;
                $insert->fkequipo_expansion = $id;
                $insert->monto = $sumar * $equipo->porcentaje;
                $insert->anio = date('Y');
                $insert->save();
            }           
        }             
    }    

    public function update_bonificacionred(PuntoMes $data)
    {
        $sumatoria = 0;
        $sumar = 0;
        $persona = Persona::find($data->fkpersona);
        $acumulacion_red = PedidoAceptado::join('stock', 'pedido_aceptado.fkstock', 'stock.id')
            ->join('producto', 'stock.fkproducto', 'producto.id')
            ->join('pedido', 'pedido_aceptado.fkpedido', 'pedido.id')
            ->where('pedido.fkpersona', $persona->id_padre)
            ->where('pedido.estado', 1)
            ->where(\DB::raw("(SELECT YEAR(p.fecha) FROM pedido p WHERE p.id = ".'pedido_aceptado.fkpedido'.")"), date('Y'))
            ->select('punto', 'precio')->get();

        foreach ($acumulacion_red as $valor) 
        {
            $sumatoria = $valor->punto + $sumatoria;
            $sumar = $valor->precio + $sumar;
        }

        if($sumatoria > 49999 && $sumatoria < 80001)
        {
            $id = 1;
            $equipo = EquipoExpansion::find($id);
            $existe_bonificacion = Bonificacion::where('fkpersona', $persona->id_padre)
                ->where('fkequipo_expansion', $id)->where('fkmes', date('n'))->where('anio', date('Y'))->first();

            if(!is_null($existe_bonificacion))
            {
                $update = Bonificacion::findOrFail($existe_bonificacion->id);
                $update->monto = $sumar * $equipo->porcentaje;
                $update->save();
            }
            else
            {
                $insert = new Bonificacion;
                $insert->fkmes = date('n');
                $insert->fkpersona = $persona->id_padre;
                $insert->fkequipo_expansion = $id;
                $insert->monto = $sumar * $equipo->porcentaje;
                $insert->anio = date('Y');
                $insert->save();
            }
        }
        if($sumatoria > 79999 && $sumatoria < 200001)
        {
            $id = 2;
            $equipo = EquipoExpansion::find($id);
            $existe_bonificacion = Bonificacion::where('fkpersona', $persona->id_padre)
                ->where('fkequipo_expansion', $id)->where('fkmes', date('n'))->where('anio', date('Y'))->first();

            if(!is_null($existe_bonificacion))
            {
                $update = Bonificacion::findOrFail($existe_bonificacion->id);
                $update->monto = $sumar * $equipo->porcentaje;
                $update->save();
            }
            else
            {
                $insert = new Bonificacion;
                $insert->fkmes = date('n');
                $insert->fkpersona = $persona->id_padre;
                $insert->fkequipo_expansion = $id;
                $insert->monto = $sumar * $equipo->porcentaje;
                $insert->anio = date('Y');
                $insert->save();
            }          
        }   
        if($sumatoria > 199999)
        {
            $id = 3;
            $equipo = EquipoExpansion::find($id);
            $existe_bonificacion = Bonificacion::where('fkpersona', $persona->id_padre)
                ->where('fkequipo_expansion', $id)->where('fkmes', date('n'))->where('anio', date('Y'))->first();

            if(!is_null($existe_bonificacion))
            {
                $update = Bonificacion::findOrFail($existe_bonificacion->id);
                $update->monto = $sumar * $equipo->porcentaje;
                $update->save();
            }
            else
            {
                $insert = new Bonificacion;
                $insert->fkmes = date('n');
                $insert->fkpersona = $persona->id_padre;
                $insert->fkequipo_expansion = $id;
                $insert->monto = $sumar * $equipo->porcentaje;
                $insert->anio = date('Y');
                $insert->save();
            }           
        }
    }   

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
