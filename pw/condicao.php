<?php
    $nota1 = 8;
    $nota2 = 2;
    $media = ($nota1 + $nota2) / 2;

    if ($media >= 8) {
        echo "A média do aluno(a) é: " . $media . " e está aprovado(a)";
    } else if ($media == 6)||($media <= 7) {
        echo "A média do aluno(a) é: " . $media . "<br>e está de recuperação";
    } else {
        echo "A média do aluno(a) é: " . $media . " e está reprovado(a)";
    }
?>