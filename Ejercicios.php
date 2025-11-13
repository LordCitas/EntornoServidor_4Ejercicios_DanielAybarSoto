<?php
$ejercicio = 3;

try {
    switch ($ejercicio) {
        case 1:
            $operacion = "modulo";
            $num1 = 7;
            $num2 = 5;
            function calcular($num1, $num2, $operacion){
                return match ($operacion) {
                    'suma' => $num1 + $num2,
                    'resta' => $num1 - $num2,
                    'multiplicacion' => $num1 * $num2,

                    //Cambio la expresión del error para que sea una excepción
                    'division' => $num2 != 0 ? $num1 / $num2 : throw new InvalidArgumentException("Error: No se puede dividir por 0"),

                    //Uso de match anidado para manejar múltiples condiciones de error en la potencia
                    'potencia' => match (true){
                        $num1 == 0 && $num2 == 0 => throw new InvalidArgumentException("Error: 0 no se puede elevar a 0"),
                        $num1 < 0 && $num2 < 1 && $num2 > -1 && $num2 != 0 => throw new InvalidArgumentException("Error: No se puede elevar un número negativo a una potencia dentro del intervalo (-1,0)u(0,1)"),
                        default => pow($num1, $num2)
                    },

                    //La raíz cuadrada solo da error si el número es negativo
                    'raizCuadrada' => $num1 > 0 ? pow($num1, 1 / 2) : throw new InvalidArgumentException("Error: No se puede calcular la raíz cuadrada de un número negativo"),

                    //El módulo solo da error si el divisor es 0
                    'modulo' => $num2 != 0 ? $num1 % $num2 : throw new InvalidArgumentException("Error: No se puede calcular el módulo con divisor 0"),
                    default => "Operación no válida"
                };
            }

            $resultado = calcular($num1, $num2, $operacion);
            echo "El resultado de la operación es: " . $resultado;

            break;

        case 2:
            //Una clase para validar formularios
            class ValidadorFormulario {
                public static function validarEmail($email): bool {
                    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
                }

                public static function validarNombre($nombre): bool {
                    return strlen($nombre) >= 2 && preg_match('/^[a-zA-Z\s]+$/', $nombre);
                }

                public static function validarTelefono($telefono): bool {
                    return preg_match('/^[0-9]{9}$/', $telefono);
                }

                public static function validarClave($clave): bool {
                    // Al menos 8 caracteres, una mayúscula, una minúscula y un número
                    return strlen($clave) >= 8 && preg_match('/[A-Z]/', $clave) && preg_match('/[a-z]/', $clave) && preg_match('/[0-9]/', $clave);
                }

                //Encapsulamos todas las llamadas a los métodos de validaciones en uno solo
                public static function validadorFormulario($email, $nombre, $telefono, $clave): bool {
                    return match (false){
                        self::validarEmail($email) => throw new InvalidArgumentException("Error: El email no es válido"),
                        self::validarNombre($nombre) => throw new InvalidArgumentException("Error: El nombre no es válido"),
                        self::validarTelefono($telefono) => throw new InvalidArgumentException("Error: El teléfono no es válido"),
                        self::validarClave($clave) => throw new InvalidArgumentException("Error: La clave no es válida"),
                        default => true
                    };
                }
            }

            //Datos de prueba
            $email = "email@gmail.com";
            $nombre = "Juan Perez";
            $telefono = "612345667";
            $clave = "Password1";

            //Validamos el formulario
            if (ValidadorFormulario::validadorFormulario($email, $nombre, $telefono, $clave)) {
                echo "Todos los campos son válidos." . PHP_EOL;
            }

            //Mensaje de prueba para comprobar que se lanzan las excepciones
            //echo "hola";

            break;

        case 3:
            $nl = (php_sapi_name() === 'cli') ? PHP_EOL : "<br>\n";

            //Función para imprimir un array
            function imprimirArray($array): void{
                //una variable que imprime un salto de línea adecuado según el entorno
                $nl = (php_sapi_name() === 'cli') ? PHP_EOL : "<br>\n";
                $longitud = count($array) - 1;

                //Empezamos a imprimir el array
                echo "[";
                //Recorremos el array e imprimimos sus elementos
                for($i = 0; $i < $longitud; $i++){
                    print_r($array[$i]);
                    echo "," . $nl;
                }
                //Terminamos la impresión del array
                print_r($array[$longitud]);
                echo "]" . $nl;
            }

            // El array de productos
            $productos = [
                ["id" => 1, "nombre" => "Laptop", "precio" => 899.99, "stock" => 10],
                ["id" => 2, "nombre" => "Teléfono", "precio" => 499.50, "stock" => 15],
                ["id" => 3, "nombre" => "Tablet", "precio" => 349.99, "stock" => 5]
            ];
            // Imprimimos el array original
            echo "Array original:" . $nl;
            imprimirArray($productos);

            // Una función que filtra productos con precio > 400
            function filtrarPrecioMayorQue400($productos) {
                return array_filter($productos, fn($p) => $p["precio"] > 400);
            }

            // Probamos la función de filtrado y mostramos el resultado
            $caros = filtrarPrecioMayorQue400($productos);
            echo "Productos con precio mayor que 400:" . $nl;
            imprimirArray($caros);

            // Una función que ordena el array por precio (ascendente)
            function ordenarPorPrecioAsc($productos): void {
                usort($productos, fn($a, $b) => $a["precio"] <=> $b["precio"]);
            }

            // Probamos la función de ordenación y mostramos el resultado
            echo "Productos ordenados por precio (ascendente):" . $nl;
            ordenarPorPrecioAsc($productos);
            imprimirArray($productos);

            // Una función que calcula el valor total del inventario
            function calcularValorTotalInventario($productos): float {
                return array_reduce($productos, fn($total, $p) => $total + ($p["precio"] * $p["stock"]), 0);
            }

            // Probamos la función de cálculo del valor total del inventario y mostramos el resultado
            $valorTotal = calcularValorTotalInventario($productos);
            echo "Valor total del inventario: $" . $valorTotal;


            //Una función que busca por coincidencia parcial con el nombre del producto
            /*function buscarPorNombre($productos, $secuencia): bool {
                foreach ($productos as $producto) {
                    if(str_contains($producto["nombre"], $secuencia)){
                        return 1;
                    } else {
                        return 0;
                    }
                }
                return array_filter($productos, fn($p) => stripos($p["nombre"], $secuencia) !== false);
            }*/

            function buscarPorNombre($productos, $secuencia): array {
                return array_filter($productos, fn($p) => stripos($p["nombre"], $secuencia) !== false);
            }

            // Probamos la función de búsqueda por nombre y mostramos el resultado
            $secuencia = "o";
            $resultados = buscarPorNombre($productos, $secuencia);
            echo $nl . "Resultados de la búsqueda parcial en los nombres con la secuencia '$secuencia':" . $nl;
            imprimirArray($resultados);
            break;

        case 4:
            break;
    }
}catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}