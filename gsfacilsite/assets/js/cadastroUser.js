// cnpj
let ie = document.getElementById("cpf");
Inputmask({ "mask": "999.999.999-99" }).mask(ie);

// birthdate
let birthdate = document.getElementById("birthdate");
Inputmask({ "mask": "99/99/9999" }).mask(birthdate);