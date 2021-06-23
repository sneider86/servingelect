<?php

namespace App\Controllers;


use App\Controllers\BaseController; /*la plantilla del controlador general de codeigniter */
use App\Models\UsuariosModel;
use App\Models\RolesModel; /* clase a la cual se esta apuntando con los modelos */
use App\Models\ModulosModel;
use App\Models\PermisosModel;


class Usuarios extends BaseController
{
    /*interactua el controlador con el modelo */
    protected $usuarios, $roles, $modulos, $permisos;
    protected $reglas, $reglasLogin, $reglasCambia, $reglasActualiza;

    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
        $this->roles = new RolesModel();
        $this->modulos = new ModulosModel();
        $this->permisos = new PermisosModel();

        $this->reglas = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario]',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.',
                    'is_unique' => 'Ya existe un Usuario con éste Nombre'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ],
            'rpassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.',
                    'matches' => 'Las Contraseñas no son Iguales'
                ]
            ],
            'nombres' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ]
        ];

        $this->reglasLogin = [
            'usuario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ]
        ];

        $this->reglasCambia = [
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ],
            'rpassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.',
                    'matches' => 'Las Contraseñas no son Iguales'
                ]
            ],
        ];

        $this->reglasActualiza = [
            'nombres' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El Campo {field} es Obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $session = session();
        if($session->id_rol!=1){
            $verUsuarios = $this->permisos->obtenerPermiso($session->id_rol, 'Ver Usuarios');
            $agregar = $this->permisos->obtenerPermiso($session->id_rol,'Agregar Usuario');
            $editar = $this->permisos->obtenerPermiso($session->id_rol,'Editar Usuario');
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Usuario');
            $eliminar = $this->permisos->obtenerPermiso($session->id_rol,'Eliminar Usuario');  
        }else{
            $verUsuarios = "enabled='true'";
            $agregar = "enabled='true'";
            $editar = "enabled='true'";
            $actualizar = "enabled='true'";
            $eliminar = "enabled='true'";           
        }                  
        if ($verUsuarios == "enabled='true'") {            
            //$usuarios = $this->usuarios->where('activo', $activo)->findAll();
            $usuarios = $this->usuarios->listarUsuarios($activo);
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $data = ['titulo' => 'MANEJO DE USUARIOS', 'datos' => $usuarios, 'roles' => $roles, 'modulos' => $modulos, 'agregar' => $agregar, 'editar' => $editar, 'actualizar' => $actualizar, 'eliminar' => $eliminar];

            echo view('header', $data);
            echo view('usuarios/usuarios', $data);
            echo view('footer');
        } else {
            return redirect()->to(base_url() . '/principal');
            $message = 'Usted no Tiene Autorización para Ver esta Opción';
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }

    public function eliminados($activo = 0)
    {
        $session = session();
        if ($session->id_rol!=1) {
            $activar = $this->permisos->obtenerPermiso($session->id_rol,'Activar Usuario');
        }else{$activar = "enabled='true'"; }        
        $usuarios = $this->usuarios->where('activo', $activo)->findAll();        
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'USUARIOS ELIMINADOS', 'datos' => $usuarios, 'roles' => $roles, 'modulos' => $modulos,'activar'=>$activar];
        /* mostramos la vista */
        echo view('header', $data);
        echo view('usuarios/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        $data = ['titulo' => 'CREAR USUARIOS', 'roles' => $roles, 'modulos' => $modulos];
        echo view('header', $data);
        echo view('usuarios/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {

            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $hash2 = password_hash($this->request->getPost('rpassword'), PASSWORD_DEFAULT);
            $this->usuarios->save([
                // 'usuario' => $this->request->getPost('usuario'), los valores de ña izquierda 'usuario' son los cmapos de la tabla y los de la derecha los correspondientes a los campos del formulario getPost('usuario')
                'usuario' => $this->request->getPost('usuario'),
                'password' => $hash,
                'nombres' => $this->request->getPost('nombres'),
                'id_rol' => $this->request->getPost('id_rol'),
                'email' => $this->request->getPost('email'),
                'usuario_crea' => 1 //$this->request->getPost('usuario_crea')
            ]);
            return redirect()->to(base_url() . '/usuarios');
        } else {
            $roles = $this->roles->where('activo', 1)->findAll();
            $modulos = $this->modulos->buscar_modulos(1);
            $data = ['titulo' => 'CREAR USUARIOS', 'roles' => $roles, 'modulos' => $modulos, 'validation' => $this->validator];
            echo view('header');
            echo view('usuarios/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {
        $session = session();
        if ($session->id_rol!=1) {
            $actualizar = $this->permisos->obtenerPermiso($session->id_rol, 'Actualizar Usuario');
        }else{$actualizar = "enabled='true'"; }        
        $usuario = $this->usuarios->where('id', $id)->first();
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        if ($valid !== null) {
            $data = ['titulo' => 'EDITAR USUARIO', 'datos' => $usuario, 'roles' => $roles, 'modulos' => $modulos, 'validation' => $valid, 'actualizar' => $actualizar];
        } else {
            $data = ['titulo' => 'EDITAR USUARIO', 'datos' => $usuario, 'roles' => $roles, 'modulos' => $modulos, 'actualizar' => $actualizar];
        }
        echo view('header', $data);
        echo view('usuarios/editar', $data);
        echo view('footer');
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == "post" ) {
            //$hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $this->usuarios->update($this->request->getPost('id_ed'), [
                //'usuario' => $this->request->getPost('usuario'),
                //'password' => $hash,
                'nombres' => $this->request->getPost('nombres_ed'),
                'id_rol' => $this->request->getPost('id_rol_ed'),
                'email' => $this->request->getPost('email_ed')
            ]);
            return redirect()->to(base_url() . '/usuarios');
        } else {
            //return $this->editar($this->request->getPost('id'), $this->validator);
            return redirect()->to(base_url() . '/usuarios');
        }
    }

    public function eliminar($id)
    {
        $this->usuarios->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/usuarios');
    }
    public function activar($id)
    {
        $this->usuarios->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/usuarios/eliminados');
    }

    public function login()
    {
        echo view('login');
    }

    public function valida()
    {
        if ($this->request->getMethod() == "post" && $this->validate($this->reglasLogin)) {
            $usuario = $this->request->getPost('usuario'); //dato del formulario login
            $password = $this->request->getPost('password'); //dato del formulario login

            $datosUsuario = $this->usuarios->where('usuario', $usuario)->first(); //consulta    

            if ($datosUsuario != null) {
                //if (password_verify($password, $datosUsuario['password'])) {  //verificamos el password que sed trae en la consulta con el que oingresa el usuario
                $datosRol = $this->roles->where('id', $datosUsuario['id_rol'])->first();
                $datosSesion = [ //creamos la variable dee sesion en modo arreglo
                    'id_usuario' => $datosUsuario['id'],
                    'nombres' => $datosUsuario['nombres'],
                    'email' => $datosUsuario['email'],
                    'usuario' => $datosUsuario['usuario'],
                    'id_rol' => $datosUsuario['id_rol'],
                    'nombre_rol' => $datosRol['nombre']
                ];
                $session = session(); //variabloe de sesion a la cual le establecemos la sesion ($session y puede ser cualquier nombre de variable)
                $session->set($datosSesion); //y a la nueva $session le asignamos el arreglo $datosSesion y ya nos crearia las variables de sesion para poder trabajar
                //return redirect()->to(base_url() . '/usuarios');   // debemos redireccionar a la vista principal o a la que decidamos
                return redirect()->to(base_url() . '/principal');
                //} else {
                //    $data['error'] = "Contraseña Equivocada. Intentalo Nuevamente";
                //    echo view('login', $data); //$data=informacion que se envia, o sea el mensaje de error
                //}
            } else {
                $data['error'] = "El Usurio: " . $usuario . " no Existe.";
                echo view('login', $data);
            }
        } else {
            $data = ['validation' => $this->validator];  //se manda con data el resultado de errores
            echo view('login', $data);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }

    public function cambia_password()
    {

        $session = session(); //para tomar el id del usuario de la sesion logueada 
        $usuario = $this->usuarios->where('id', $session->id_usuario)->first();
        $data = ['titulo' => 'CAMBIAR CONTRASEÑA', 'usuario' => $usuario];
        echo view('header');
        echo view('usuarios/cambia_password', $data);
        echo view('footer');
    }

    public function actualizar_password()
    {
        $roles = $this->roles->where('activo', 1)->findAll();
        $modulos = $this->modulos->buscar_modulos(1);
        if ($this->request->getMethod() == "post" && $this->validate($this->reglasCambia)) {
            $session = session();
            $id_usuario = $session->id_usuario;
            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $this->usuarios->update($id_usuario, ['password' => $hash]);
            $usuario = $this->usuarios->where('id', $session->id_usuario)->first();


            $data = ['titulo' => 'CAMBIAR CONTRASEÑA', 'usuario' => $usuario, 'mensaje' => 'Cambio de Contraseña Exitoso', 'roles' => $roles, 'modulos' => $modulos];

            echo view('header', $data);
            echo view('usuarios/cambia_password', $data);
            echo view('footer');
        } else {
            $session = session(); //para tomar el id del usuario de la sesion logueada 
            $usuario = $this->usuarios->where('id', $session->id_usuario)->first();
            $data = ['titulo' => 'CAMBIAR CONTRASEÑA', 'roles' => $roles, 'modulos' => $modulos, 'usuario' => $usuario, 'validation' => $this->validator];
            echo view('header');
            echo view('usuarios/cambia_password', $data);
            echo view('footer');
        }
    }

    public function buscarUsuario($id)
    {
        $returnData = array();
        $usuarios = $this->usuarios->presentarUsuario($id);
        if (!empty($usuarios)) {
            array_push($returnData, $usuarios);
        }
        echo json_encode($returnData);
    }
}
