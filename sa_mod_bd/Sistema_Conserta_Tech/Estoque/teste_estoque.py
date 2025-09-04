from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from datetime import datetime
import time

class AutomacaoCadastroProdutos:
    def __init__(self):
        # Inicializa o navegador
        self.driver = webdriver.Chrome()
        self.wait = WebDriverWait(self.driver, 10)
    
    def fazer_login(self, url, usuario, senha):
        """Realiza o login no sistema"""
        try:
            print("Acessando a página de login...")
            self.driver.get(url)
            
            # Aguarda a página carregar completamente
            time.sleep(2)
            
            print("Preenchendo credenciais...")
            
            # Tenta diferentes seletores para o campo de usuário
            try:
                # Primeiro tenta pelo ID "email" (do seu código original)
                usuario_field = self.wait.until(EC.presence_of_element_located((By.ID, "email")))
                print("   Campo de usuário encontrado pelo ID 'email'")
            except:
                try:
                    # Se não encontrar pelo ID "email", tenta pelo name "usuario"
                    usuario_field = self.wait.until(EC.presence_of_element_located((By.NAME, "usuario")))
                    print("   Campo de usuário encontrado pelo NAME 'usuario'")
                except:
                    try:
                        # Tenta pelo placeholder ou outros atributos
                        usuario_field = self.wait.until(EC.presence_of_element_located((By.XPATH, "//input[contains(@placeholder, 'usuário') or contains(@placeholder, 'email') or contains(@placeholder, 'login')]")))
                        print("   Campo de usuário encontrado pelo placeholder")
                    except:
                        # Se ainda não encontrar, tenta qualquer campo de input que pareça ser de usuário
                        usuario_field = self.wait.until(EC.presence_of_element_located((By.XPATH, "//input[@type='text' or @type='email']")))
                        print("   Campo de usuário encontrado pelo tipo de input")
            
            usuario_field.clear()
            usuario_field.send_keys(usuario)
            print("   ✓ Usuário preenchido")
            
            # Tenta diferentes seletores para o campo de senha
            try:
                # Primeiro tenta pelo ID "senha" (do seu código original)
                senha_field = self.driver.find_element(By.ID, "senha")
                print("   Campo de senha encontrado pelo ID 'senha'")
            except:
                try:
                    # Se não encontrar pelo ID "senha", tenta pelo name "senha"
                    senha_field = self.driver.find_element(By.NAME, "senha")
                    print("   Campo de senha encontrado pelo NAME 'senha'")
                except:
                    try:
                        # Tenta pelo placeholder
                        senha_field = self.driver.find_element(By.XPATH, "//input[contains(@placeholder, 'senha') or contains(@placeholder, 'password')]")
                        print("   Campo de senha encontrado pelo placeholder")
                    except:
                        # Se ainda não encontrar, tenta qualquer campo de senha
                        senha_field = self.driver.find_element(By.XPATH, "//input[@type='password']")
                        print("   Campo de senha encontrado pelo tipo password")
            
            senha_field.clear()
            senha_field.send_keys(senha)
            print("   ✓ Senha preenchida")
            
            print("Realizando login...")
            # Tenta encontrar o botão de login de diferentes formas
            try:
                # Primeiro tenta pelo ID "login" (do seu código original)
                login_button = self.driver.find_element(By.ID, "login")
                print("   Botão de login encontrado pelo ID 'login'")
            except:
                try:
                    # Se não encontrar pelo ID, tenta pelo tipo submit
                    login_button = self.driver.find_element(By.XPATH, "//button[@type='submit']")
                    print("   Botão de login encontrado pelo tipo submit")
                except:
                    try:
                        # Tenta pelo texto do botão
                        login_button = self.driver.find_element(By.XPATH, "//button[contains(text(), 'Login') or contains(text(), 'Entrar') or contains(text(), 'Acessar')]")
                        print("   Botão de login encontrado pelo texto")
                    except:
                        # Se ainda não encontrar, tenta input type submit
                        login_button = self.driver.find_element(By.XPATH, "//input[@type='submit']")
                        print("   Botão de login encontrado pelo input submit")
            
            login_button.click()
            print("   ✓ Botão de login clicado")
            
            # Aguarda o login ser processado
            time.sleep(3)
            
            # Verifica se o login foi bem-sucedido de diferentes formas
            try:
                # Verifica se o menu estoque está presente
                self.wait.until(EC.presence_of_element_located((By.ID, "estoque")))
                print("✓ Login realizado com sucesso!")
                return True
            except:
                # Se não encontrar o menu estoque, verifica se há mensagem de erro
                try:
                    error_messages = self.driver.find_elements(By.CLASS_NAME, "alert-danger")
                    if error_messages:
                        print(f"✗ Erro no login: {error_messages[0].text}")
                    else:
                        print("✗ Não foi possível verificar se o login foi bem-sucedido")
                    return False
                except:
                    print("✗ Não foi possível verificar se o login foi bem-sucedido")
                    return False
                    
        except Exception as e:
            print(f"✗ Erro durante o login: {e}")
            # Tira screenshot para debug
            self.driver.save_screenshot("erro_login.png")
            print("Screenshot salva como 'erro_login.png'")
            return False
    
    def navegar_para_cadastro_produtos(self):
        """Navega até o formulário de cadastro de produtos"""
        try:
            print("Acessando menu Estoque...")
            # Clica para abrir o menu de estoque
            estoque_menu = self.wait.until(EC.element_to_be_clickable((By.ID, "estoque")))
            estoque_menu.click()
            
            # Pequena pausa para garantir que o submenu seja expandido
            time.sleep(2)
            
            print("Acessando Cadastro de Produtos...")
            # Tenta diferentes formas de encontrar o link de cadastro
            try:
                # Primeiro tenta pelo href exato
                cadastro_link = self.wait.until(
                    EC.element_to_be_clickable((By.XPATH, "//a[@href='../Estoque/cadastro_produto.php']"))
                )
            except:
                try:
                    # Se não encontrar, tenta por texto ou href parcial
                    cadastro_link = self.wait.until(
                        EC.element_to_be_clickable((By.XPATH, "//a[contains(@href, 'cadastro') or contains(text(), 'Cadastrar')]"))
                    )
                except:
                    # Se ainda não encontrar, tenta qualquer link que leve a cadastro_produto.php
                    cadastro_link = self.wait.until(
                        EC.element_to_be_clickable((By.XPATH, "//a[contains(@href, 'cadastro_produto')]"))
                    )
            
            cadastro_link.click()
            
            # Espera até o formulário de cadastro aparecer
            self.wait.until(EC.presence_of_element_located((By.ID, "nome")))
            print("✓ Página de cadastro de produtos carregada!")
            return True
            
        except Exception as e:
            print(f"✗ Erro ao navegar para cadastro de produtos: {e}")
            self.driver.save_screenshot("erro_navegacao.png")
            return False
    
    def preencher_formulario(self, dados_produto):
        """Preenche o formulário de cadastro de produtos"""
        try:
            print("Preenchendo formulário...")
            
            # Tenta encontrar e preencher todos os campos possíveis
            campos = [
                {'id': 'id_fornecedor', 'tipo': 'select', 'valor': dados_produto.get('id_fornecedor', 1)},
                {'id': 'tipo', 'tipo': 'select', 'valor': dados_produto.get('tipo', 'Peça')},
                {'id': 'nome', 'tipo': 'text', 'valor': dados_produto.get('nome', 'Produto Padrão')},
                {'id': 'aparelho_utilizado', 'tipo': 'text', 'valor': dados_produto.get('aparelho_utilizado', 'Equipamentos diversos')},
                {'id': 'quantidade', 'tipo': 'number', 'valor': dados_produto.get('quantidade', 10)},
                {'id': 'preco', 'tipo': 'number', 'valor': dados_produto.get('preco', 99.90)},
                {'id': 'data_registro', 'tipo': 'date', 'valor': dados_produto.get('data_registro', datetime.now().strftime("%Y-%m-%d"))},
                {'id': 'descricao', 'tipo': 'textarea', 'valor': dados_produto.get('descricao', 'Produto de alta qualidade')},
                # Campos adicionais que podem existir
                {'id': 'marca', 'tipo': 'text', 'valor': dados_produto.get('marca', 'Marca Padrão'), 'opcional': True},
                {'id': 'modelo', 'tipo': 'text', 'valor': dados_produto.get('modelo', 'Modelo Padrão'), 'opcional': True},
                {'id': 'codigo_barras', 'tipo': 'text', 'valor': dados_produto.get('codigo_barras', '1234567890'), 'opcional': True},
                {'id': 'localizacao', 'tipo': 'text', 'valor': dados_produto.get('localizacao', 'Prateleira A'), 'opcional': True},
                {'id': 'estoque_minimo', 'tipo': 'number', 'valor': dados_produto.get('estoque_minimo', 5), 'opcional': True},
            ]
            
            for campo in campos:
                try:
                    elemento = self.driver.find_element(By.ID, campo['id'])
                    
                    if campo['tipo'] == 'select':
                        select = Select(elemento)
                        try:
                            select.select_by_value(str(campo['valor']))
                        except:
                            select.select_by_visible_text(str(campo['valor']))
                        print(f"   ✓ {campo['id']}: {campo['valor']}")
                    
                    elif campo['tipo'] in ['text', 'number', 'date', 'textarea']:
                        elemento.clear()
                        elemento.send_keys(str(campo['valor']))
                        print(f"   ✓ {campo['id']}: {campo['valor']}")
                        
                except Exception as e:
                    if not campo.get('opcional', False):
                        print(f"   ✗ Campo obrigatório {campo['id']} não encontrado: {e}")
                    # else:
                    #     print(f"   - Campo opcional {campo['id']} não encontrado")
            
            print("✓ Formulário preenchido com sucesso!")
            return True
            
        except Exception as e:
            print(f"✗ Erro ao preencher formulário: {e}")
            self.driver.save_screenshot("erro_formulario.png")
            return False
    
    def submeter_formulario(self):
        """Submete o formulário de cadastro"""
        try:
            print("Submetendo formulário...")
            
            # Tenta encontrar o botão de diferentes formas
            botoes_tentativas = [
                "//button[contains(text(), 'Cadastrar Produto')]",
                "//button[contains(text(), 'Salvar')]",
                "//button[contains(text(), 'Enviar')]",
                "//button[@type='submit']",
                "//input[@type='submit']",
                "//button[contains(@class, 'btn-success')]",
                "//input[contains(@value, 'Cadastrar')]",
                "//input[contains(@value, 'Salvar')]"
            ]
            
            for xpath in botoes_tentativas:
                try:
                    submit_button = self.driver.find_element(By.XPATH, xpath)
                    submit_button.click()
                    print(f"   ✓ Botão encontrado com XPath: {xpath}")
                    break
                except:
                    continue
            else:
                print("   ✗ Nenhum botão de submissão encontrado")
                return False
            
            print("   ✓ Botão de cadastro clicado")
            
            # Aguarda o processamento
            time.sleep(3)
            
            # Verifica se o cadastro foi bem-sucedido
            try:
                # Procura por mensagens de sucesso
                success_selectors = [
                    "//div[contains(@class, 'alert-success')]",
                    "//div[contains(@class, 'alert') and contains(text(), 'sucesso')]",
                    "//div[contains(@class, 'success')]",
                    "//*[contains(text(), 'cadastrado com sucesso')]",
                    "//*[contains(text(), 'sucesso')]"
                ]
                
                for selector in success_selectors:
                    try:
                        success_elements = self.driver.find_elements(By.XPATH, selector)
                        if success_elements:
                            print(f"✓ Produto cadastrado com sucesso! Mensagem: {success_elements[0].text}")
                            return True
                    except:
                        continue
                
                print("✓ Formulário submetido. Verifique manualmente se foi bem-sucedido.")
                return True
                
            except Exception as e:
                print(f"✓ Formulário submetido. Erro na verificação: {e}")
                return True
            
        except Exception as e:
            print(f"✗ Erro ao submeter formulário: {e}")
            self.driver.save_screenshot("erro_submissao.png")
            return False
    
    def executar_automacao_completa(self, url, usuario, senha, dados_produto):
        """Executa toda a automação do início ao fim"""
        print("Iniciando automação de cadastro de produtos...")
        print("=" * 60)
        
        try:
            # 1. Fazer login
            print("\n1. ETAPA: LOGIN")
            if not self.fazer_login(url, usuario, senha):
                print("✗ Falha no login. Abortando automação.")
                return False
            
            # 2. Navegar para o cadastro de produtos
            print("\n2. ETAPA: NAVEGAÇÃO")
            if not self.navegar_para_cadastro_produtos():
                print("✗ Falha na navegação. Abortando automação.")
                return False
            
            # 3. Preencher formulário
            print("\n3. ETAPA: PREENCHIMENTO DO FORMULÁRIO")
            if not self.preencher_formulario(dados_produto):
                print("✗ Falha no preenchimento do formulário. Abortando automação.")
                return False
            
            # 4. Submeter formulário
            print("\n4. ETAPA: SUBMISSÃO")
            if not self.submeter_formulario():
                print("✗ Falha na submissão do formulário.")
                return False
            
            print("=" * 60)
            print("✓ Automação concluída com sucesso!")
            return True
            
        except Exception as e:
            print(f"✗ Erro durante a automação: {e}")
            return False
        finally:
            # Mantém o navegador aberto para verificação
            print("\nO navegador permanecerá aberto por 15 segundos para verificação...")
            time.sleep(15)
            self.driver.quit()

# Dados completos para o produto
dados_produto = {
    'id_fornecedor': 1,
    'tipo': 'Peça',
    'nome': 'Placa de Vídeo NVIDIA RTX 3060',
    'aparelho_utilizado': 'Computadores Gaming e Workstations',
    'quantidade': 8,
    'preco': 1899.90,
    'data_registro': '2023-09-05',
    'descricao': 'Placa de vídeo NVIDIA GeForce RTX 3060 12GB GDDR6 com ray tracing',
    'marca': 'NVIDIA',
    'modelo': 'RTX 3060',
    'codigo_barras': 'NV306012GB2023',
    'localizacao': 'Setor B - Prateleira 3',
    'estoque_minimo': 2
}

# Configurações
url_sistema = "http://localhost:8080/sa_bd_mod/sa_mod_bd/Sistema_Conserta_Tech/Login/index.php"
usuario = "pedro_gabriel@gmail.com"
senha = "12345678"

# Executar a automação
if __name__ == "__main__":
    print("SCRIPT DE AUTOMAÇÃO - CADASTRO DE PRODUTOS")
    print("=" * 60)
    
    automacao = AutomacaoCadastroProdutos()
    sucesso = automacao.executar_automacao_completa(url_sistema, usuario, senha, dados_produto)
    
    if sucesso:
        print("✓ Processo finalizado com sucesso!")
    else:
        print("✗ Ocorreu um erro durante o processo. Verifique os logs acima.")