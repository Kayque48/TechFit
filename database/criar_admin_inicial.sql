-- Query para criar o administrador inicial
-- Execute esta query no MySQL para criar o primeiro admin
-- Senha: admin123 (você pode alterar depois)

USE TECHFIT_DB;

-- Inserir administrador inicial
-- Senha já está em hash (admin123)
INSERT INTO ADMINISTRACAO (AUSER, EMAIL_ADM, SENHA) 
VALUES (
    'admin', 
    'admin@techfit.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
);

-- Verificar se foi inserido
SELECT * FROM ADMINISTRACAO WHERE AUSER = 'admin';

-- IMPORTANTE: A senha é 'admin123'
-- Após o primeiro login, recomenda-se alterar a senha