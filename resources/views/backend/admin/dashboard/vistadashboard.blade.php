@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop


    <div class="container" style="">
        <h1>Ejemplo de estructuras de control en PHP</h1>

        <h2>Condicionales</h2>
        <p>El número generado es: <strong>{{ $numero }}</strong></p>
        <p>Resultado de evaluación: <strong>{{ $resultado }}</strong></p>

        <h2>Bucles</h2>
        <p>Valores: {{ implode(', ', $valores) }}</p>
        <p>Suma sin contar el 3: {{ $suma }}</p>
    
    </div>

        <button type="button" class="btn btn-danger" onclick="mostrarMensaje();">Botón con estilo</button>
        
        <button type="button" class="btn btn-primary" onclick="">Botón</button>

    @section('archivos-js')
    @stop

    
    <!-- Ejemplos de javascript -->
    <script type="text/javascript">

       function mostrarMensaje() {

        alert("Hola, Hiciste clic en el botón.");

        }

        var c;
        function sumar(a, b) {
            c = a + b;
            alert(c);
        }

    </script>