from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait, Select
from selenium.webdriver.support import expected_conditions as EC
import time


class AutomacaoCadastroProdutos:
    def __init__(self):
        self.driver = webdriver.Chrome()
        self.wait = WebDriverWait(self.driver, 20)

    def fazer_login(self, url, usuario, senha):
        """Realiza o login no sistema"""
        self.driver.get(url)

        # Preenche login e senha
        usuario_field = self.wait.until(EC.presence_of_element_located((By.ID, "email")))
        senha_field = self.driver.find_element(By.ID, "senha")

        usuario_field.clear()
        usuario_field.send_keys(usuario)
        time.sleep(2)  # vê o usuário sendo digitado

        senha_field.clear()
        senha_field.send_keys(senha)
        time.sleep(2)  # vê a senha sendo digitada
        
        time.sleep(2)  # espera 2 segundos antes de clicar em login

        # Clica no botão de login
        login_button = self.driver.find_element(By.ID, "login")
        login_button.click()

        # Aguarda a página principal carregar
        self.wait.until(EC.presence_of_element_located((By.ID, "estoque")))
        print("✓ Login realizado com sucesso")

    def navegar_para_cadastro_produtos(self):
        """Vai até a tela de cadastro de produtos"""
        estoque_menu = self.wait.until(EC.element_to_be_clickable((By.ID, "estoque")))
        
        time.sleep(2)  # espera 2 segundos antes de clicar 
        
        estoque_menu.click()

        cadastro_link = self.wait.until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(@href, 'cadastro_produto.php')]"))
        )
        cadastro_link.click()

        self.wait.until(EC.presence_of_element_located((By.ID, "nome")))
        print("✓ Página de cadastro de produtos aberta")

    def preencher_formulario(self, dados_produto):
        """Preenche o formulário de cadastro"""
        Select(self.driver.find_element(By.ID, "id_fornecedor")).select_by_value(str(dados_produto['id_fornecedor']))
        Select(self.driver.find_element(By.ID, "tipo")).select_by_visible_text(dados_produto['tipo'])

        self.driver.find_element(By.ID, "nome").send_keys(dados_produto['nome'])
        
        time.sleep(1)  # espera 1 segundos antes de enviar 
        
        self.driver.find_element(By.ID, "aparelho_utilizado").send_keys(dados_produto['aparelho_utilizado'])
        
        time.sleep(1)  # espera 1 segundos antes de enviar 
         
        self.driver.find_element(By.ID, "quantidade").send_keys(str(dados_produto['quantidade']))
        
        time.sleep(1)  # espera 1 segundos antes de enviar 
         
        self.driver.find_element(By.ID, "preco").send_keys(str(dados_produto['preco']))
        
        time.sleep(1)  # espera 1 segundos antes de enviar 
         
        self.driver.find_element(By.ID, "descricao").send_keys(dados_produto['descricao'])
        
        time.sleep(1)  # espera 1 segundos antes de enviar 

        print("✓ Formulário preenchido")

    def submeter_formulario(self):
        """Envia o formulário"""
        submit_button = self.driver.find_element(By.XPATH, "//button[@type='submit']")
        submit_button.click()

        # Aguarda mensagem de sucesso
        self.wait.until(EC.presence_of_element_located((By.CLASS_NAME, "alert-success")))
        print("✓ Produto cadastrado com sucesso")

    def executar(self, url, usuario, senha, dados_produto):
        try:
            self.fazer_login(url, usuario, senha)
            self.navegar_para_cadastro_produtos()
            self.preencher_formulario(dados_produto)
            self.submeter_formulario()
        finally:
            print("Encerrando em 10 segundos...")
            time.sleep(10)
            self.driver.quit()


# Configurações
url_sistema = "http://localhost/001Turma2024_2V1_TARDE/sa_bd_mod/sa_mod_bd/"
usuario = "pedro_gabriel@gmail.com"
senha = "30052008"

# Dados do produto
dados_produto = {
    'id_fornecedor': 1,
    'tipo': 'Peça',
    'nome': 'Placa de Vídeo NVIDIA RTX 3060',
    'aparelho_utilizado': 'Computadores Gaming e Workstations',
    'quantidade': 8,
    'preco': 1899.90,
    'descricao': 'Placa de vídeo NVIDIA GeForce RTX 3060 12GB GDDR6 com ray tracing'
}

if __name__ == "__main__":
    automacao = AutomacaoCadastroProdutos()
    automacao.executar(url_sistema, usuario, senha, dados_produto)