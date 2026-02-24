
/*

*/

let Validator = {
	onClick: (id, checked, name, type) => {
		Validator.checkType(name, type);
		console.log(type);

		// adicionando valor checked true ou false (o que vier)
		arraySelect[id] = checked;

		Validator.saveInfo(id, name, checked);

		console.log(arraySelect);
	},
	checkType: (name, type) => {
		// caso seja radio limpar todos para atualizar somente o selecinado
		if (type == 'radio') {
			// capturando todos os radio selecionado
			let inputsRadio = document.querySelectorAll('input[name=' + name);
			// adicionando false para todos
			inputsRadio.forEach((input) => {
				let id = input.getAttribute('id');
				arraySelect[id] = false;
				Validator.saveInfo(id, name, false);

			});
		}
	},
	blurGetInfo: (e) => {
		let id = e.target.id;
		let name = e.target.name;
		let value = e.target.value;
		if (value.length > 0) {
			Validator.saveInfo(id, name, value);
		}

	},
	saveInfo: (id, campo, value) => {

		let url = `${base}/ajax/cadastrar`;
		let params = {
			method: 'POST',
			body: JSON.stringify({
				id, campo, value
			})
		}

		fetch(url, params)
			.then(r => r.json())
			.then(json => {
				console.log(json);

			});
	}
};

let form = document.querySelector('.form-cadastro');
form.addEventListener('submit', Validator);

//document.getElementById('experiencia7').setAttribute('checked', 'checked');

let arraySelect = [];
// capturando inputs
let inputs = form.querySelectorAll('input');
// adicionando eventos nos inputs
inputs.forEach((input) => {

	let inputType = input.getAttribute('type');

	if (inputType == 'text' || inputType == 'email') {
		input.addEventListener('blur', Validator.blurGetInfo);
		return;
	}

	input.addEventListener('click', () => {
		let id = input.getAttribute('id');
		let checked = input.checked;
		let name = input.getAttribute('name');
		let type = input.getAttribute('type');

		Validator.onClick(id, checked, name, type);
	})
});

document.querySelector("#dados-info").addEventListener('click', (e) => {
	e.preventDefault();
	//$.support.transition = false;


	$('#modal-info').show({
		show: true
	});
	$('#modal-info').modal();
});

// mask celular
let cel = document.getElementById("celular");
Inputmask({ "mask": "(99) 99999-9999" }).mask(cel);

// mask cep
let cep = document.getElementById("cep");
Inputmask({ "mask": "99999-999" }).mask(cep);

// mask nascimento
let nasc = document.getElementById("nascimento");
Inputmask({ "mask": "99/99/9999" }).mask(nasc);



/*
// CONSULTA CPF api paga https://rapidapi.com/DataFast/api/consulta-situacao-cpf-ou-cnpj/
function cpf(c) {
	let cpf = c;
	let url = `https://consulta-situacao-cpf-cnpj.p.rapidapi.com/consultaSituacaoCPF?cpf=%7B${cpf}%7D`
	fetch(url, {
		"method": "GET",
		"headers": {
			"x-rapidapi-key": "6cea5dd9c1msh5d86bd9d53af6b0p1b53d8jsn5b64db87cd08",
			"x-rapidapi-host": "consulta-situacao-cpf-cnpj.p.rapidapi.com"
		}
	})
		.then(response => {
			console.log(response);
		})
		.catch(err => {
			console.error(err);
		});
}
*/