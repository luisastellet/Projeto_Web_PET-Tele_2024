<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Playwrite+CU:wght@100..400&display=swap');
    </style>
    <title>Projeto Web</title>
</head>
<body>
    <!-- http://localhost/projeto_web_2024/index.php -->
    <h1>Dados dos possíveis novos bolsistas do PET-Tele</h1>

    <section>
        <label for="opcao">Selecione uma opção:</label>
        <form action="processamento.php" method="post">
            <select name="opcao_escolhida">
                <option value="selecione">Selecione</option>
                <option value="opcao1">Nome</option>
                <option value="opcao2">Nascimento</option>
                <option value="opcao3">Matrícula</option>
                <option value="opcao4">Ano de ingresso</option>
                <option value="opcao5">Período de ingresso</option>
                <option value="opcao6">Ano e período de ingresso</option>
                <option value="opcao7">Curso</option>
                <option value="opcao8">CR</option>
                <option value="opcao9">Estado do historico</option>
            </select>
            <input type="submit" value="Pesquisar">
        </form>
    </section>

    <br> 
    <br>
    <hr>
    <br>

    <table>
        <tr >
            <th>Nome</th>
            <th>Nascimento</th>
            <th>Matrícula</th>
            <th>Ano de ingresso</th>
            <th>Período de ingresso</th>
            <th>Curso</th>
            <th>CR</th>
        </tr>
        <?php
            $json_data = file_get_contents('alunos.json');
            $dados = json_decode($json_data, true); // true é um array associativo

            foreach($dados['alunos'] as $aluno) {
                echo "<tr>";
                echo "<td>" . $aluno['nome'] . "</td>";
                echo "<td>" . $aluno['nascimento'][0] . '/' . $aluno['nascimento'][1] . '/' . $aluno['nascimento'][2] . "</td>";
                echo "<td>" . $aluno['matricula_uff'][0] . '.' . $aluno['matricula_uff'][1] . '.' . $aluno['matricula_uff'][2] . '.' . $aluno['matricula_uff'][3] . "</td>";
                echo "<td>" . '20' . $aluno['matricula_uff'][1] . "</td>";
                echo "<td>" . $aluno['matricula_uff'][0] . '° período'. "</td>";
                echo "<td>";
                if($aluno['matricula_uff'][2] == '031') echo "Ciência da Computação";
                else if($aluno['matricula_uff'][2] == '041') echo "Engenharia de Telecomunicações ";
                echo "</td>";
                echo "<td>" . $aluno['cr'] . "</td>";
                echo "</tr>";
            }
        ?>
    </table>

    

</body>
</html>