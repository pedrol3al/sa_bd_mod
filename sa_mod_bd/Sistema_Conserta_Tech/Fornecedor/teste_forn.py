from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

driver = webdriver.Chrome()

driver.get("http://localhost:8080/sa_bd_mod/sa_mod_bd/Sistema_Conserta_Tech/Fornecedor/front_fornecedor.php")


razao_social = driver.find_element(By. ID, "razao_social_forn")
razao_social.send_keys("Distruibuidora de telas")

cnpj_forn = driver.find_element(By. ID, "cnpj_forn")
cnpj_forn.send_keys("Tela de celular")

dataFundacao_forn = driver.find_element(By.ID, "dataFundacao_forn")
dataFundacao_forn.send_keys("30/05/25")

telefone_forn = driver.find_element(By.ID, "telefone_forn")
telefone_forn.send_keys("47 98757-9428")

email_forn = driver.find_element(By.ID, "email_forn")
email_forn.send_keys("distruibuidora@gmail.com")

cep_forn = driver.find_element(By.ID, "cep_forn")
cep_forn.send_keys("33231-00")

logradouro_forn = driver.find_element(By.ID, "logradouro_forn")
logradouro_forn.send_keys("Rua de asfalto")

tipo_estabelecimento_forn = driver.find_element(By.ID, "tipo_estabelecimento_forn")

select_estabelecimento = Select(tipo_estabelecimento_forn)

select_estabelecimento.select_by_value("R")

cep_forn = driver.find_element(By.ID, "cep_forn")
cep_forn.send_keys("33231-00")

cep_forn = driver.find_element(By.ID, "cep_forn")
cep_forn.send_keys("33231-00")

cep_forn = driver.find_element(By.ID, "cep_forn")
cep_forn.send_keys("33231-00")

cep_forn = driver.find_element(By.ID, "cep_forn")
cep_forn.send_keys("33231-00")

cep_forn = driver.find_element(By.ID, "cep_forn")
cep_forn.send_keys("33231-00")

cep_forn = driver.find_element(By.ID, "cep_forn")
cep_forn.send_keys("33231-00")

cep_forn = driver.find_element(By.ID, "cep_forn")
cep_forn.send_keys("33231-00")

submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
# submit_button.click()

time.sleep(8)

driver.quit()