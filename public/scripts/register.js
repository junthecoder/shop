'use strict';

function validateName() {
  let name = $('#name-input').val();

  let errors = [];
  if (!/\S/.test(name)) {
    errors.push('名前を入力してください');
  }
  $('#name-feedback').html(errors.join('<br>'));

  return errors.length === 0;
}

function validateEmail() {
  let email = $('#email-input').val();

  let errors = [];
  if (!/^\S+@\S+$/.test(email)) {
    errors.push('メールアドレスを入力してください');
  }

  $.ajax({
    type: 'POST',
    url: 'validation.php',
    async: false,
    data: { email }
  })
  .done(data => {
    errors = JSON.parse(data);
  });

  $('#email-feedback').html(errors.join('<br>'));

  return errors.length === 0;
}

function validatePassword() {
  let password = $('#password-input').val();

  let errors = [];
  if (password.length === 0) {
    errors.push('パスワードを入力してください');
  }
  if (password.length < 8) {
    errors.push('8文字以上で入力してください');
  }
  if (!/[a-zA-Z]/.test(password)) {
    errors.push('アルファベットが含まれていません');
  }
  if (!/\d/.test(password)) {
    errors.push('数字が含まれていません');
  }
  $('#password-feedback').html(errors.join('<br>'));

  return errors.length === 0;
}

function validatePasswordCheck() {
  let password = $('#password-input').val();
  let passwordCheck = $('#password-check-input').val();

  let errors = [];
  if (password !== passwordCheck) {
    errors.push('パスワードが一致しません')
  }
  $('#password-check-feedback').html(errors.join('<br>'));

  return errors.length === 0;
}

$('#name-input')[0].addEventListener('input', validateName);
$('#email-input')[0].addEventListener('input', validateEmail);
$('#password-input')[0].addEventListener('input', validatePassword);
$('#password-check-input')[0].addEventListener('input', validatePasswordCheck);

$('#registration-form')[0].addEventListener('submit', event => {
  if (!(validateName() & validateEmail() & validatePassword() & validatePasswordCheck())) {
    event.preventDefault();
    event.stopPropagation();
  }
});
