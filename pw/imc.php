<?php
    $peso = 70;
    $altura = 1.75;

    $imc = $peso / ($altura * $altura);

    echo "Seu IMC é: " . $imc;

    if ($peso >= 85) {
        echo " A pessoa está acima de 85 kg.";
    }
?>