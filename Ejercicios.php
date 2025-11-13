<?php
$ejercicio = 4;

try {
    switch ($ejercicio) {
        case 1:
            $operacion = "modulo";
            $num1 = 3;
            $num2 = 0.4;

            function sumar($num1, $num2){
                return $num1 + $num2;
            }

            function restar($num1, $num2){
                return $num1 - $num2;
            }

            function multiplicar($num1, $num2){
                return $num1 * $num2;
            }

            //A partir de aquí, las funciones pueden dar errores, así que lanzan excepciones
            function dividir($num1, $num2){
                if ($num2 == 0) {
                    throw new InvalidArgumentException("Error: No se puede dividir por 0");
                }
                return $num1 / $num2;
            }

            function potencia($num1, $num2){
                if($num1 == 0 && $num2 == 0){
                    throw new InvalidArgumentException("Error: 0 no se puede elevar a 0");
                } else if ($num1 < 0 && $num2 < 1 && $num2 > -1 && $num2 != 0){
                    throw new InvalidArgumentException("Error: No se puede elevar un número negativo a una potencia dentro del intervalo (-1,0)u(0,1)");
                }
                return pow($num1, $num2);
            }

            function raizCuadrada($num1){
                if($num1 < 0){
                    throw new InvalidArgumentException("Error: No se puede calcular la raíz cuadrada de un número negativo");
                }
                return pow($num1, 1/2);
            }

            function modulo($num1, $num2): float{
                if ((int)$num2 == 0) {
                    throw new InvalidArgumentException("Error: No se puede calcular el módulo con divisor 0");
                }
                return $num1 % $num2;
            }

            function calcular($num1, $num2, $operacion)
            {
                return match ($operacion) {
                    'suma' => sumar($num1, $num2),
                    'resta' => restar($num1, $num2),
                    'multiplicacion' => multiplicar($num1, $num2),
                    'division' => dividir($num1, $num2),
                    'potencia' => potencia($num1, $num2),
                    'raizCuadrada' => raizCuadrada($num1),
                    'modulo' => modulo($num1, $num2),
                    default => "Operación no válida"
                };
            }

            $resultado = calcular($num1, $num2, $operacion);
            echo "El resultado de la operación es: " . $resultado;

            break;

        case 2:
            //Una clase para validar formularios
            class ValidadorFormulario
            {
                public static function validarEmail($email): bool
                {
                    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
                }

                public static function validarNombre($nombre): bool
                {
                    return strlen($nombre) >= 2 && preg_match('/^[a-zA-Z\s]+$/', $nombre);
                }

                public static function validarTelefono($telefono): bool
                {
                    return preg_match('/^[0-9]{9}$/', $telefono);
                }

                public static function validarClave($clave): bool
                {
                    // Al menos 8 caracteres, una mayúscula, una minúscula y un número
                    return strlen($clave) >= 8 && preg_match('/[A-Z]/', $clave) && preg_match('/[a-z]/', $clave) && preg_match('/[0-9]/', $clave);
                }

                //Encapsulamos todas las llamadas a los métodos de validaciones en uno solo
                public static function validadorFormulario($email, $nombre, $telefono, $clave): bool
                {
                    return match (false) {
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
            function imprimirArray($array): void
            {
                //una variable que imprime un salto de línea adecuado según el entorno
                $nl = (php_sapi_name() === 'cli') ? PHP_EOL : "<br>\n";
                $longitud = count($array) - 1;

                //Empezamos a imprimir el array
                echo "[";
                //Recorremos el array e imprimimos sus elementos
                for ($i = 0; $i < $longitud; $i++) {
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
            function filtrarPrecioMayorQue400($productos)
            {
                return array_filter($productos, fn($p) => $p["precio"] > 400);
            }

            // Probamos la función de filtrado y mostramos el resultado
            $caros = filtrarPrecioMayorQue400($productos);
            echo "Productos con precio mayor que 400:" . $nl;
            imprimirArray($caros);

            // Una función que ordena el array por precio (ascendente)
            function ordenarPorPrecioAsc($productos): void
            {
                usort($productos, fn($a, $b) => $a["precio"] <=> $b["precio"]);
            }

            // Probamos la función de ordenación y mostramos el resultado
            echo "Productos ordenados por precio (ascendente):" . $nl;
            ordenarPorPrecioAsc($productos);
            imprimirArray($productos);

            // Una función que calcula el valor total del inventario
            function calcularValorTotalInventario($productos): float
            {
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

            function buscarPorNombre($productos, $secuencia): array
            {
                return array_filter($productos, fn($p) => stripos($p["nombre"], $secuencia) !== false);
            }

            // Probamos la función de búsqueda por nombre y mostramos el resultado
            $secuencia = "o";
            $resultados = buscarPorNombre($productos, $secuencia);
            echo $nl . "Resultados de la búsqueda parcial en los nombres con la secuencia '$secuencia':" . $nl;
            imprimirArray($resultados);
            break;

        case 4:
            function analizarTexto($texto): array{
                // Limpiar y dividir el texto en palabras
                $texto = strtolower($texto);
                $texto = preg_replace('/[^\w\s]/', '', $texto);
                $palabras = preg_split('/\s+/', $texto, -1, PREG_SPLIT_NO_EMPTY);

                // Contar palabras
                $totalPalabras = count($palabras);

                // Frecuencia de palabras
                $frecuencia = array_count_values($palabras);
                arsort($frecuencia);  // Ordenar por frecuencia

                // Longitud promedio
                $longitudTotal = array_reduce($palabras, fn($total, $p) => $total + strlen($p), 0
                );
                $longitudPromedio = ($totalPalabras > 0)? $longitudTotal / $totalPalabras : 0;

                //Devolvemos los resultados en un array asociativo
                return [
                    'total_palabras' => $totalPalabras,
                    'frecuencia' => $frecuencia,
                    'longitud_promedio' => $longitudPromedio
                ];
            }

            // Texto de prueba
            $texto = "Este es un texto de prueba. Este texto sirve para probar el análisis de texto. Texto de prueba, análisis de texto.";
            $resultado = analizarTexto($texto);
            print_r($resultado);
            break;
    }
}catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}