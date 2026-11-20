
function emailValido(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}


function mostrarErro(form, texto) {
    let aviso = form.querySelector('.mensagem.erro');
    if (!aviso) {
        aviso = document.createElement('div');
        aviso.className = 'mensagem erro';
        form.prepend(aviso);
    }
    aviso.textContent = texto;
}


document.querySelectorAll('input[type="password"]').forEach(function (campo) {
    const botao = document.createElement('button');
    botao.type = 'button';
    botao.className = 'btn-olho';
    botao.textContent = 'Mostrar';
    botao.addEventListener('click', function () {
        const oculto = campo.type === 'password';
        campo.type = oculto ? 'text' : 'password';
        botao.textContent = oculto ? 'Ocultar' : 'Mostrar';
    });
    campo.insertAdjacentElement('afterend', botao);
});


const formLogin = document.getElementById('form-login');
if (formLogin) {
    formLogin.addEventListener('submit', function (e) {
        const email = formLogin.email.value.trim();
        const senha = formLogin.senha.value;

        if (email === '' || senha === '') {
            e.preventDefault();
            mostrarErro(formLogin, 'Preencha o e-mail e a senha.');
        } else if (!emailValido(email)) {
            e.preventDefault();
            mostrarErro(formLogin, 'Informe um e-mail válido.');
        }
    });
}


const formCadastro = document.getElementById('form-cadastro');
if (formCadastro) {
    formCadastro.addEventListener('submit', function (e) {
        const nome = formCadastro.nome.value.trim();
        const email = formCadastro.email.value.trim();
        const senha = formCadastro.senha.value;
        const confirmar = formCadastro.confirmar_senha.value;

        if (nome === '' || email === '' || senha === '' || confirmar === '') {
            e.preventDefault();
            mostrarErro(formCadastro, 'Preencha todos os campos.');
        } else if (!emailValido(email)) {
            e.preventDefault();
            mostrarErro(formCadastro, 'Informe um e-mail válido.');
        } else if (senha !== confirmar) {
            e.preventDefault();
            mostrarErro(formCadastro, 'As senhas não são iguais.');
        }
    });
}


const formEvento = document.getElementById('form-evento');
if (formEvento) {
    formEvento.addEventListener('submit', function (e) {
        const campos = ['nome', 'descricao', 'data', 'horario', 'local'];
        const vazio = campos.some(function (c) {
            return formEvento[c].value.trim() === '';
        });
        if (vazio) {
            e.preventDefault();
            mostrarErro(formEvento, 'Preencha todos os campos.');
        }
    });
}
// Pede confirmação antes de cancelar um agendamento
document.querySelectorAll('.form-cancelar').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        if (!confirm('Tem certeza que deseja cancelar este agendamento?')) {
            e.preventDefault();
        }
    });
});