const form = document.querySelector('form');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm_password');

if (emailInput) emailInput.placeholder = 'example@email.com';


function createErrorEl(afterElement) {
    let el = afterElement.nextElementSibling;
    if (!el || !el.classList.contains('validation-msg')) {
        el = document.createElement('small');
        el.classList.add('validation-msg', 'd-block', 'mt-1');
        afterElement.insertAdjacentElement('afterend', el);
    }
    return el;
}

const emailErr = emailInput ? createErrorEl(emailInput) : null;
const confirmErr = confirmPasswordInput ? createErrorEl(confirmPasswordInput) : null;

const rulesContainer = document.createElement('div');
rulesContainer.classList.add('mt-2', 'small');
if (passwordInput) passwordInput.insertAdjacentElement('afterend', rulesContainer);

const rules = [
    { key: 'length', text: 'At least 6 characters' },
    { key: 'capital', text: 'Must start with a capital letter' },
    { key: 'number', text: 'Must contain at least 4 numbers' },
    { key: 'symbol', text: 'Must contain @ or # or $' },
];

const ruleEls = {};
rules.forEach(r => {
    const el = document.createElement('div');
    el.textContent = '• ' + r.text;
    el.classList.add('text-muted');
    rulesContainer.appendChild(el);
    ruleEls[r.key] = el;
});

const strongMsg = document.createElement('small');
strongMsg.textContent = '✓ Password is strong';
strongMsg.classList.add('text-success', 'd-none', 'fw-bold');
rulesContainer.insertAdjacentElement('afterend', strongMsg);


function showError(input, errEl, msg) {
    if (errEl) {
        errEl.textContent = msg;
        errEl.className = 'validation-msg d-block mt-1 text-danger';
    }
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
}

function showSuccess(input, errEl, msg) {
    if (errEl) {
        errEl.textContent = msg;
        errEl.className = 'validation-msg d-block mt-1 text-success';
    }
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
}

function clearField(input, errEl) {
    if (errEl) errEl.textContent = '';
    input.classList.remove('is-invalid', 'is-valid');
}

function validateEmail(value) {
    return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value.trim());
}

function checkPasswordRules(pw) {
    return {
        length: pw.length >= 6,
        capital: pw.length > 0 && /[A-Z]/.test(pw[0]),
        number: (pw.match(/[0-9]/g) || []).length >= 4,
        symbol: /[@#$]/.test(pw),
    };
}


if (emailInput) {
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
}

if (passwordInput) {
    passwordInput.addEventListener('input', function () {
        const pw = this.value;
        if (pw === '') {
            rulesContainer.classList.remove('d-none');
            strongMsg.classList.add('d-none');
            Object.values(ruleEls).forEach(el => el.className = 'text-muted');
            clearField(this, null);
            if (confirmPasswordInput && confirmPasswordInput.value !== '') checkConfirm();
            return;
        }

        const passed = checkPasswordRules(pw);
        const allPassed = Object.values(passed).every(Boolean);

        if (allPassed) {
            rulesContainer.classList.add('d-none');
            strongMsg.classList.remove('d-none');
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            rulesContainer.classList.remove('d-none');
            strongMsg.classList.add('d-none');
            rules.forEach(r => {
                ruleEls[r.key].className = passed[r.key] ? 'text-success' : 'text-danger';
                ruleEls[r.key].textContent = (passed[r.key] ? '✓ ' : '• ') + r.text;
            });
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        }
        if (confirmPasswordInput && confirmPasswordInput.value !== '') checkConfirm();
    });
}

function checkConfirm() {
    if (!confirmPasswordInput || !passwordInput) return true;
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

if (confirmPasswordInput) {
    confirmPasswordInput.addEventListener('input', checkConfirm);
}

if (form) {
    form.addEventListener('submit', function (e) {
        let ok = true;

        const allInputs = form.querySelectorAll('input[required]');
        allInputs.forEach(input => {
            if (input.value.trim() === '') {
                input.classList.add('is-invalid');
                ok = false;
            }
        });

        if (emailInput && !validateEmail(emailInput.value.trim())) {
            showError(emailInput, emailErr, 'Please enter a valid email address');
            ok = false;
        }

        if (passwordInput) {
            const passed = checkPasswordRules(passwordInput.value);
            if (!Object.values(passed).every(Boolean)) {
                passwordInput.classList.add('is-invalid');
                ok = false;
            }
        }

        if (!checkConfirm()) ok = false;

        if (!ok) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    form.addEventListener('reset', function () {
        setTimeout(() => {
            if (emailInput) clearField(emailInput, emailErr);
            if (confirmPasswordInput) clearField(confirmPasswordInput, confirmErr);
            if (passwordInput) {
                clearField(passwordInput, null);
                rulesContainer.classList.remove('d-none');
                strongMsg.classList.add('d-none');
                Object.values(ruleEls).forEach(el => el.className = 'text-muted');
            }
        }, 10);
    });
}
