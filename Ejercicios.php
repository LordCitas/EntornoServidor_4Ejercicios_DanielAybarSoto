<?php
$ejercicio = 1;

try {
    switch ($ejercicio) {
        case 1:
            $operacion = "modulo";
            $num1 = 7;
            $num2 = 5;
            function calcular($num1, $num2, $operacion)
            {
                return match ($operacion) {
                    'suma' => $num1 + $num2,
                    'resta' => $num1 - $num2,
                    'multiplicacion' => $num1 * $num2,
                    'division' => $num2 != 0 ? $num1 / $num2 : throw new InvalidArgumentException("Error: No se puede dividir por 0"),
                    'potencia' => match (true){
                        $num1 == 0 && $num2 == 0 => throw new InvalidArgumentException("Error: 0 no se puede elevar a 0"),
                        $num1 < 0 && $num2 < 1 && $num2 > -1 && $num2 != 0 => throw new InvalidArgumentException("Error: No se puede elevar un número negativo a una potencia dentro del intervalo (-1,0)u(0,1)"),
                        default => pow($num1, $num2)
                    },
                    'raizCuadrada' => $num1 > 0 ? pow($num1, 1 / 2) : throw new InvalidArgumentException("Error: No se puede calcular la raíz cuadrada de un número negativo"),
                    'modulo' => $num2 != 0 ? $num1 % $num2 : throw new InvalidArgumentException("Error: No se puede calcular el módulo con divisor 0"),
                    default => "Operación no válida"
                };
            }

            $resultado = calcular($num1, $num2, $operacion);
            echo "El resultado de la operación es: " . $resultado;

            break;

        case 2:
            break;

        case 3:
            break;

        case 4:
            break;
    }
}catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}