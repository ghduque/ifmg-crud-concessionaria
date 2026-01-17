/* ==========================================================================
   ARQUIVO JAVASCRIPT PRINCIPAL - AUTONÍVEL
   Organização: Funções Utilitárias > Inicialização por Módulo
   ========================================================================== */

/* --------------------------------------------------------------------------
   1. FUNÇÕES DE MÁSCARA (FORMATAÇÃO DE INPUTS)
   Uso: Chamadas automaticamente nos eventos de input
   -------------------------------------------------------------------------- */

// Máscara para CPF: 000.000.000-00
function mascaraCPF(input) {
    let v = input.value;
    
    v = v.replace(/\D/g, "");                    // Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2");       // Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2");       // Coloca um ponto entre o terceiro e o quarto dígitos de novo
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Coloca um hífen entre o terceiro e o quarto dígitos
    
    input.value = v;
}

// Máscara para Telefone (Híbrida: Fixo 10 dígitos / Celular 11 dígitos)
function mascaraTelefone(input) {
    let v = input.value.replace(/\D/g, ""); // Remove tudo que não for número
    
    // Limita a 11 dígitos
    if (v.length > 11) v = v.slice(0, 11);

    // Lógica incremental para formatar enquanto digita
    if (v.length > 10) {
        // Formato Celular: (11) 98888-7777
        v = v.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (v.length > 5) {
        // Formato Fixo/Parcial: (11) 8888-7777
        v = v.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    } else if (v.length > 2) {
        // Apenas DDD: (11) 9...
        v = v.replace(/^(\d{2})(\d{0,5}).*/, "($1) $2");
    } else if (v.length > 0) {
        // Início: (1...
        v = v.replace(/^(\d{0,2}).*/, "($1");
    }

    input.value = v;
}


/* --------------------------------------------------------------------------
   2. INICIALIZAÇÃO DO DOM (QUANDO A PÁGINA CARREGA)
   Uso: Detecta elementos na tela e aplica os eventos
   -------------------------------------------------------------------------- */

document.addEventListener("DOMContentLoaded", function() {

    /* --- MÓDULO: APLICAÇÃO DE MÁSCARAS --- */
    // Procura por inputs pelo 'name' para ser mais genérico e funcionar em Cadastro, Perfil e Criar Veículo
    const inputCPF = document.querySelector('input[name="cpf"]');
    const inputTel = document.querySelector('input[name="telefone"]');

    if (inputCPF) {
        inputCPF.addEventListener('input', function() { mascaraCPF(this); });
    }
    
    if (inputTel) {
        inputTel.addEventListener('input', function() { mascaraTelefone(this); });
    }


    /* --- MÓDULO: LOGIN (LIMPEZA DE ESPAÇOS) --- */
    const loginForm = document.querySelector('form[action="/login/auth"]');
    
    if (loginForm) {
        const emailInput = loginForm.querySelector('input[name="email"]');
        const senhaInput = loginForm.querySelector('input[name="senha"]');

        function limparCampo(input) {
            if (input && input.value) {
                input.value = input.value.trim();
            }
        }

        // Limpa ao sair do campo (Blur) e ao colar (Paste)
        if (emailInput) {
            emailInput.addEventListener('blur', function() { limparCampo(this); });
            emailInput.addEventListener('paste', function() { 
                setTimeout(() => limparCampo(this), 10); 
            });
        }

        if (senhaInput) {
            senhaInput.addEventListener('blur', function() { limparCampo(this); });
        }

        // Garante a limpeza no momento do envio
        loginForm.addEventListener('submit', function(event) {
            limparCampo(emailInput);
            limparCampo(senhaInput);
        });
    }


    /* --- MÓDULO: VEÍCULOS (ORDENAÇÃO NA LISTAGEM) --- */
    // Arquivo: src/Views/veiculos/index.php
    const selectOrdenacao = document.getElementById('ordenacaoVeiculos');

    if (selectOrdenacao) {
        selectOrdenacao.addEventListener('change', function() {
            const valor = this.value;
            
            // Atualiza a URL mantendo os filtros de busca existentes
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('ordem', valor);
            window.location.search = urlParams.toString();
        });
    }


    /* --- MÓDULO: VEÍCULOS (PREVIEW DE FOTOS NO CADASTRO) --- */
    // Arquivo: src/Views/veiculos/create.php
    const inputFotos = document.getElementById('inputFotos');
    const preview = document.getElementById('preview-fotos');

    if (inputFotos && preview) {
        inputFotos.addEventListener('change', function() {
            const qtd = this.files.length;
            if (qtd > 0) {
                // Feedback visual verde e negrito
                preview.innerHTML = `<b class="text-success">✓ ${qtd} foto(s) selecionada(s).</b>`;
            } else {
                preview.innerHTML = "Nenhuma foto selecionada.";
            }
        });
    }

});