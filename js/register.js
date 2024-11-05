let currentStep = 1;

function nextStep() {
    if (validateStep(currentStep)) {
        document.querySelector(`.step${currentStep}`).style.display = 'none';
        currentStep++;
        document.querySelector(`.step${currentStep}`).style.display = 'block';
        updateNextButtonState();
    }
}

function prevStep() {
    document.querySelector(`.step${currentStep}`).style.display = 'none';
    currentStep--;
    document.querySelector(`.step${currentStep}`).style.display = 'block';
    updateNextButtonState();
}

function validateStep(step) {
    const form = document.getElementById('registerForm');
    let valid = true;

    switch (step) {
        case 1:
            break;
        case 2:
            const interests = form.querySelectorAll('input[name="interests[]"]:checked');
            valid = interests.length > 0;
            break;
        case 3:
            const maritalStatus = form.querySelector('select[name="marital_status"]').value;
            valid = maritalStatus !== '';
            break;
        case 4:
            const username = form.querySelector('input[name="username"]').value.trim();
            valid = username !== '';
            break;
        case 5:
            const city = form.querySelector('input[name="city"]').value.trim();
            valid = city !== '';
            break;
        case 6:
            const email = form.querySelector('input[name="email"]').value.trim();
            const password = form.querySelector('input[name="password"]').value.trim();
            valid = email !== '' && password !== '';
            break;
        default:
            break;
    }

    return valid;
}

function validatePasswordRequirements() {
    const password = document.getElementById('password').value;
    const lengthRequirement = document.getElementById('lengthRequirement');
    const uppercaseRequirement = document.getElementById('uppercaseRequirement');
    const specialCharRequirement = document.getElementById('specialCharRequirement');
    const passwordErrorMsg = document.querySelector('.password-error-msg');
    const nextButton = document.querySelector('.step6 .next');

    // Validar requisitos
    const hasMinLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    // Atualizar estilos e mensagens
    lengthRequirement.style.color = hasMinLength ? '#4cd137' : '#E74C3C';
    uppercaseRequirement.style.color = hasUppercase ? '#4cd137' : '#E74C3C';
    specialCharRequirement.style.color = hasSpecialChar ? '#4cd137' : '#E74C3C';

    // Exibir mensagem de erro se requisitos não forem atendidos
    if (!hasMinLength || !hasUppercase || !hasSpecialChar) {
        passwordErrorMsg.textContent = 'A senha não atende aos requisitos.';
        passwordErrorMsg.style.display = 'block';
    } else {
        passwordErrorMsg.textContent = '';
        passwordErrorMsg.style.display = 'none';
    }

    return hasMinLength && hasUppercase && hasSpecialChar;
}

function validateConfirmPassword() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const nextButton = document.querySelector('.step6 .next');
    const passwordErrorMsg = document.querySelector('.password-error-msg');

    // Verificar se a confirmação da senha corresponde
    const passwordsMatch = password === confirmPassword;

    if (!passwordsMatch) {
        passwordErrorMsg.textContent = 'As senhas não coincidem.';
        passwordErrorMsg.style.display = 'block';
    } else {
        passwordErrorMsg.textContent = '';
        passwordErrorMsg.style.display = 'none';
    }

    return passwordsMatch;
}

function updateNextButtonState() {
    const step = currentStep;
    const form = document.getElementById('registerForm');

    let valid = false;
    switch (step) {
        case 2:
            const interests = form.querySelectorAll('input[name="interests[]"]:checked');
            valid = interests.length > 0;
            break;
        case 3:
            const maritalStatus = form.querySelector('select[name="marital_status"]').value;
            valid = maritalStatus !== '';
            break;
        case 4:
            const username = form.querySelector('input[name="username"]').value.trim();
            valid = username !== '';
            break;
        case 5:
            const city = form.querySelector('input[name="city"]').value.trim();
            valid = city !== '';
            break;
        case 6:
            const email = form.querySelector('input[name="email"]').value.trim();
            const passwordValid = validatePasswordRequirements();
            const confirmPasswordValid = validateConfirmPassword();
            valid = email !== '' && passwordValid && confirmPasswordValid;
            break;
        default:
            valid = true;
            break;
    }

    const nextButton = form.querySelector(`.step${step} .next`);
    if (nextButton) {
        nextButton.disabled = !valid;
    }
}

function checkUsernameAvailability(username) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'http://localhost:3000/api/register',
            type: 'GET',
            data: { username: username },
            success: function(response) {
                if (response.exists) {
                    resolve(false); 
                } else {
                    resolve(true);
                }
            },
            error: function(xhr, status, error) {
                reject(new Error(`Erro ao verificar disponibilidade: ${error}`));
            }
        });
    });
}

function validateUsername() {
    const form = document.getElementById('registerForm');
    const usernameInput = form.querySelector('input[name="username"]');
    const errorMsg = form.querySelector('.error-msg');

    if (usernameInput) {
        const usernameValue = usernameInput.value.trim();

        // Se o input estiver vazio, limpar a mensagem de erro
        if (usernameValue === '') {
            errorMsg.textContent = '';
            errorMsg.style.display = 'none';
            errorMsg.classList.remove('username-available', 'username-unavailable');
            updateNextButtonState();
            return;
        }

        checkUsernameAvailability(usernameValue).then(isAvailable => {
            if (isAvailable) {
                errorMsg.textContent = 'Disponível!';
                errorMsg.classList.remove('username-unavailable');
                errorMsg.classList.add('username-available');
            } else {
                errorMsg.textContent = 'Indisponível.';
                errorMsg.classList.remove('username-available');
                errorMsg.classList.add('username-unavailable');
            }
            errorMsg.style.display = 'block';
            updateNextButtonState();
        }).catch(error => {
            console.error('Erro ao verificar a disponibilidade do nome de usuário:', error);
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registerForm');
    const nextButtons = document.querySelectorAll('.next');

    // Adiciona um event listener para o evento 'keydown' no formulário
    form.addEventListener('keydown', function (event) {
        // Verifica se a tecla pressionada foi Enter
        if (event.key === 'Enter') {
            // Verifica se o botão 'Continuar' está desabilitado
            const currentStep = document.querySelector('.step:not([style*="display: none"])');
            const nextButton = currentStep.querySelector('.next');
            
            if (nextButton && nextButton.disabled) {
                // Previne o envio do formulário se o botão estiver desabilitado
                event.preventDefault();
            }
        }
    });

    // Adicionar event listeners para a validação da senha
    document.getElementById('password').addEventListener('input', function () {
        validatePasswordRequirements();
        validateConfirmPassword();
        updateNextButtonState();
    });

    document.getElementById('password_confirmation').addEventListener('input', function () {
        validateConfirmPassword();
        updateNextButtonState();
    });


    // Event listeners to update next button state
    form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            updateNextButtonState();
        });
    });

    form.querySelectorAll('select, input[type="text"], input[type="email"], input[type="password"]').forEach(input => {
        input.addEventListener('input', function () {
            updateNextButtonState();
        });
    });

    document.querySelectorAll('.next').forEach(button => {
        button.addEventListener('click', nextStep);
    });

    document.querySelectorAll('.back').forEach(button => {
        button.addEventListener('click', prevStep);
    });

    updateNextButtonState();

    // Email suggestions
    const emailInput = form.querySelector('input[name="email"]');
    const emailSuggestions = document.createElement('div');
    emailSuggestions.classList.add('email-suggestions');
    emailInput.parentNode.appendChild(emailSuggestions);

    const domains = ['gmail.com', 'outlook.com', 'yahoo.com', 'hotmail.com', 'live.com', 'icloud.com'];

    emailInput.addEventListener('input', function () {
        const value = emailInput.value;
        if (value.includes('@')) {
            const [localPart, domainPart] = value.split('@');
            if (domainPart) {
                const suggestions = domains.filter(domain => domain.startsWith(domainPart)).map(domain => `${localPart}@${domain}`);
                displaySuggestions(emailSuggestions, suggestions);
            } else {
                displaySuggestions(emailSuggestions, domains.map(domain => `${localPart}@${domain}`));
            }
        } else {
            emailSuggestions.style.display = 'none';
        }
    });

    emailSuggestions.addEventListener('click', function (event) {
        if (event.target.tagName === 'DIV') {
            emailInput.value = event.target.textContent;
            emailSuggestions.style.display = 'none';
        }
    });

    // City autocomplete
    const cityInput = form.querySelector('input[name="city"]');
    const citySuggestions = document.createElement('div');
    citySuggestions.classList.add('city-suggestions');
    cityInput.parentNode.appendChild(citySuggestions);

    let cityTimeout;

    cityInput.addEventListener('input', function () {
        const value = cityInput.value;
        clearTimeout(cityTimeout);
        if (value.length > 3) {
            cityTimeout = setTimeout(() => {
                fetchCities(value);
            }, 1000); // 1000ms = 1 second
        } else {
            citySuggestions.style.display = 'none';
        }
    });

    citySuggestions.addEventListener('click', function (event) {
        if (event.target.tagName === 'DIV') {
            cityInput.value = event.target.textContent;
            citySuggestions.style.display = 'none';
        }
    });

    document.addEventListener('click', function (event) {
        if (!citySuggestions.contains(event.target) && event.target !== cityInput) {
            citySuggestions.style.display = 'none';
        }
    });

    function displaySuggestions(container, suggestions) {
        container.innerHTML = suggestions.map(suggestion => `<div>${suggestion}</div>`).join('');
        container.style.display = 'block';
    }

    function fetchCities(query) {
        $.ajax({
            url: 'https://servicodados.ibge.gov.br/api/v1/localidades/municipios',
            type: 'GET',
            success: function(response) {
                const cities = response.map(city => city.nome);
                const filteredCities = cities.filter(city => city.toLowerCase().includes(query.toLowerCase()));
                displaySuggestions(citySuggestions, filteredCities);
            },
            error: function(xhr, status, error) {
                console.error('Erro ao obter lista de cidades:', error);
            }
        });
    }

    // Validar nome de usuário no passo 4
    const usernameInput = form.querySelector('input[name="username"]');
    const errorMsg = document.createElement('div');
    errorMsg.classList.add('error-msg');
    usernameInput.parentNode.appendChild(errorMsg);

    if (usernameInput) {
        usernameInput.addEventListener('input', function () {
            validateUsername();
        });
    }

    
});
