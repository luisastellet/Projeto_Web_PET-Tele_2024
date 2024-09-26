<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_aux.css">
    <title>Processamento</title>
</head>
<body>

    <?php
        $json_data = file_get_contents('alunos.json');
        $dados = json_decode($json_data, true); // true é um array associativo

        function accent_replace($string){
            $wAccent  = ['à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ü', 'Ú'];
            $woAccent = ['a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U'];
            return str_replace($wAccent, $woAccent, $string);
        }

        function array_sorted_by_name($array){
            $name_array   = array();
            $sorted_array = array();
            if (count($array) > 0) {
                // build a name_array keeping the org_array_keys
                foreach ($array as $k => $v) {
                $name_array[$k] = accent_replace($v['nome']);
                }
                unset($v);
                // asort() sorts the values, keeping the keys...
                asort($name_array);
                // copy registers from org_array, using the name_array ordering.
                foreach ($name_array as $k => $v) {
                $sorted_array[$k] = $array[$k];
                }
                unset($v);
            }
            return $sorted_array;
        }
    ?>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $opcao_escolhida = $_POST['opcao_escolhida'];

            if($opcao_escolhida == 'selecione'){
                echo 'Volte e selecione uma opção válida!';

            } else if($opcao_escolhida == 'opcao1') { // NOME

                $sorted_array = array_sorted_by_name($dados["alunos"]);

                foreach ($sorted_array as $aluno) {
                    echo 'Nome: ' . $aluno['nome'] . '<br><hr>';
                }

            } else if($opcao_escolhida == 'opcao2') { // NASCIMENTO
                
                $sorted_array = array_sorted_by_name($dados["alunos"]);
                usort($sorted_array, function($a, $b) {
                    if ($a['nascimento'][2] == $b['nascimento'][2]){

                        if ($a['nascimento'][1] == $b['nascimento'][1]){

                            if ($a['nascimento'][0] == $b['nascimento'][0]) return 0;
                            else return $a['nascimento'][0] <=> $b['nascimento'][0];

                        } else return $a['nascimento'][1] <=> $b['nascimento'][1];

                    } else return $a['nascimento'][2] <=> $b['nascimento'][2];
                });

                foreach ($sorted_array as $aluno) {
                    echo 'Nome: ' . $aluno['nome'] . '<br>' .
                    'Nacimento: ' . $aluno['nascimento'][0] . '/' . $aluno['nascimento'][1] . '/' . $aluno['nascimento'][2] . '<br><hr>';
                }

            } else if($opcao_escolhida == 'opcao3') { // MATRÍCULA

                $sorted_array = array_sorted_by_name($dados["alunos"]);
                usort($sorted_array, function($a, $b) {
                    if ($a['matricula_uff'][1] == $b['matricula_uff'][1]){

                        if ($a['matricula_uff'][0] == $b['matricula_uff'][0]){

                            if ($a['matricula_uff'][2] == $b['matricula_uff'][2]){

                                if ($a['matricula_uff'][3] == $b['matricula_uff'][3]) return 0;
                                else return $a['matricula_uff'][3] <=> $b['matricula_uff'][3];

                            } else return $a['matricula_uff'][2] <=> $b['matricula_uff'][2];

                        } else return $a['matricula_uff'][0] <=> $b['matricula_uff'][0];

                    } else return $a['matricula_uff'][1] <=> $b['matricula_uff'][1];
                });

                foreach ($sorted_array as $aluno) {
                    echo 'Nome: ' . $aluno['nome'] . '<br>' .
                    'Matrícula: ' . $aluno['matricula_uff'][0] . '.' . $aluno['matricula_uff'][1] . '.' . $aluno['matricula_uff'][2] . '.' . $aluno['matricula_uff'][3] . '<br><hr>';
                }
                
            } else if($opcao_escolhida == 'opcao4') { // ANO DE INGRESSO
                
                $sorted_array = array_sorted_by_name($dados["alunos"]);
                usort($sorted_array, function($a, $b) {
                    return $a['matricula_uff'][1] <=> $b['matricula_uff'][1];
                });

                foreach ($sorted_array as $aluno) {
                    echo 'Nome: ' . $aluno['nome'] . '<br>' .
                    'Ano de ingresso: 20' . $aluno['matricula_uff'][1] . '<br><hr>';
                }
                
            } else if($opcao_escolhida == 'opcao5') { // PERÍODO DE INGRESSO

                $sorted_array = array_sorted_by_name($dados["alunos"]);
                usort($sorted_array, function($a, $b) {
                    return $a['matricula_uff'][0] <=> $b['matricula_uff'][0];
                });

                foreach ($sorted_array as $aluno) {
                    echo 'Nome: ' . $aluno['nome'] . '<br>' .
                    'Período de ingresso: ' . $aluno['matricula_uff'][0] . '° período <br><hr>';
                }

            } else if($opcao_escolhida == 'opcao6') { // ANO E PERÍODO DE INGRESSO

                $sorted_array = $dados["alunos"];
                usort($sorted_array, function($a, $b) {
                    if ($a['matricula_uff'][1] == $b['matricula_uff'][1]){

                        if ($a['matricula_uff'][0] == $b['nascimento'][0]) return 0;
                        else return $a['matricula_uff'][0] <=> $b['matricula_uff'][0];

                    } else return $a['matricula_uff'][1] <=> $b['matricula_uff'][1];
                });

                foreach ($sorted_array as $aluno) {
                    echo 'Nome: ' . $aluno['nome'] . '<br>' .
                    'Ano e período de ingresso: ' . $aluno['matricula_uff'][0] . '° período de 20' . $aluno['matricula_uff'][1] . '<br><hr>';
                }
                
            } else if($opcao_escolhida == 'opcao7') { // CURSO

                $sorted_array = $dados["alunos"];
                usort($sorted_array, function($a, $b) {
                    return $a['matricula_uff'][2] <=> $b['matricula_uff'][2];
                });

                foreach ($sorted_array as $aluno) {
                    echo 'Nome: ' . $aluno['nome'] . '<br>';
                    if($aluno['matricula_uff'][2] == '031') echo 'Curso: Ciência da Computação';
                    else if($aluno['matricula_uff'][2] == '041') echo 'Curso: Engenharia de Telecomunicações';
                    echo '<br><hr>';
                }
                
            } else if($opcao_escolhida == 'opcao8') { // CR

                $sorted_array = array_sorted_by_name($dados["alunos"]);
                usort($sorted_array, function($a, $b) {
                    return $b['cr'] <=> $a['cr'];
                });

                foreach ($sorted_array as $aluno) {
                    echo 'Nome: ' . $aluno['nome'] . '<br>' .
                    'Coeficiente de rendimento: ' . $aluno['cr'] . '<br><hr>';
                }
                
            } else if($opcao_escolhida == 'opcao9') { // ESTADO DO HISTÓRICO

                $sorted_array = array_sorted_by_name($dados["alunos"]);
                usort($sorted_array, function($a, $b) {

                    //achando os primeiros 2 números da string
                    preg_match_all('/\d+/', $a['historico'], $resultadosA);
                    $totalA = $resultadosA[0][0];
                    $faltaA= $resultadosA[0][1];

                    preg_match_all('/\d+/', $b['historico'], $resultadosB);
                    $totalB = $resultadosB[0][0];
                    $faltaB = $resultadosB[0][1];

                    if($totalA == $totalB){

                        if($faltaA == $faltaB) return 0;
                        else return $faltaA <=> $faltaB;
        
                    } else return $totalA <=> $totalB;
                });

                foreach ($sorted_array as $aluno) {
                    echo 'Nome: ' . $aluno['nome'] . '<br>' .
                    'Histórico: ' . $aluno['historico'] . '<br><hr>';
                }
            }
        }

            // echo $aluno['nome'] . ' | ' . 
            // $aluno['nascimento'][0] . '/' . $aluno['nascimento'][1] . '/' . $aluno['nascimento'][2] . ' | ' .
            // $aluno['matricula_uff'][0] . '.' . $aluno['matricula_uff'][1] . '.' . $aluno['matricula_uff'][2] . '.' . $aluno['matricula_uff'][3] . ' | ' .
            // $aluno['matricula_uff'][0] . '° período de 20' . $aluno['matricula_uff'][1] . ' | ';
            // if($aluno['matricula_uff'][2] == '031') echo 'Ciência da Computação' . ' | ';
            // else if($aluno['matricula_uff'][2] == '041') echo 'Engenharia de Telecomunicações' . ' | ';
            // echo $aluno['cr'] . ' | ' .
            // $aluno['historico'] . '<br><br><hr>';
    ?>

</body>
</html>