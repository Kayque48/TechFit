
        // Interatividade para os status
        document.addEventListener('DOMContentLoaded', function() {
            const statusOptions = document.querySelectorAll('.status-option');
            
            statusOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove a classe selected de todos
                    statusOptions.forEach(opt => opt.classList.remove('selected'));
                    // Adiciona a classe selected ao clicado
                    this.classList.add('selected');
                });
            });

            // Validação do formulário
            document.getElementById('productForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const productName = document.getElementById('productName').value;
                const productPrice = document.getElementById('productPrice').value;
                
                if (!productName || !productPrice) {
                    alert('Por favor, preencha todos os campos obrigatórios!');
                    return;
                }
                
                // Simulação de cadastro bem-sucedido
                alert('Produto cadastrado com sucesso!');
                this.reset();
                
                // Reset do status para Ativo
                statusOptions.forEach(opt => opt.classList.remove('selected'));
                document.querySelector('.status-active').classList.add('selected');
            });
        });