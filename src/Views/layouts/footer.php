<div class="mt-5"></div>

<footer class="bg-dark text-white py-5 mt-auto border-top border-secondary">
    <div class="container">
        <div class="row gy-4">
            
            <div class="col-md-3 text-center text-md-start">
                <h5 class="text-uppercase fw-bold text-warning mb-3">
                    <i class="fas fa-car me-2"></i>AutoNível
                </h5>
                <p class="small text-white-50">
                    A melhor opção para comprar seu carro novo ou seminovo com garantia e procedência.
                </p>
                <small class="text-white-50 d-block mt-3">
                    © <?= date('Y') ?> Todos os direitos reservados.
                </small>
            </div>

            <div class="col-md-3 text-center">
                <h6 class="text-uppercase fw-bold text-white mb-3">Fale Conosco</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="https://wa.me/5537991923096" target="_blank" class="text-white text-decoration-none hover-warning">
                            <i class="fab fa-whatsapp text-success me-2"></i> (37) 99192-3096
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="https://wa.me/5537999592879" target="_blank" class="text-white text-decoration-none hover-warning">
                            <i class="fab fa-whatsapp text-success me-2"></i> (37) 99959-2879
                        </a>
                    </li>
                    <li class="small text-white-50 mt-2">
                        <i class="fas fa-clock me-1"></i> Seg a Sex: 08h às 18h
                    </li>
                </ul>
            </div>

            <div class="col-md-3 text-center">
                <h6 class="text-uppercase fw-bold text-white mb-3">Siga-nos</h6>
                <p class="small text-white-50">Novidades e ofertas exclusivas no Instagram.</p>
                <a href="https://www.instagram.com/auto.nivelmultimarcas/" target="_blank" class="btn btn-outline-warning btn-sm fw-bold">
                    <i class="fab fa-instagram me-2"></i> @autonivelmultimarcas
                </a>
            </div>

            <div class="col-md-3 text-center text-md-end">
                <h6 class="text-uppercase fw-bold text-white mb-3">Onde Estamos</h6>
                <div class="rounded overflow-hidden shadow-sm" style="height: 120px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d935.5554525891041!2d-45.54029827153604!3d-20.29108399881884!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94b488c0a963191f%3A0x1a6c5dd6cbbdd45e!2sAUTON%C3%8DVEL%20MULTIMARCAS!5e0!3m2!1spt-BR!2sbr!4v1768568127476!5m2!1spt-BR!2sbr" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</footer>

<style>
    .hover-warning:hover {
        color: #ffc107 !important; /* Amarelo conforme solicitado */
        transition: color 0.3s;
    }
    /* Ajuste para o mapa não ficar muito grande em telas menores */
    @media (max-width: 768px) {
        iframe { height: 150px; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/main.js"></script>

</body>
</html>