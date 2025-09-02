from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

# Inicializa o navegador
driver = webdriver.Chrome()

# Abre a página de login
driver.get("http://localhost:8080/sa_bd_mod/sa_mod_bd/Sistema_Conserta_Tech/Login/index.php")

# Preenche login
driver.find_element(By.ID, "email").send_keys("pedro_gabriel@gmail.com")
driver.find_element(By.ID, "senha").send_keys("12345678")
driver.find_element(By.ID, "login").click()

# Espera a página principal carregar e o menu de estoque aparecer
WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.ID, "estoque"))
)

# Clica para abrir o submenu de estoque
driver.find_element(By.ID, "estoque").click()
time.sleep(1)  # espera o submenu abrir

# Clica em "Cadastrar Estoque"
driver.find_element(By.XPATH, "//a[contains(@href,'cadastrar_estoque.php')]").click()

# Espera até o formulário de cadastro aparecer
WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.ID, "nome_peca"))
)

# Preenche o formulário
driver.find_element(By.ID, "id_usuario").send_keys("1")
driver.find_element(By.ID, "nome_peca").send_keys("Parafuso inox 5cm")
driver.find_element(By.ID, "id_fornecedor").send_keys("2")
driver.find_element(By.ID, "cadPeca").send_keys("2025-09-02")
driver.find_element(By.ID, "quantidade").send_keys("100")
driver.find_element(By.ID, "valor_unit").send_keys("5.50")
driver.find_element(By.ID, "descricao").send_keys("Parafuso inox para montagem de equipamentos")

# Clica no botão cadastrar
driver.find_element(By.ID, "enviar").click()

# Pequeno delay para confirmar o envio
time.sleep(99)
print("Formulário de cadastro de estoque enviado!")

# Fechar navegador
# driver.quit()
