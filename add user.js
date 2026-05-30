const form = document.querySelector('form');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm_password');

emailInput.placeholder = 'example@email.com';

function createErrorEl(afterElement) {
  const el = document.createElement('small');
  afterElement.insertAdjacentElement('afterend', el);
  return el;
}

const emailErr = createErrorEl(emailInput);
const confirmErr = createErrorEl(confirmPasswordInput);

const rulesContainer = document.createElement('div');
passwordInput.insertAdjacentElement('afterend', rulesContainer);

const rules = [
  { key: 'length', text: 'At least 6 characters' },
  { key: 'capital', text: 'Must start with a capital letter' },
  { key: 'number', text: 'Must contain at least 4 numbers' },
  { key: 'symbol', text: 'Must contain @ or # or $' },
];

const ruleEls = {};

rules.forEach(r => {
  const el = document.createElement('small');
  el.textContent = '• ' + r.text;
  rulesContainer.appendChild(el);
  ruleEls[r.key] = el;
});

const strongMsg = document.createElement('small');
strongMsg.textContent = '✓ Password is strong';
strongMsg.classList.add('strong-message');

rulesContainer.insertAdjacentElement('afterend', strongMsg);

function showError(input, errEl, msg) {
  errEl.textContent = msg;

  input.classList.remove('success');
  input.classList.add('error');

  errEl.classList.remove('success-text');
  errEl.classList.add('error-text');
}

function showSuccess(input, errEl, msg) {
  errEl.textContent = msg;

  input.classList.remove('error');
  input.classList.add('success');

  errEl.classList.remove('error-text');
  errEl.classList.add('success-text');
}

function clearField(input, errEl) {
  if (errEl) errEl.textContent = '';

  input.classList.remove('error', 'success');
}

function validateEmail(value) {
  return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value.trim());
}

emailInput.addEventListener('input', function () {
  const val = this.value.trim();

  if (val === '') {
    clearField(this, emailErr);
    return;
  }

  if (!validateEmail(val)) {
    showError(this, emailErr, 'Please enter a valid email address');
  } else {
    showSuccess(this, emailErr, '✓ Valid email');
  }
});

function checkPasswordRules(pw) {
  return {
    length: pw.length >= 6,
    capital:
      pw.length > 0 &&
      /[a-zA-Z]/.test(pw[0]) &&
      pw[0] === pw[0].toUpperCase(),
    number: (pw.match(/[0-9]/g) || []).length >= 4,
    symbol: /[@#$]/.test(pw),
  };
}

passwordInput.addEventListener('input', function () {
  const pw = this.value;

  if (pw === '') {
    rulesContainer.classList.remove('hide');
    strongMsg.classList.remove('show');

    rules.forEach(r => {
      ruleEls[r.key].className = '';
      ruleEls[r.key].textContent = '• ' + r.text;
    });

    clearField(this, null);

    if (confirmPasswordInput.value !== '') checkConfirm();

    return;
  }

  const passed = checkPasswordRules(pw);
  const allPassed = Object.values(passed).every(Boolean);

  if (allPassed) {
    rulesContainer.classList.add('hide');
    strongMsg.classList.add('show');

    this.classList.remove('error');
    this.classList.add('success');
  } else {
    rulesContainer.classList.remove('hide');
    strongMsg.classList.remove('show');

    rules.forEach(r => {
      if (passed[r.key]) {
        ruleEls[r.key].className = 'success-text';
        ruleEls[r.key].textContent = '✓ ' + r.text;
      } else {
        ruleEls[r.key].className = 'error-text';
        ruleEls[r.key].textContent = '• ' + r.text;
      }
    });

    this.classList.remove('success');
    this.classList.add('error');
  }

  if (confirmPasswordInput.value !== '') checkConfirm();
});

function checkConfirm() {
  const val = confirmPasswordInput.value;

  if (val === '') {
    clearField(confirmPasswordInput, confirmErr);
    return true;
  }

  if (val !== passwordInput.value) {
    showError(confirmPasswordInput, confirmErr, 'Passwords do not match');
    return false;
  } else {
    showSuccess(confirmPasswordInput, confirmErr, '✓ Passwords match');
    return true;
  }
}

confirmPasswordInput.addEventListener('input', checkConfirm);

form.addEventListener('submit', function (e) {
  let ok = true;

  if (!validateEmail(emailInput.value.trim())) {
    showError(emailInput, emailErr, 'Please enter a valid email address');
    ok = false;
  }

  const allPassed = Object.values(
    checkPasswordRules(passwordInput.value)
  ).every(Boolean);

  if (!allPassed) {
    passwordInput.dispatchEvent(new Event('input'));
    ok = false;
  }

  if (!checkConfirm()) ok = false;

  if (!ok) e.preventDefault();
});

form.addEventListener('reset', function () {
  setTimeout(() => {
    clearField(emailInput, emailErr);
    clearField(confirmPasswordInput, confirmErr);
    clearField(passwordInput, null);

    rulesContainer.classList.remove('hide');
    strongMsg.classList.remove('show');

    rules.forEach(r => {
      ruleEls[r.key].className = '';
      ruleEls[r.key].textContent = '• ' + r.text;
    });
  }, 10);
});

form.addEventListener('submit', function (e) {

  let ok = true;

  const allInputs = form.querySelectorAll('input');

  allInputs.forEach(input => {
    if (input.value.trim() === '') {
      input.classList.add('error');
      ok = false;
    }
  });

  if (!validateEmail(emailInput.value.trim())) {
    showError(emailInput, emailErr, 'Please enter a valid email address');
    ok = false;
  }

  const allPassed = Object.values(
    checkPasswordRules(passwordInput.value)
  ).every(Boolean);

  if (!allPassed) {
    passwordInput.dispatchEvent(new Event('input'));
    ok = false;
  }

  if (!checkConfirm()) ok = false;

  if (!ok) e.preventDefault();
});