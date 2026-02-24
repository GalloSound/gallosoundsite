let editAction = {
    editClick: (e) => {
        e.preventDefault();
        let v  = e.target.value;
        console.log(v);

        $('html,body').animate({scrollTop: $('input').offset().top}, 200, function() {
            $('#name').focus();
        })

        let name = document.querySelector('#name').value;
        let slug = document.querySelector('#slug');

        console.log(name);

        console.log(name);

        let btnSubmit = document.querySelector('#btnSubmit');
        btnSubmit.innerHTML = 'Editar Item';
        btnSubmit.classList.remove('btn-success');
        btnSubmit.classList.add('btn-warning');
    },
    getPermission: () => {
        
    }
};


let edit = document.querySelectorAll('.edit');
for(let i=0;i<edit.length;i++) {
    edit[i].addEventListener('click', editAction.editClick);
}
