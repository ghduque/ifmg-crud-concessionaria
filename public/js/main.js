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

function mascaraTelefone(input) {
    let v = input.value;
    
    // 1. Remove tudo que não for número imediatamente
    v = v.replace(/\D/g, "");

    // 2. Impede que tenha mais de 11 dígitos (DDD + 9 números)
    if (v.length > 11) {
        v = v.slice(0, 11);
    }

    // 3. Aplica a máscara visual para facilitar a leitura
    if (v.length > 10) {
        // Formato Celular: (11) 98888-7777
        v = v.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (v.length > 5) {
        // Formato Fixo: (11) 8888-7777
        v = v.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    } else if (v.length > 2) {
        v = v.replace(/^(\d{2})(\d{0,5}).*/, "($1) $2");
    } else if (v.length > 0) {
        v = v.replace(/^(\d{0,2}).*/, "($1");
    }

    input.value = v;
}

document.addEventListener('DOMContentLoaded', function() {
    // Mascara de Telefone (conforme solicitado anteriormente)
    const inputTelefone = document.getElementById('telefone');
    if (inputTelefone) {
        inputTelefone.addEventListener('input', function() {
            mascaraTelefone(this);
        });
    }

    // Feedback de Fotos Selecionadas (PC e Celular)
    const inputFotos = document.getElementById('inputFotos');
    const preview = document.getElementById('preview-fotos');

    if (inputFotos && preview) {
        inputFotos.addEventListener('change', function() {
            const qtd = this.files.length;
            if (qtd > 0) {
                preview.innerHTML = `<b class="text-success">✓ ${qtd} foto(s) selecionada(s).</b>`;
            } else {
                preview.innerHTML = "Nenhuma foto selecionada.";
            }
        });
    }
});

function mascaraTelefone(input) {
    let v = input.value.replace(/\D/g, "");
    if (v.length > 11) v = v.slice(0, 11);
    if (v.length > 10) {
        v = v.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (v.length > 5) {
        v = v.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    } else if (v.length > 2) {
        v = v.replace(/^(\d{2})(\d{0,5}).*/, "($1) $2");
    } else if (v.length > 0) {
        v = v.replace(/^(\d{0,2}).*/, "($1");
    }
    input.value = v;
}