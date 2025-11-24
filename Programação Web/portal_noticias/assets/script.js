document.addEventListener('DOMContentLoaded', function () {
  var formLogin = document.querySelector('.form-login');
  if (formLogin) {
    formLogin.addEventListener('submit', function (e) {
      var email = formLogin.querySelector('input[name="email"]');
      var senha = formLogin.querySelector('input[name="senha"]');
      if (!email.value.trim() || !senha.value.trim()) {
        e.preventDefault();
        alert('preencha email e senha');
      }
    });
  }

  var formNoticia = document.querySelector('.form-noticia');
  if (formNoticia) {
    formNoticia.addEventListener('submit', function (e) {
      var titulo = formNoticia.querySelector('input[name="titulo"]');
      var categoria = formNoticia.querySelector('input[name="categoria"]');
      var conteudo = formNoticia.querySelector('textarea[name="conteudo"]');
      if (!titulo.value.trim() || !categoria.value.trim() || !conteudo.value.trim()) {
        e.preventDefault();
        alert('preencha todos os campos da noticia');
      }
    });
  }
});

document.addEventListener('DOMContentLoaded', function () {
  var formLogin = document.querySelector('.form-login');
  if (formLogin) {
    formLogin.addEventListener('submit', function (e) {
      var email = formLogin.querySelector('input[name="email"]');
      var senha = formLogin.querySelector('input[name="senha"]');
      if (!email.value.trim() || !senha.value.trim()) {
        e.preventDefault();
        alert('preencha email e senha');
      }
    });
  }

  var formNoticia = document.querySelector('.form-noticia');
  if (formNoticia) {
    formNoticia.addEventListener('submit', function (e) {
      var titulo = formNoticia.querySelector('input[name="titulo"]');
      var categoria = formNoticia.querySelector('input[name="categoria"]');
      var conteudo = formNoticia.querySelector('textarea[name="conteudo"]');
      if (!titulo.value.trim() || !categoria.value.trim() || !conteudo.value.trim()) {
        e.preventDefault();
        alert('preencha todos os campos da noticia');
      }
    });
  }

  var formCadastro = document.querySelector('.form-cadastro');
  if (formCadastro) {
    formCadastro.addEventListener('submit', function (e) {
      var nome = formCadastro.querySelector('input[name="nome"]');
      var email = formCadastro.querySelector('input[name="email"]');
      var senha = formCadastro.querySelector('input[name="senha"]');
      var senha2 = formCadastro.querySelector('input[name="senha2"]');
      if (!nome.value.trim() || !email.value.trim() || !senha.value.trim() || !senha2.value.trim()) {
        e.preventDefault();
        alert('preencha todos os campos');
        return;
      }
      if (senha.value.length < 6) {
        e.preventDefault();
        alert('a senha deve ter pelo menos 6 caracteres');
        return;
      }
      if (senha.value !== senha2.value) {
        e.preventDefault();
        alert('as senhas nao conferem');
      }
    });
  }
});

