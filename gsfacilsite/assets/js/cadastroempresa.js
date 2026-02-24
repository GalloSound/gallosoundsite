
// hide and show checkbox
let hiddenandshow = {
    handlechecked: (e) => {
        let elem = e.target

        let div = elem.getAttribute('data-hidden');

        let divAll = document.querySelector("." + div);
        // capturando todos os inputs dentro da Div
        let inputs = divAll.querySelectorAll('input');


        if (elem.checked) {
            $("." + div).show('slow');

            // adicionando data-rule nos inputs
            for (let i = 0; i < inputs.length; i++) {
                let input = inputs[i];
                let check = input.setAttribute('data-rules', 'required|min=2');
            }

        } else {
            $("." + div).hide('slow');

            // removendo data-rule nos inputs
            for (let i = 0; i < inputs.length; i++) {
                let input = inputs[i];
                let check = input.removeAttribute('data-rules');
            }
        }
    }
}

let checkboxs = document.querySelectorAll('.hiddenandshow');
form.addEventListener('change', hiddenandshow.handlechecked);
//.hide and show checkbox

// Inputmask

// telefone
let tel = document.getElementById("tel");
Inputmask({ "mask": "(99) 9999-9999" }).mask(tel);

// cnpj
let cnpj = document.getElementById("cnpj");
Inputmask({ "mask": "99.999.999/9999-99" }).mask(cnpj);

// ie
let ie = document.getElementById("ie");
Inputmask({ "mask": "999.999.999.999" }).mask(ie);

// cep
let cep = document.getElementById("cep");
Inputmask({ "mask": "99.999-999" }).mask(cep);

// celular
let cel = document.getElementById("cel");
Inputmask({ "mask": "(5599) 99999-9999" }).mask(cel);

// IP
let ipFixo = document.getElementById("ipFixo");
Inputmask({ "mask": "999.999.999.99" }).mask(ipFixo);

// margem miníma
let mmin = document.getElementById("mmin");
Inputmask({ "mask": "9.99" }).mask(mmin);

// Inputmask

// consulta cnpj
let Consulta = {
    consultaCNPJ:(e) => {
        let cnpj = e.target.value;
        cnpj = Consulta.justNumber(cnpj);

        //Consulta o webservice receitaws
        let url = base + "/ajax/getDadosCNPJ/" + cnpj;

        fetch(url)
            .then(r => r.json())
            .then(json => {

                console.log(json);

                if (json.ret == false) {
                    return;
                }

                if (json.status == "ERROR") {
                    return;
                }

                if (!("ERROR" in json) && json.status != "ERROR") {

                    //Atualiza os campos com os valores da consulta caso esteja vazio após a primeira caonsulta).
                    if (json.nome.length > 0) {
                        $("#nomeEmpresa").val(json.nome);
                        $("#razao").val(json.nome);
                    }
                    if (json.logradouro.length > 0) {
                        $("#xLgr").val(json.logradouro);
                    }
                    if (json.bairro.length > 0) {
                        $("#xBairro").val(json.bairro);
                    }

                    if (json.municipio.length > 0) {
                        $("#xMun").val(json.municipio);
                    }
                    if (json.numero.length > 0) {
                        $("#nro").val(json.numero);
                    }
                    if (json.telefone.length > 0) {
                        $("#tel").val(json.telefone);
                    }

                    /*
                    if (json.uf.length > 0) {
                        $("#uf").val(json.uf);
                    }
    
                     select 2 bootstrap
                    $('#uf').trigger({
                        type: 'select2:select',
                        params: {
                            data: json.uf
                        }
                    });
                    */

                    $('#uf').val(json.uf).trigger('change');

                    $("#xPais").val("BRASIL");
					$("#cPais").val("1058");

                    let description = '';
                    description += `abertura: ${json.abertura}`;
                    description += ` - situação: ${json.situacao}\n`;
                    description += `ultima atualização: ${json.ultima_atualizacao}\n`;
                    description += `atividade principal: ${json.atividade_principal[0].text}`;
                    description += ` - cod: ${json.atividade_principal[0].code}\n`;
                    for (let i in json.qsa) {
                        description += `${json.qsa[i].qual} nome: ${json.qsa[i].nome}\n`;
                    }
                    $("#descr").val(description);

                    Consulta.consultaCep(json.cep);


                } else {
                    return;
                }

            });

    },
    consultaCep:(cep) => {
        // consulata viacep.com.br/
            cep = Consulta.justNumber(cep);

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                let validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {

                            console.log(dados);
                            console.log('here');

                            //Atualiza os campos com os valores da consulta.
                            if ($("#xLgr").val() == "") {
                                $("#xLgr").val(dados.logradouro);
                            }
                            if ($("#xBairro").val() == "") {
                                $("#xBairro").val(dados.bairro);
                            }
                            if ($("#xMun").val() == "") {
                                $("#xMun").val(dados.localidade);
                            }
                            if ($("#uf").val() == "") {
                                $('#uf').val(dados.uf).trigger('change');
                            }
                            if ($('#cMun').val() == "") {
                                $("#cMun").val(dados.ibge);
                            }
                            if ($('#cep').val() == "") {
                                $("#cep").val(dados.cep.replace('.', ''));
                            }
                            if ($('#nro').val() == "") {
                                $("#nro").val(dados.nro);
                            }
                        } //end if.
                        else {
                            /*CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");*/
                        }
                    });
                } //end if.
                else {
                    /*cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");*/
                }
            } else {
                //cep sem valor, limpa formulário.
                //Consulta.limpa_formulário_cep();
            }

            return;

    },
    limpa_formulario_cep:() => {
        // Limpa valores do formulário de cep.
        $("#xLgr").val("");
        $("#xBairro").val("");
        $("#xMun").val("");
        $("#uf").val("");
        $("#cMun").val("");
        $("#xNome").val("");
        $("#xLgr").val("");
        $("#xBairro").val("");
        $("#xMun").val("");
        $("#uf").val("");
        $("#cMun").val("");
        $("#cep").val('');
        $("#num").val('');
        $("#num").val('');
        $("#xPais").val("");
        $("#cPais").val("");
        $("#p_description").val("");
    },
    justNumber: (n) => {
        n = n.replace(/\D/g, '');
        return n;
    }
}
let consultaCNPJ = document.querySelector('#cnpj');
consultaCNPJ.addEventListener('blur', Consulta.consultaCNPJ);




