// public/js/main.js

function mascaraCPF(i) {
    var v = i.value;
    
    // Remove tudo o que não é dígito
    v = v.replace(/\D/g, ""); 
    
    // Coloca os pontos e o traço
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    
    i.value = v;
}

function mascaraTelefone(i) {
    var v = i.value;
    
    // Remove tudo o que não é dígito
    v = v.replace(/\D/g, "");
    
    // Coloca parênteses e traço (Celular 11 dígitos ou Fixo 10)
    v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
    v = v.replace(/(\d{5})(\d{4})$/, "$1-$2");
    
    i.value = v;
}

// Ativa as máscaras automaticamente quando a página carregar
document.addEventListener("DOMContentLoaded", function() {
    const inputCPF = document.querySelector('input[name="cpf"]');
    const inputTel = document.querySelector('input[name="telefone"]');

    if(inputCPF) {
        inputCPF.addEventListener('input', function() { mascaraCPF(this); });
    }
    
    if(inputTel) {
        inputTel.addEventListener('input', function() { mascaraTelefone(this); });
    }
});