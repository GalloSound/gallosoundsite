/*
Modo de usar
adicionar uma class no formulario b7validator
adicionar nos inputs as regras que vc precisa com o atributo data-rules=""
ex: data-rules="required|min=2" campo obrigatório com no mínimo 2 caracteres
lembrando que sempre precisa fazer a validação no backend
*/
let B7Validator = {
    handleSubmit:(event)=>{
        event.preventDefault();
        let send = true;

        // capturando todos os inputs dentro do form
        let inputs = formulario.querySelectorAll('input');
        let selects = formulario.querySelectorAll('select');

        B7Validator.clearErrors();

        for(let i=0;i<inputs.length;i++) {
            let input = inputs[i];
            let check = B7Validator.checkInput(input);
            if(check !== true) {
                send = false;
                B7Validator.showError(input, check);
            }
        }

        for(let i=0;i<selects.length;i++) {
            let select = selects[i];
            let check = B7Validator.checkInput(select);
            if(check !== true) {
                send = false;
                B7Validator.showError(select, check);
            }
        }

        if(send) {
            formulario.submit();
        } else {
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
    },
    checkInput:(input) => {
        let rules = input.getAttribute('data-rules');

        if(rules !== null) {
            rules = rules.split('|');
            for(let k in rules) {
                let rDetails = rules[k].split('=');
                switch(rDetails[0]) {
                    case 'required':
                        if(input.value == '') {
                            return 'Campo não pode ser vazio.';
                        }
                    break;
                    case 'min':
                        if(input.value.length < rDetails[1]) {
                            return 'Campo tem que ter pelo menos '+rDetails[1]+' caractes';
                        }
                    break;
                    case 'email':
                        if(input.value != '') {
                            let regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            if(!regex.test(input.value.toLowerCase())) {
                                return 'E-mail digitado não é válido!';
                            }
                        }
                    break;
                }
            }
        }

        return true;
    },
    showError:(input, error) => {
        input.style.borderColor = '#FF0000';


        let errorElement = document.createElement('div');
        errorElement.classList.add('error');
        errorElement.innerHTML = error;

        //input.parentElement.insertBefore(errorElement, input.ElementSibling);

        // modificação para bootstrap
        input.parentElement.insertAdjacentElement("afterend", errorElement);
    },
    clearErrors:() => {
        let inputs = formulario.querySelectorAll('input');
        for(let i=0;i<inputs.length;i++) {
            inputs[i].style = '';
        }

        let selects = formulario.querySelectorAll('select');
        for(let i=0;i<selects.length;i++) {
            selects[i].style = '';
        }

        let errorElements = document.querySelectorAll('.error');
        for(let i=0;i<errorElements.length;i++) {
            errorElements[i].remove();
        }
    }
};

let formulario = document.querySelector('.b7validator');
formulario.addEventListener('submit', B7Validator.handleSubmit);