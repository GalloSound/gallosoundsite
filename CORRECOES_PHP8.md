[action_email.php] -> Reescrita do fluxo de envio para validar JSON/POST, sanitizar campos, remover `utf8_decode`, corrigir headers e verificar retorno real do `mail()` -> [Compatibilidade]
[action_email.php] -> Ajuste do `From` para remetente fixo do dominio e `Reply-To` com e-mail validado, reduzindo risco de injecao em cabecalhos -> [Seguranca]
[index.php] -> Remocao de atributos `class` duplicados em CTAs, eliminacao de `id` duplicado na secao mobile (`trabalhos-mobile`) e troca de comentario HTML dentro de `<script>` por comentario JS -> [Compatibilidade]
